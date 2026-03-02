<?php

namespace App\Http\Controllers\second_part;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\Sample;
use App\Models\second_part\Frequency;
use App\Models\second_part\SampleRoutineScheduler;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SampleRoutineSchedulerController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $this->authorize('all_sample_routine_scheduler');

        // Load submissions with relationships including scheduler items
        $submissions = SampleRoutineScheduler::with([
            'plant',
            'sub_plant',
            'sample.sample_plant',
            'sample_routine_scheduler_items.result'
        ])
            ->orderBy("created_at", "desc")
            ->paginate(10);

        // Ensure all records have submission_number (fallback for old records)
        foreach ($submissions as $submission) {
            if (!$submission->submission_number) {
                $submission->submission_number = 'SCH-' . str_pad($submission->id, 6, '0', STR_PAD_LEFT);
                $submission->save();
            }
        }

        return view("second_part.schedule.index", compact("submissions"));
    }

    public function create(Request $request)
    {
        $this->authorize('create_sample_routine_scheduler');

        $plants = Plant::select('id', 'name', 'plant_id')->whereNull('plant_id')->get();
        $frequencies = Frequency::select('id', 'name')->get();

        $data = [
            'plants' => $plants,
            'frequencies' => $frequencies,
        ];

        return view('second_part.schedule.create', $data);
    }

    /**
     * Store a new schedule routine.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create_sample_routine_scheduler');

        $request->validate([
            'plant_id' => ['required', 'exists:plants,id'],
            'sub_plant_id' => ['nullable', 'exists:plants,id'],
            'sample_points' => ['required', 'array', 'min:1'],
            'sample_points.*' => ['required', 'exists:samples,id'],
        ], [
            'sample_points.required' => __('validation.required', ['attribute' => __('samples.sample_points')]),
            'sample_points.min' => __('validation.min.array', ['attribute' => __('samples.sample_points'), 'min' => 1]),
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->sample_points as $samplePointId) {
                // Validate sample exists
                $sample = Sample::find($samplePointId);
                if (!$sample) {
                    throw new Exception("Sample with ID {$samplePointId} not found");
                }

                $scheduleRouting = SampleRoutineScheduler::create([
                    'plant_id' => $request->plant_id,
                    'sub_plant_id' => $request->sub_plant_id,
                    'sample_id' => $samplePointId,
                    'status' => 'pending', // Set default status
                ]);

                // Generate submission_number exactly like submission
                $scheduleRouting->submission_number = 'SCH-' . str_pad($scheduleRouting->id, 6, '0', STR_PAD_LEFT);
                $scheduleRouting->save();

                // Log for debugging
                Log::info('Created schedule with submission_number', [
                    'id' => $scheduleRouting->id,
                    'submission_number' => $scheduleRouting->submission_number
                ]);

                // Get test methods for this sample point
                $testMethodIds = $this->extractTestMethodIds($request, $samplePointId);

                if (empty($testMethodIds)) {
                    Log::warning("No test methods selected for sample point: {$samplePointId}");
                    continue;
                }

                // Create schedule routine items
                foreach ($testMethodIds as $testMethodId) {
                    $frequencyId = $this->getFrequencyId($request, $samplePointId, $testMethodId);
                    $scheduleHour = $this->getScheduleHour($request, $samplePointId, $testMethodId);

                    $scheduleRouting->sample_routine_scheduler_items()->create([
                        'sample_id' => $samplePointId,
                        'plant_id' => $request->plant_id,
                        'sub_plant_id' => $request->sub_plant_id,
                        'frequency_id' => $frequencyId,
                        'schedule_hour' => $scheduleHour,
                        'test_method_ids' => $testMethodId,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.submission.schedule')->with('success', translate('created_successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating schedule routine: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token'])
            ]);
            return back()->with('error', translate('something_went_wrong'))->withInput();
        }
    }

    /**
     * Extract test method IDs from request for a given sample point.
     *
     * @param Request $request
     * @param int $samplePointId
     * @return array
     */
    protected function extractTestMethodIds(Request $request, int $samplePointId): array
    {
        $testMethodIds = [];

        // Format 1: test_method_id[sample_id][]
        if (isset($request->test_method_id[$samplePointId]) && is_array($request->test_method_id[$samplePointId])) {
            $testMethodIds = array_merge($testMethodIds, $request->test_method_id[$samplePointId]);
        }

        // Format 2: test_method_id-sample_id-* (for sub_plant - backward compatibility)
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'test_method_id-') && str_contains($key, "-{$samplePointId}-")) {
                $parts = explode('-', $key);
                if (count($parts) >= 3 && $parts[2] == $samplePointId) {
                    $testMethodIds[] = $value;
                }
            }
        }

        return array_unique(array_filter($testMethodIds));
    }

    /**
     * Get frequency ID from request.
     *
     * @param Request $request
     * @param int $samplePointId
     * @param int $testMethodId
     * @return int|null
     */
    protected function getFrequencyId(Request $request, int $samplePointId, int $testMethodId): ?int
    {
        // New format: frequency_id-{sample_id}-{test_method_id}
        $key = "frequency_id-{$samplePointId}-{$testMethodId}";
        if ($request->has($key)) {
            return (int) $request->input($key);
        }

        // Old format: frequency_id[{sample_id}][{test_method_id}]
        if (isset($request->frequency_id[$samplePointId][$testMethodId])) {
            return (int) $request->frequency_id[$samplePointId][$testMethodId];
        }

        return null;
    }

    /**
     * Get schedule hour from request.
     *
     * @param Request $request
     * @param int $samplePointId
     * @param int $testMethodId
     * @return string|null
     */
    protected function getScheduleHour(Request $request, int $samplePointId, int $testMethodId): ?string
    {
        // New format: schedule_hour-{sample_id}-{test_method_id}
        $key = "schedule_hour-{$samplePointId}-{$testMethodId}";
        if ($request->has($key)) {
            return $request->input($key);
        }

        // Old format: schedule_hour[{sample_id}][{test_method_id}]
        if (isset($request->schedule_hour[$samplePointId][$testMethodId])) {
            return $request->schedule_hour[$samplePointId][$testMethodId];
        }

        return null;
    }

    public function edit($id)
    {
        $schedule_routing = SampleRoutineScheduler::with('sample_routine_scheduler_items')->findOrFail($id);
        $plants = Plant::select('id', 'name', 'plant_id')->whereNull('plant_id')->get();
        $frequencies = Frequency::select('id', 'name')->get();
        $data = [
            'plants' => $plants,
            'frequencies' => $frequencies,
            'schedule_routing' => $schedule_routing,
        ];
        return view('second_part.schedule.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit_sample_routine_scheduler');

        $schedule_routing = SampleRoutineScheduler::findOrFail($id);

        DB::beginTransaction();
        try {
            foreach ($schedule_routing->sample_routine_scheduler_items as $sample_routine_scheduler_items) {
                // Log::info($sample_routine_scheduler_items->id);
                if (isset($request->test_method_id[$sample_routine_scheduler_items->id])) {
                    $sample_routine_scheduler_items->update([
                        'frequency_id' => $request->frequency_id[$sample_routine_scheduler_items->id],
                        'schedule_hour' => $request->schedule_hour[$sample_routine_scheduler_items->id],
                    ]);
                } else {
                    $sample_routine_scheduler_items->delete();
                }
            }

            DB::commit();
            return to_route('admin.submission.schedule')->with('success', translate('updated_successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating schedule routine: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id' => $id
            ]);
            return back()->with('error', translate('something_went_wrong'))->withInput();
        }
    }

    public function delete($id)
    {
        $this->authorize('delete_sample_routine_scheduler');

        DB::beginTransaction();
        try {
            $schedule_routing = SampleRoutineScheduler::findOrFail($id);
            $schedule_routing->sample_routine_scheduler_items()->delete();
            $schedule_routing->delete();

            DB::commit();
            return redirect()->route('admin.submission.schedule')->with('success', translate('deleted_successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting schedule routine: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id' => $id
            ]);
            return back()->with('error', translate('something_went_wrong'));
        }
    }

    /**
     * Get samples by plant ID with organized structure.
     * Returns main plant samples and sub plants with their samples.
     * Same logic as submission - simplified and working.
     *
     * @param int $id Plant ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_sample_by_plant_id($id)
    {
        try {
            // Check if this is a sub plant (has plant_id != null) or main plant
            $plant = Plant::findOrFail($id);
            $isSubPlant = $plant->plant_id !== null;

            if ($isSubPlant) {
                // If it's a sub plant, get samples directly for this sub plant
                $samples = Sample::where('sub_plant_id', $id)
                    ->with([
                        'test_methods' => function ($query) {
                            $query->with('master_test_method');
                        },
                        'sample_plant'
                    ])
                    ->get();

                $formattedSamples = $samples->map(function ($sample) {
                    return $this->formatSampleData($sample);
                })->toArray();

                $result = [
                    'main_plant' => [
                        'id' => $plant->id,
                        'name' => $plant->name,
                        'samples' => []
                    ],
                    'sub_plants' => [
                        [
                            'id' => $plant->id,
                            'name' => $plant->name,
                            'samples' => $formattedSamples
                        ]
                    ]
                ];
            } else {
                // If it's a main plant, get samples for main plant and all sub plants
                $samples = Sample::where('plant_id', $id)
                    ->orWhere('sub_plant_id', $id)
                    ->with([
                        'test_methods' => function ($query) {
                            $query->with('master_test_method');
                        },
                        'sample_plant'
                    ])
                    ->get();

                // Separate main plant samples and sub plant samples
                $mainPlantSamples = $samples->where('plant_id', $id)->whereNull('sub_plant_id')->values();
                $subPlantSamplesGrouped = $samples->whereNotNull('sub_plant_id')->groupBy('sub_plant_id');

                // Get sub plants for this main plant
                $subPlants = Plant::where('plant_id', $id)->get()->keyBy('id');

                // Format main plant samples
                $formattedMainSamples = $mainPlantSamples->map(function ($sample) {
                    return $this->formatSampleData($sample);
                })->toArray();

                // Format sub plant samples
                $formattedSubPlants = [];
                foreach ($subPlantSamplesGrouped as $subPlantId => $subPlantSamples) {
                    $subPlant = $subPlants->get($subPlantId);
                    if ($subPlant && $subPlantSamples->isNotEmpty()) {
                        $formattedSubPlants[] = [
                            'id' => $subPlant->id,
                            'name' => $subPlant->name,
                            'samples' => $subPlantSamples->map(function ($sample) {
                                return $this->formatSampleData($sample);
                            })->values()->toArray()
                        ];
                    }
                }

                $result = [
                    'main_plant' => [
                        'id' => $plant->id,
                        'name' => $plant->name,
                        'samples' => $formattedMainSamples
                    ],
                    'sub_plants' => $formattedSubPlants
                ];
            }

            // Log for debugging
            Log::info('Samples loaded for plant', [
                'plant_id' => $id,
                'is_sub_plant' => $isSubPlant,
                'main_plant_samples_count' => count($result['main_plant']['samples']),
                'sub_plants_count' => count($result['sub_plants']),
                'total_samples' => count($result['main_plant']['samples']) + array_sum(array_map(function ($sp) {
                    return count($sp['samples']);
                }, $result['sub_plants']))
            ]);

            return response()->json([
                'success' => true,
                'status' => 200,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching samples by plant ID: ' . $e->getMessage(), [
                'plant_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => translate('error_loading_data'),
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Load samples with test methods.
     *
     * @param int|null $plantId
     * @param int|null $subPlantId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function loadSamplesWithTestMethods(?int $plantId, ?int $subPlantId)
    {
        $query = Sample::query();

        if ($plantId && !$subPlantId) {
            $query->where('plant_id', $plantId)->whereNull('sub_plant_id');
        } elseif ($subPlantId) {
            $query->where('sub_plant_id', $subPlantId);
        } else {
            // If no conditions, return empty collection
            return collect([]);
        }

        $samples = $query->with([
            'test_methods' => function ($query) {
                $query->with('master_test_method');
            },
            'sample_plant'
        ])->get();

        // Log for debugging
        Log::info('Loaded samples', [
            'plant_id' => $plantId,
            'sub_plant_id' => $subPlantId,
            'count' => $samples->count(),
            'sample_ids' => $samples->pluck('id')->toArray()
        ]);

        return $samples;
    }

    /**
     * Format samples collection for JSON response.
     *
     * @param \Illuminate\Database\Eloquent\Collection $samples
     * @return array
     */
    protected function formatSamples($samples): array
    {
        return $samples->map(function ($sample) {
            return $this->formatSampleData($sample);
        })->values()->toArray();
    }

    /**
     * Format sample data for JSON response.
     *
     * @param Sample $sample
     * @return array
     */
    protected function formatSampleData($sample): array
    {
        // Ensure relationships are loaded
        if (!$sample->relationLoaded('test_methods')) {
            $sample->load(['test_methods.master_test_method']);
        }

        // Format test methods - ensure we only include methods with valid master_test_method
        $testMethods = [];
        if ($sample->test_methods && $sample->test_methods->isNotEmpty()) {
            foreach ($sample->test_methods as $testMethod) {
                // Reload master_test_method if needed
                if (!$testMethod->relationLoaded('master_test_method')) {
                    $testMethod->load('master_test_method');
                }

                // Only include if master_test_method exists
                if ($testMethod->master_test_method && $testMethod->master_test_method->id) {
                    $testMethods[] = [
                        'id' => $testMethod->id,
                        'test_method_id' => $testMethod->test_method_id,
                        'master_test_method' => [
                            'id' => $testMethod->master_test_method->id,
                            'name' => $testMethod->master_test_method->name ?? 'Unknown',
                        ],
                    ];
                } else {
                    // Log missing master_test_method for debugging
                    Log::warning('Test method without master_test_method', [
                        'sample_id' => $sample->id,
                        'test_method_id' => $testMethod->id,
                        'test_method_test_method_id' => $testMethod->test_method_id
                    ]);
                }
            }
        }

        return [
            'id' => $sample->id,
            'sub_plant_id' => $sample->sub_plant_id,
            'plant_id' => $sample->plant_id,
            'plant_sample_id' => $sample->plant_sample_id,
            'sample_plant' => $sample->sample_plant ? [
                'id' => $sample->sample_plant->id,
                'name' => $sample->sample_plant->name ?? 'Unknown',
            ] : null,
            'test_methods' => $testMethods
        ];
    }

    /**
     * Update status by barcode (receipt).
     * Same logic as submission - exactly matching.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatusByBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        // Trim barcode - exactly like submission
        $barcode = trim($request->barcode);

        // Search exactly like submission does
        $schedule = SampleRoutineScheduler::where('submission_number', $barcode)->first();

        // Fallback: if not found, try to find by ID and create submission_number if missing
        if (!$schedule) {
            // Try to extract ID from barcode format SCH-000001
            if (str_starts_with($barcode, 'SCH-')) {
                $id = (int) str_replace('SCH-', '', $barcode);
                if ($id > 0) {
                    $schedule = SampleRoutineScheduler::find($id);
                }
            }

            // If still not found and barcode is numeric, try direct ID lookup
            if (!$schedule && is_numeric($barcode)) {
                $schedule = SampleRoutineScheduler::find((int) $barcode);
            }

            // If found but missing submission_number, create it
            if ($schedule && !$schedule->submission_number) {
                $schedule->submission_number = 'SCH-' . str_pad($schedule->id, 6, '0', STR_PAD_LEFT);
                $schedule->save();
            }
        }

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => translate('barcode_not_found')
            ]);
        }

        // Update status - exactly like submission (no status check)
        $schedule->status = 'received';
        $schedule->save();

        return response()->json([
            'success' => true,
            'message' => translate('The_sample_has_been_received')
        ]);
    }

    /**
     * Show barcode scan page.
     *
     * @return \Illuminate\View\View
     */
    public function scanPage()
    {
        $this->authorize('submission_management');
        return view('second_part.schedule.read_barcode');
    }

    /**
     * Change status to start work.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatusToStartWork($id)
    {
        $this->authorize('create_result');

        $schedule = SampleRoutineScheduler::findOrFail($id);

        if ($schedule->status === 'received') {
            $schedule->status = 'in_progress';
            $schedule->save();

            return redirect()->back()->with('success', translate('work_started_successfully'));
        }

        return redirect()->back()->with('error', translate('invalid_status_transition'));
    }

    /**
     * Change status by barcode to start work.
     * Same logic as submission change_status - exactly matching.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function startWorkByBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        // Trim barcode - exactly like submission
        $barcode = trim($request->barcode);

        // Search exactly like submission does
        $schedule = SampleRoutineScheduler::where('submission_number', $barcode)->first();

        // Fallback: if not found, try to find by ID and create submission_number if missing
        if (!$schedule) {
            // Try to extract ID from barcode format SCH-000001
            if (str_starts_with($barcode, 'SCH-')) {
                $id = (int) str_replace('SCH-', '', $barcode);
                if ($id > 0) {
                    $schedule = SampleRoutineScheduler::find($id);
                }
            }

            // If still not found and barcode is numeric, try direct ID lookup
            if (!$schedule && is_numeric($barcode)) {
                $schedule = SampleRoutineScheduler::find((int) $barcode);
            }

            // If found but missing submission_number, create it
            if ($schedule && !$schedule->submission_number) {
                $schedule->submission_number = 'SCH-' . str_pad($schedule->id, 6, '0', STR_PAD_LEFT);
                $schedule->save();
            }
        }

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => translate('barcode_not_found')
            ]);
        }

        // Update status - exactly like submission (no status check)
        $schedule->status = 'in_progress';
        $schedule->save();

        return response()->json([
            'success' => true,
            'message' => translate('work_started_successfully')
        ]);
    }
}

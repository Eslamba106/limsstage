<?php

namespace App\Http\Controllers\second_part;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\Sample;
use App\Models\SampleTestMethod;
use App\Models\second_part\Submission;
use App\Models\second_part\SubmissionItem;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubmissionController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {

        $this->authorize('submission_management');

        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_submissions_status');

            Submission::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }
        if ($request->bulk_action_btn === 'delete' && is_array($ids) && count($ids)) {

            Submission::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $submissions = Submission::orderBy("created_at", "desc")->paginate(10);
        return view("second_part.submission.index", compact("submissions"));
    }

    public function create()
    {
        $this->authorize('create_sample');

        $plants = Plant::select('id', 'name', 'plant_id')->whereNull('plant_id')->get();
        $data   = [
            'plants' => $plants,
        ];
        return view("second_part.submission.create", $data);
    }

    public function store(Request $request)
    {
        $this->authorize('create_submission');

        $request->validate([
            'plant_id'                    => 'required|exists:plants,id',
            'sub_plant_id'                => 'nullable|exists:plants,id',
            'plant_sample_id'             => 'required|exists:plant_samples,id',
            'priority'                    => 'required|in:high,normal,critical',
            'sampling_date_and_time'      => 'nullable|date',
            'comment'                     => 'nullable|string|max:255',
            'sample_test_method_item_id'  => 'required|array|min:1',
            'sample_test_method_item_id.*' => 'required|exists:sample_test_methods,id',
        ], [
            'sample_test_method_item_id.required' => __('general.test_method_items_required'),
            'sample_test_method_item_id.array'    => __('general.test_method_items_must_be_array'),
            'sample_test_method_item_id.min'      => __('general.at_least_one_test_method_required'),
        ]);

        // Find the sample and validate it exists
        $sample = Sample::where('plant_sample_id', $request->plant_sample_id)->first();

        if (!$sample) {
            return back()->withErrors(['plant_sample_id' => __('general.sample_not_found')])
                ->withInput();
        }

        // Parse date only if provided
        $date = null;
        if ($request->filled('sampling_date_and_time')) {
            try {
                $date = Carbon::createFromFormat('Y-m-d\TH:i', $request->sampling_date_and_time);
            } catch (\Exception $e) {
                return back()->withErrors(['sampling_date_and_time' => __('general.invalid_date_format')])
                    ->withInput();
            }
        }

        // Use database transaction to ensure data consistency
        DB::connection('tenant')->beginTransaction();

        try {
            $submission = Submission::create([
                'plant_id'               => $request->plant_id,
                'sub_plant_id'           => $request->sub_plant_id,
                'plant_sample_id'        => $request->plant_sample_id,
                'sample_id'              => $sample->id,
                'priority'               => $request->priority,
                'sampling_date_and_time' => $date,
                'comment'                => $request->comment,
            ]);

            // Generate submission number
            $submission->submission_number = 'SUB-' . str_pad($submission->id, 6, '0', STR_PAD_LEFT);
            $submission->save();

            // Create submission items using the model relationship
            $submissionItems = collect($request->input('sample_test_method_item_id', []))
                ->map(function ($sampleTestMethodItemId) {
                    return [
                        'sample_test_method_item_id' => $sampleTestMethodItemId,
                        'created_at'                 => now(),
                        'updated_at'                 => now(),
                    ];
                })
                ->toArray();

            // Use relationship method for automatic connection handling
            if (!empty($submissionItems)) {
                $submission->submission_test_method_items()->createMany($submissionItems);
            }

            DB::connection('tenant')->commit();

            return redirect()->route('admin.submission')->with('success', __('general.created_successfully'));
        } catch (\Exception $e) {
            DB::connection('tenant')->rollBack();

            Log::error('Error creating submission: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $this->authorize('edit_submission');
        $submission = Submission::findOrFail($id);
        $plants     = Plant::select('id', 'name', 'plant_id')->whereNull('plant_id')->get();
        $data       = [
            'submission' => $submission,
            'plants'     => $plants,
        ];
        return view("second_part.submission.edit", $data);
    }
    public function update(Request $request, $id)
    {
        $this->authorize('edit_submission');

        $submission = Submission::findOrFail($id);

        $request->validate([
            'plant_id'                    => 'required|exists:plants,id',
            'sub_plant_id'                => 'nullable|exists:plants,id',
            'plant_sample_id'             => 'required|exists:plant_samples,id',
            'priority'                    => 'required|in:high,normal,critical',
            'sampling_date_and_time'      => 'nullable|date',
            'comment'                     => 'nullable|string|max:255',
            'sample_test_method_item_id'  => 'nullable|array',
            'sample_test_method_item_id.*' => 'required|exists:sample_test_methods,id',
        ]);

        // Find the sample and validate it exists
        $sample = Sample::where('plant_sample_id', $request->plant_sample_id)->first();

        if (!$sample) {
            return back()->withErrors(['plant_sample_id' => __('general.sample_not_found')])
                ->withInput();
        }

        // Parse date only if provided
        $date = null;
        if ($request->filled('sampling_date_and_time')) {
            try {
                $date = Carbon::createFromFormat('Y-m-d\TH:i', $request->sampling_date_and_time);
            } catch (\Exception $e) {
                return back()->withErrors(['sampling_date_and_time' => __('general.invalid_date_format')])
                    ->withInput();
            }
        }

        // Use database transaction
        DB::connection('tenant')->beginTransaction();

        try {
            $submission->update([
                'plant_id'               => $request->plant_id,
                'sub_plant_id'           => $request->sub_plant_id,
                'plant_sample_id'        => $request->plant_sample_id,
                'sample_id'              => $sample->id,
                'priority'               => $request->priority,
                'sampling_date_and_time' => $date,
                'comment'                => $request->comment,
            ]);

            // Handle existing submission items
            $submission_items = SubmissionItem::where('submission_id', $id)->get();

            foreach ($submission_items as $submission_item) {
                $inputKey = "sample_test_method_item_id-" . $submission_item->id;
                if (!array_key_exists($inputKey, $request->all())) {
                    $submission_item->delete();
                }
            }

            // Add new submission items using relationship
            if ($request->has('sample_test_method_item_id') && is_array($request->sample_test_method_item_id)) {
                $submissionItems = collect($request->input('sample_test_method_item_id', []))
                    ->map(function ($sampleTestMethodItemId) {
                        return [
                            'sample_test_method_item_id' => $sampleTestMethodItemId,
                            'created_at'                 => now(),
                            'updated_at'                 => now(),
                        ];
                    })
                    ->toArray();

                if (!empty($submissionItems)) {
                    $submission->submission_test_method_items()->createMany($submissionItems);
                }
            }

            DB::connection('tenant')->commit();

            return redirect()->route('admin.submission')->with('success', __('general.updated_successfully'));
        } catch (\Exception $e) {
            DB::connection('tenant')->rollBack();

            Log::error('Error updating submission: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'submission_id' => $id,
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $this->authorize('delete_submission');
        $submission = Submission::findOrFail($id);
        $submission->delete();
        return redirect()->route('admin.submission')->with('success', __('general.deleted_successfully'));
    }

    public function get_test_method_by_sample_id($id)
    {
        $this->authorize('create_sample');

        try {
            $sample = Sample::where('plant_sample_id', $id)->select('id')->first();

            if (!$sample) {
                return response()->json([
                    'status'       => 404,
                    'message'      => __('general.sample_not_found'),
                    "test_methods" => [],
                ], 404);
            }

            $test_methods = SampleTestMethod::where('sample_id', $sample->id)
                ->with('master_test_method')
                ->get();

            return response()->json([
                'status'       => 200,
                "test_methods" => $test_methods,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading test methods: ' . $e->getMessage(), [
                'plant_sample_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status'       => 500,
                'message'      => __('general.something_went_wrong'),
                "test_methods" => [],
            ], 500);
        }
    }

    // schedule submission
    public function updateStatusByBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $submission = Submission::where('submission_number', $request->barcode)->first();

        if (! $submission) {
            return response()->json(['success' => false, 'message' => translate('barcode_not_found')]);
        }

        $submission->status = 'second_step';
        $submission->save();

        return response()->json(['success' => true, 'message' => translate('The_sample_has_been_received')]);
    }

    public function scanPage(Request $request)
    {
        return view('second_part.submission.read_barcode');
    }

    public function change_status($id, $status)
    {

        $submission = Submission::findOrFail($id);

        $submission->status = $status;
        $submission->save();
        return redirect()->back()->with('success', translate('updated_successfully'));
    }
    public function change_status_without_qr($id)
    {

        $submission = Submission::findOrFail($id);

        $submission->status = 'second_step';
        $submission->save();
        return redirect()->back()->with('success', translate('updated_successfully'));
    }
}

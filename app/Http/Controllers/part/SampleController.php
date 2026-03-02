<?php

namespace App\Http\Controllers\part;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSampleRequest;
use App\Models\first_part\TestMethod;
use App\Models\first_part\TestMethodItem;
use App\Models\part\ToxicDegree;
use App\Models\Plant;
use App\Models\Sample;
use App\Models\SamplePlant;
use App\Models\SampleTestMethod;
use App\Models\SampleTestMethodItem;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SampleController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {

        $this->authorize('sample_management');

        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_samples_status');

            Sample::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }
        if ($request->bulk_action_btn === 'delete' && is_array($ids) && count($ids)) {

            Sample::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $samples = Sample::with(['plant_main', 'sub_plant', 'sample_plant', 'test_methods.master_test_method'])
            ->orderBy("created_at", "desc")
            ->paginate(10);
        // dd($samples);
        return view("samples.index", compact("samples"));
    }

    public function create()
    {
        $this->authorize('create_sample');
        $plants        = Plant::select('id', 'name', 'plant_id')->whereNull('plant_id')->get();
        $test_methods  = TestMethod::select('id', 'name')->get();
        $toxic_degrees = ToxicDegree::select('id', 'name')->get();
        $data          = [
            'plants'        => $plants,
            'test_methods'  => $test_methods,
            'toxic_degrees' => $toxic_degrees,
        ];
        return view("samples.create", $data);
    }
    public function edit($id)
    {
        $this->authorize('edit_sample');
        $sample                   = Sample::findOrFail($id);
        $sample_test_methods      = SampleTestMethod::where('sample_id', $id)->get();
        $sample_test_method_items = SampleTestMethodItem::where('sample_id', $id)->get();

        $plants        = Plant::select('id', 'name', 'plant_id')->whereNull('plant_id')->get();
        $sub_plants    = Plant::select('id', 'name', 'plant_id')->whereNotNull('plant_id')->get();
        $test_methods  = TestMethod::select('id', 'name')->get();
        $toxic_degrees = ToxicDegree::select('id', 'name')->get();
        $data          = [
            'plants'                   => $plants,
            'test_methods'             => $test_methods,
            'toxic_degrees'            => $toxic_degrees,
            'sample'                   => $sample,
            'sample_test_methods'      => $sample_test_methods,
            'sample_test_method_items' => $sample_test_method_items,
            'sub_plants'               => $sub_plants,
        ];
        return view("samples.edit", $data);
    }

    /**
     * Update the specified sample in storage.
     *
     * @param UpdateSampleRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSampleRequest $request, $id)
    {
        $sample = Sample::findOrFail($id);

        DB::beginTransaction();

        try {
            // Update basic sample information
            $this->updateSampleBasicInfo($sample, $request);

            // Update test methods and their items
            $this->updateTestMethods($sample, $request);

            DB::commit();

            return redirect()
                ->route('admin.sample')
                ->with('success', __('general.updated_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error updating sample', [
                'sample_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['_token', 'password']),
            ]);

            return back()
                ->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }

    /**
     * Update basic sample information.
     *
     * @param Sample $sample
     * @param UpdateSampleRequest $request
     * @return void
     */
    protected function updateSampleBasicInfo(Sample $sample, UpdateSampleRequest $request): void
    {
        $sample->update([
            'plant_id' => $request->main_plant_item,
            'sub_plant_id' => $request->sub_plant_item,
            'plant_sample_id' => $request->sample_name,
            'toxic' => $request->toxic,
            'coa' => $request->coa ? 1 : null,
        ]);
    }

    /**
     * Update test methods and their items.
     *
     * @param Sample $sample
     * @param UpdateSampleRequest $request
     * @return void
     */
    /**
     * Update test methods and their items.
     *
     * @param Sample $sample
     * @param UpdateSampleRequest $request
     * @return void
     */
    protected function updateTestMethods(Sample $sample, UpdateSampleRequest $request): void
    {
        // Update existing test methods
        $this->updateExistingTestMethods($sample, $request);
        
        // Create new test methods
        $this->createNewTestMethods($sample, $request);
    }

    /**
     * Update existing test methods and their items.
     *
     * @param Sample $sample
     * @param UpdateSampleRequest $request
     * @return void
     */
    protected function updateExistingTestMethods(Sample $sample, UpdateSampleRequest $request): void
    {
        $existingTestMethods = SampleTestMethod::where('sample_id', $sample->id)->get();

        foreach ($existingTestMethods as $testMethod) {
            // Update test method if provided
            if ($request->has("test_method.{$testMethod->id}") && $request->test_method[$testMethod->id]) {
                $testMethod->update([
                    'test_method_id' => $request->test_method[$testMethod->id],
                ]);
            }

            // Update test method items
            $this->updateTestMethodItems($testMethod, $request);
        }
    }

    /**
     * Create new test methods from request.
     *
     * @param Sample $sample
     * @param UpdateSampleRequest $request
     * @return void
     */
    protected function createNewTestMethods(Sample $sample, UpdateSampleRequest $request): void
    {
        $newTestMethodNumbers = $this->extractNewTestMethodNumbers($request);

        foreach ($newTestMethodNumbers as $number) {
            $testMethodId = $request->input("test_method-$number");

            if (!$testMethodId) {
                continue;
            }

            $testMethod = TestMethod::find($testMethodId);
            if (!$testMethod) {
                continue;
            }

            $sampleTestMethod = SampleTestMethod::create([
                'test_method_id' => $testMethod->id,
                'sample_id'      => $sample->id,
            ]);

            // Create components for this test method
            $this->createTestMethodComponents($sampleTestMethod, $number, $testMethod, $request);
        }
    }

    /**
     * Extract new test method numbers from request.
     *
     * @param UpdateSampleRequest $request
     * @return array
     */
    protected function extractNewTestMethodNumbers(UpdateSampleRequest $request): array
    {
        $numbers = [];
        $inputs = $request->all();

        foreach ($inputs as $key => $value) {
            if (Str::startsWith($key, 'test_method-')) {
                $number = (int) str_replace('test_method-', '', $key);
                // Only process if it's a number (not existing test_method[id] format)
                if (is_numeric($number) && !isset($request->test_method[$number])) {
                    $numbers[] = $number;
                }
            }
        }

        return array_unique($numbers);
    }

    /**
     * Create test method components.
     *
     * @param SampleTestMethod $sampleTestMethod
     * @param int $number
     * @param TestMethod $testMethod
     * @param UpdateSampleRequest $request
     * @return void
     */
    protected function createTestMethodComponents(
        SampleTestMethod $sampleTestMethod,
        int $number,
        TestMethod $testMethod,
        UpdateSampleRequest $request
    ): void {
        $inputs = $request->all();
        $isSelectAll = is_array($request->components ?? []) && in_array(-1, $request->components);

        if ($isSelectAll) {
            $this->createAllComponents($sampleTestMethod, $number, $testMethod, $request);
        } else {
            $this->createSelectedComponents($sampleTestMethod, $number, $inputs, $request);
        }
    }

    /**
     * Create all components for a test method.
     *
     * @param SampleTestMethod $sampleTestMethod
     * @param int $number
     * @param TestMethod $testMethod
     * @param UpdateSampleRequest $request
     * @return void
     */
    protected function createAllComponents(
        SampleTestMethod $sampleTestMethod,
        int $number,
        TestMethod $testMethod,
        UpdateSampleRequest $request
    ): void {
        $testMethodItems = TestMethodItem::where('test_method_id', $testMethod->id)->get();

        if ($testMethodItems->isEmpty()) {
            return;
        }

        foreach ($testMethodItems as $itemIndex => $item) {
            $newIndex = $itemIndex + 1;
            $componentKey = "component-$number-{$item->id}-$newIndex";

            if (!$request->has($componentKey)) {
                continue;
            }

            $testMethodItemIdKey = "$number-{$item->id}-$newIndex";
            $testMethodItemId = $request->input("test_method_item_id_new.$testMethodItemIdKey", $item->id);

            $this->createTestMethodItem(
                $sampleTestMethod,
                $testMethodItemId,
                $number,
                $item->id,
                $newIndex,
                $request
            );
        }
    }

    /**
     * Create selected components for a test method.
     *
     * @param SampleTestMethod $sampleTestMethod
     * @param int $number
     * @param array $inputs
     * @param UpdateSampleRequest $request
     * @return void
     */
    protected function createSelectedComponents(
        SampleTestMethod $sampleTestMethod,
        int $number,
        array $inputs,
        UpdateSampleRequest $request
    ): void {
        $componentKeys = $this->extractComponentKeys($inputs, $number);

        foreach ($componentKeys as $componentKey) {
            $componentId = $componentKey['component_id'];
            $componentIndex = $componentKey['index'];
            $checkboxKey = $componentIndex !== null
                ? "component-$number-$componentId-$componentIndex"
                : "component-$number-$componentId";

            if (!$request->has($checkboxKey) && !array_key_exists($checkboxKey, $inputs)) {
                continue;
            }

            $testMethodItemIdKey = $componentIndex !== null
                ? "$number-$componentId-$componentIndex"
                : "$number-$componentId";

            $testMethodItemId = $request->input("test_method_item_id_new.$testMethodItemIdKey", $componentId);

            $this->createTestMethodItem(
                $sampleTestMethod,
                $testMethodItemId,
                $number,
                $componentId,
                $componentIndex,
                $request
            );
        }
    }

    /**
     * Extract component keys from inputs.
     *
     * @param array $inputs
     * @param int $number
     * @return array
     */
    protected function extractComponentKeys(array $inputs, int $number): array
    {
        $componentKeys = [];
        $seen = [];

        foreach ($inputs as $key => $value) {
            if (!Str::startsWith($key, "component-$number-")) {
                continue;
            }

            $parts = explode('-', $key);
            if (count($parts) < 3) {
                continue;
            }

            $componentId = (int) $parts[2];
            $componentIndex = count($parts) >= 4 ? (int) $parts[3] : null;
            $uniqueKey = "$componentId-" . ($componentIndex ?? 'null');

            if (isset($seen[$uniqueKey])) {
                continue;
            }

            $seen[$uniqueKey] = true;
            $componentKeys[] = [
                'component_id' => $componentId,
                'index' => $componentIndex,
            ];
        }

        return $componentKeys;
    }

    /**
     * Create a test method item.
     *
     * @param SampleTestMethod $sampleTestMethod
     * @param int $testMethodItemId
     * @param int $number
     * @param int $componentId
     * @param int|null $componentIndex
     * @param UpdateSampleRequest $request
     * @return void
     */
    protected function createTestMethodItem(
        SampleTestMethod $sampleTestMethod,
        int $testMethodItemId,
        int $number,
        int $componentId,
        ?int $componentIndex,
        UpdateSampleRequest $request
    ): void {
        $baseKey = $componentIndex !== null
            ? "$number-$componentId-$componentIndex"
            : "$number-$componentId";

        SampleTestMethodItem::create([
            'test_method_id'      => $sampleTestMethod->id,
            'sample_id'           => $sampleTestMethod->sample_id,
            'test_method_item_id' => $testMethodItemId,
            'warning_limit'       => $this->normalizeValue($request->input("warning_limit-$baseKey")),
            'warning_limit_end'   => $this->normalizeValue($request->input("warning_limit_end-$baseKey")),
            'action_limit'        => $this->normalizeValue($request->input("action_limit-$baseKey")),
            'action_limit_end'    => $this->normalizeValue($request->input("action_limit_end-$baseKey")),
            'warning_limit_type'  => $this->normalizeValue($request->input("warning_limit_type-$baseKey")),
            'action_limit_type'   => $this->normalizeValue($request->input("action_limit_type-$baseKey")),
        ]);
    }

    /**
     * Update test method items.
     *
     * @param SampleTestMethod $testMethod
     * @param UpdateSampleRequest $request
     * @return void
     */
    protected function updateTestMethodItems(SampleTestMethod $testMethod, UpdateSampleRequest $request): void
    {
        foreach ($testMethod->sample_test_method_items as $item) {
            // Check if this item exists in the request (via test_method_item_id or component_old checkbox)
            $componentOld = $request->input("component_old.{$item->id}");
            $itemExists = isset($request->test_method_item_id[$item->id])
                || isset($componentOld);

            if (!$itemExists) {
                continue;
            }

            $updateData = $this->prepareTestMethodItemData($item->id, $request);

            // Only update if we have data
            if (!empty($updateData)) {
                $item->update($updateData);
            }
        }
    }

    /**
     * Prepare test method item data for update.
     *
     * @param int $itemId
     * @param UpdateSampleRequest $request
     * @return array
     */
    protected function prepareTestMethodItemData(int $itemId, UpdateSampleRequest $request): array
    {
        $data = [];

        // Always update test_method_item_id if provided
        if (isset($request->test_method_item_id[$itemId])) {
            $data['test_method_item_id'] = $request->test_method_item_id[$itemId];
        }

        // Update warning limit fields if provided
        if ($request->has("warning_limit_old.{$itemId}")) {
            $data['warning_limit'] = $this->normalizeValue($request->warning_limit_old[$itemId]);
        }

        if ($request->has("warning_limit_end_old.{$itemId}")) {
            $data['warning_limit_end'] = $this->normalizeValue($request->warning_limit_end_old[$itemId]);
        }

        if ($request->has("warning_limit_type_old.{$itemId}")) {
            $data['warning_limit_type'] = $this->normalizeValue($request->warning_limit_type_old[$itemId]);
        }

        // Update action limit fields if provided
        if ($request->has("action_limit_old.{$itemId}")) {
            $data['action_limit'] = $this->normalizeValue($request->action_limit_old[$itemId]);
        }

        if ($request->has("action_limit_end_old.{$itemId}")) {
            $data['action_limit_end'] = $this->normalizeValue($request->action_limit_end_old[$itemId]);
        }

        if ($request->has("action_limit_type_old.{$itemId}")) {
            $data['action_limit_type'] = $this->normalizeValue($request->action_limit_type_old[$itemId]);
        }

        return $data;
    }

    /**
     * Normalize value (convert empty strings to null).
     *
     * @param mixed $value
     * @return mixed
     */
    protected function normalizeValue($value)
    {
        return ($value === '' || $value === null) ? null : $value;
    }

    public function store(Request $request)
    {

        $inputs  = $request->all();
        $numbers = [];

        foreach ($inputs as $key => $value) {
            if (Str::startsWith($key, 'test_method-')) {
                $number    = (int) str_replace('test_method-', '', $key);
                $numbers[] = $number;
            }
        }

        $this->authorize('create_sample');

        $request->validate([
            'main_plant_item' => 'required',
            'sample_name'     => 'required|unique:samples,plant_sample_id',
            'test_method'     => 'required|exists:test_methods,id',
        ]);

        // Use database transaction to ensure data consistency
        DB::beginTransaction();

        try {
            $sample = Sample::create([
                'plant_id'        => $request->main_plant_item,
                'sub_plant_id'    => $request->sub_plant_item ?? null,
                'plant_sample_id' => $request->sample_name,
                'toxic'           => $request->toxic ?? null,
                'coa'             => ($request->coa == 'on') ? 1 : null,
            ]);

            // Validate and get test method
            $test_method = TestMethod::find($request->test_method);

            if (!$test_method) {
                DB::rollBack();
                return back()->withErrors(['test_method' => __('general.test_method_not_found')])
                    ->withInput();
            }

            if (isset($request->main_components) && $request->main_components == -1) {
                $test_method_items = TestMethodItem::where('test_method_id', $test_method->id)->get();

                if ($test_method_items->isEmpty()) {
                    DB::rollBack();
                    return back()->withErrors(['test_method' => __('general.no_test_method_items_found')])
                        ->withInput();
                }

                $sample_test_method = SampleTestMethod::create([
                    'test_method_id' => $test_method->id,
                    'sample_id'      => $sample->id,
                ]);

                foreach ($test_method_items as $item) {
                    $index = $item->id;
                    if ($request->has("component-$index")) {
                        SampleTestMethodItem::create([
                            'test_method_id'      => $sample_test_method->id,
                            'sample_id'           => $sample->id,
                            'test_method_item_id' => $item->id,
                            'warning_limit_end'   => $request->input("warning_limit_end-$index"),
                            'warning_limit'       => $request->input("warning_limit-$index"),
                            'action_limit'        => $request->input("action_limit-$index"),
                            'action_limit_end'    => $request->input("action_limit_end-$index"),
                            'warning_limit_type'  => $request->input("warning_limit_type-$index"),
                            'action_limit_type'   => $request->input("action_limit_type-$index"),
                        ]);
                    }
                }
            } elseif (isset($request->main_components)) {
                // Validate test method exists (already validated above)
                if ($request->has("component-$request->main_components")) {
                    $sample_test_method = SampleTestMethod::create([
                        'test_method_id' => $test_method->id,
                        'sample_id'      => $sample->id,
                    ]);
                    SampleTestMethodItem::create([
                        'test_method_id'      => $sample_test_method->id,
                        'sample_id'           => $sample->id,
                        'test_method_item_id' => $request->main_components,
                        'warning_limit'       => $request->input("warning_limit-$request->main_components"),
                        'warning_limit_end'   => $request->input("warning_limit_end-$request->main_components"),
                        'action_limit'        => $request->input("action_limit-$request->main_components"),
                        'action_limit_end'    => $request->input("action_limit_end-$request->main_components"),
                        'warning_limit_type'  => $request->input("warning_limit_type-$request->main_components"),
                        'action_limit_type'   => $request->input("action_limit_type-$request->main_components"),
                    ]);
                }
            }

            // Handle multiple test methods
            if (!empty($numbers)) {
                foreach ($numbers as $index => $number) {
                    $testMethodId = $request->input("test_method-$number");

                    if (!$testMethodId) {
                        continue; // Skip if test method ID is missing
                    }

                    $test_method = TestMethod::find($testMethodId);

                    if (!$test_method) {
                        DB::rollBack();
                        return back()->withErrors(['test_method' => __('general.test_method_not_found') . " (ID: $testMethodId)"])
                            ->withInput();
                    }

                    $sample_test_method = SampleTestMethod::create([
                        'test_method_id' => $test_method->id,
                        'sample_id'      => $sample->id,
                    ]);

                    $component_nums = [];
                    foreach ($inputs as $key => $value) {
                        if (Str::startsWith($key, "component-$number-")) {
                            $component_num    = (int) str_replace("component-$number-", '', $key);
                            $component_nums[] = $component_num;
                        }
                    }

                    if (!empty($component_nums) && is_array($component_nums) && !in_array(-1, $request->components ?? [])) {
                        foreach ($component_nums as $index => $component_num) {
                            SampleTestMethodItem::create([
                                'test_method_id'      => $sample_test_method->id,
                                'sample_id'           => $sample->id,
                                'test_method_item_id' => $component_num,
                                'warning_limit'       => $request->input("warning_limit-$number-$component_num"),
                                'warning_limit_end'   => $request->input("warning_limit_end-$number-$component_num"),
                                'action_limit_end'    => $request->input("action_limit_end-$number-$component_num"),
                                'action_limit'        => $request->input("action_limit-$number-$component_num"),
                                'warning_limit_type'  => $request->input("warning_limit_type-$number-$component_num"),
                                'action_limit_type'   => $request->input("action_limit_type-$number-$component_num"),
                            ]);
                        }
                    } elseif (is_array($component_nums) && is_array($request->components ?? []) && in_array(-1, $request->components)) {
                        $test_method_items = TestMethodItem::where('test_method_id', $test_method->id)->get();

                        if ($test_method_items->isEmpty()) {
                            continue; // Skip if no items found
                        }

                        foreach ($test_method_items as $index => $item) {
                            $new_index = $index + 1;
                            if ($request->has("component-$number-$item->id-$new_index")) {
                                SampleTestMethodItem::create([
                                    'test_method_id'      => $sample_test_method->id,
                                    'sample_id'           => $sample->id,
                                    'test_method_item_id' => $item->id,
                                    'warning_limit'       => $request->input("warning_limit-$number-$item->id-$new_index"),
                                    'action_limit'        => $request->input("action_limit-$number-$item->id-$new_index"),
                                    'warning_limit_end'   => $request->input("warning_limit_end-$number-$item->id-$new_index"),
                                    'action_limit_end'    => $request->input("action_limit_end-$number-$item->id-$new_index"),
                                    'warning_limit_type'  => $request->input("warning_limit_type-$number-$item->id-$new_index"),
                                    'action_limit_type'   => $request->input("action_limit_type-$number-$item->id-$new_index"),
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.sample')->with('success', __('general.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error creating sample: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong') . ': ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function get_sub_from_plant($id)
    {
        $this->authorize('create_sample');
        $plants = Plant::select('id', 'name', 'plant_id')->with('samplePlants', 'mainPlant', 'sub_plants', 'sub_plants.samplePlants')->where('plant_id', $id)->get();
        if ($plants->isEmpty()) {
            $samples = SamplePlant::select('id', 'name', 'plant_id')->where('plant_id', $id)->get();
            return response()->json([
                'status'  => 200,
                "samples" => $samples,
            ]);
        }
        $samples = SamplePlant::select('id', 'name', 'plant_id')->where('plant_id', $id)->get();
        if (! $samples->isEmpty()) {
            return response()->json([
                'status'  => 200,
                "plants"  => $plants,
                "samples" => $samples,
            ]);
        }
        return response()->json([
            'status' => 200,
            "plants" => $plants,
        ]);
    }
    public function get_sample_from_plant($id)
    {
        $this->authorize('create_sample');
        $samples = SamplePlant::select('id', 'name', 'plant_id')->where('plant_id', $id)->get();
        return response()->json([
            'status'  => 200,
            "samples" => $samples,
        ]);
    }
    public function get_master_sample_from_plant($id)
    {
        $samples = Sample::select('id', 'plant_sample_id', 'plant_id', 'sub_plant_id')
            ->with('sample_plant:id,name')
            ->where('plant_id', $id)
            ->orWhere('sub_plant_id', $id)
            ->get();
        return response()->json([
            'status'  => 200,
            "samples" => $samples,
        ]);
    }
    public function get_components_by_test_method($id)
    {
        $this->authorize('create_sample');
        $components = TestMethodItem::where('test_method_id', $id)->with('main_unit')->get();
        return response()->json([
            'status'     => 200,
            "components" => $components,
        ]);
    }
    public function get_one_component_by_test_method($id)
    {
        $this->authorize('create_sample');
        $component = TestMethodItem::where('id', $id)->with('main_unit')->first();
        return response()->json([
            'status'    => 200,
            "component" => $component,
        ]);
    }
    public function destroy($id)
    {
        $this->authorize('delete_sample');

        try {
            $sample = Sample::findOrFail($id);

            // Check if sample is being used in operational data
            // Note: Test methods association doesn't prevent deletion
            if ($sample->isInUse()) {
                $usage = $sample->getUsageDetails();
                $message = __('general.cannot_delete_sample_in_use', [
                    'submissions' => $usage['submissions'],
                    'results' => $usage['results'],
                    'schedulers' => $usage['schedulers'],
                    'total' => $usage['total']
                ]);

                return back()->withErrors(['error' => $message])
                    ->with('error', $message);
            }

            $sample->delete();

            return redirect()->back()->with('success', __('general.deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Error deleting sample: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'sample_id' => $id
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')]);
        }
    }

    public function delete_test_method_from_sample($id)
    {
        $test_method = SampleTestMethod::findOrFail($id);
        if ($test_method->delete()) {
            return redirect()->back()->with('success', __('general.deleted_successfully'));
        }
    }
    public function delete_test_method_item_from_sample($id)
    {
        $test_method = SampleTestMethodItem::findOrFail($id);
        if ($test_method->delete()) {
            return redirect()->back()->with('success', __('general.deleted_successfully'));
        }
    }

    public function add_test_method($id)
    {
        $sample               = Sample::where('id', $id)->findOrFail($id);
        $used_test_method_ids = $sample->test_methods()->pluck('test_method_id')->toArray();

        $test_methods = TestMethod::whereNotIn('id', $used_test_method_ids)->select('id', 'name')->get();
        $data         = [
            'sample'       => $sample,
            'test_methods' => $test_methods,
        ];
        return view('samples.add_test_method', $data);
    }

    public function store_test_method(Request $request)
    {
        $this->authorize('edit_sample');

        $request->validate([
            'sample_id' => 'required|exists:samples,id',
            'test_method' => 'required|exists:test_methods,id',
        ]);

        $inputs  = $request->all();
        $numbers = [];

        foreach ($inputs as $key => $value) {
            if (Str::startsWith($key, 'test_method-')) {
                $number    = (int) str_replace('test_method-', '', $key);
                $numbers[] = $number;
            }
        }

        // Validate and get test method
        $test_method = TestMethod::find($request->test_method);

        if (!$test_method) {
            return back()->withErrors(['test_method' => __('general.test_method_not_found')])
                ->withInput();
        }

        // Validate sample exists
        $sample = Sample::find($request->sample_id);

        if (!$sample) {
            return back()->withErrors(['sample_id' => __('general.sample_not_found')])
                ->withInput();
        }

        // Use database transaction
        DB::beginTransaction();

        try {
            if (isset($request->main_components) && $request->main_components == -1) {
                $test_method_items = TestMethodItem::where('test_method_id', $test_method->id)->get();

                if ($test_method_items->isEmpty()) {
                    DB::rollBack();
                    return back()->withErrors(['test_method' => __('general.no_test_method_items_found')])
                        ->withInput();
                }

                $sample_test_method = SampleTestMethod::create([
                    'test_method_id' => $test_method->id,
                    'sample_id'      => $sample->id,
                ]);
                foreach ($test_method_items as $item) {
                    $index = $item->id;
                    if ($request->has("component-$index")) {
                        SampleTestMethodItem::create([
                            'test_method_id'      => $sample_test_method->id,
                            'sample_id'           => $sample->id,
                            'test_method_item_id' => $item->id,
                            'warning_limit_end'   => $request->input("warning_limit_end-$index"),
                            'warning_limit'       => $request->input("warning_limit-$index"),
                            'action_limit'        => $request->input("action_limit-$index"),
                            'action_limit_end'    => $request->input("action_limit_end-$index"),
                            'warning_limit_type'  => $request->input("warning_limit_type-$index"),
                            'action_limit_type'   => $request->input("action_limit_type-$index"),
                        ]);
                    }
                }
            } elseif (isset($request->main_components)) {
                // Validate test method exists (already validated above)
                if ($request->has("component-$request->main_components")) {
                    $sample_test_method = SampleTestMethod::create([
                        'test_method_id' => $test_method->id,
                        'sample_id'      => $sample->id,
                    ]);
                    SampleTestMethodItem::create([
                        'test_method_id'      => $sample_test_method->id,
                        'sample_id'           => $sample->id,
                        'test_method_item_id' => $request->main_components,
                        'warning_limit'       => $request->input("warning_limit-$request->main_components"),
                        'warning_limit_end'   => $request->input("warning_limit_end-$request->main_components"),
                        'action_limit'        => $request->input("action_limit-$request->main_components"),
                        'action_limit_end'    => $request->input("action_limit_end-$request->main_components"),
                        'warning_limit_type'  => $request->input("warning_limit_type-$request->main_components"),
                        'action_limit_type'   => $request->input("action_limit_type-$request->main_components"),
                    ]);
                }
            }

            // Handle multiple test methods
            if (!empty($numbers)) {
                foreach ($numbers as $index => $number) {
                    $testMethodId = $request->input("test_method-$number");

                    if (!$testMethodId) {
                        continue; // Skip if test method ID is missing
                    }

                    $test_method = TestMethod::find($testMethodId);

                    if (!$test_method) {
                        DB::rollBack();
                        return back()->withErrors(['test_method' => __('general.test_method_not_found') . " (ID: $testMethodId)"])
                            ->withInput();
                    }

                    $sample_test_method = SampleTestMethod::create([
                        'test_method_id' => $test_method->id,
                        'sample_id'      => $sample->id,
                    ]);
                    $component_nums = [];
                    foreach ($inputs as $key => $value) {
                        if (Str::startsWith($key, "component-$number-")) {
                            $component_num    = (int) str_replace("component-$number-", '', $key);
                            $component_nums[] = $component_num;
                        }
                    }

                    if (!empty($component_nums) && is_array($component_nums) && !in_array(-1, $request->components ?? [])) {
                        foreach ($component_nums as $index => $component_num) {
                            SampleTestMethodItem::create([
                                'test_method_id'      => $sample_test_method->id,
                                'sample_id'           => $sample->id,
                                'test_method_item_id' => $component_num,
                                'warning_limit'       => $request->input("warning_limit-$number-$component_num"),
                                'warning_limit_end'   => $request->input("warning_limit_end-$number-$component_num"),
                                'action_limit_end'    => $request->input("action_limit_end-$number-$component_num"),
                                'action_limit'        => $request->input("action_limit-$number-$component_num"),
                                'warning_limit_type'  => $request->input("warning_limit_type-$number-$component_num"),
                                'action_limit_type'   => $request->input("action_limit_type-$number-$component_num"),
                            ]);
                        }
                    } elseif (is_array($component_nums) && is_array($request->components ?? []) && in_array(-1, $request->components)) {
                        $test_method_items = TestMethodItem::where('test_method_id', $test_method->id)->get();

                        if ($test_method_items->isEmpty()) {
                            continue; // Skip if no items found
                        }

                        foreach ($test_method_items as $index => $item) {
                            $new_index = $index + 1;
                            if ($request->has("component-$number-$item->id-$new_index")) {
                                SampleTestMethodItem::create([
                                    'test_method_id'      => $sample_test_method->id,
                                    'sample_id'           => $sample->id,
                                    'test_method_item_id' => $item->id,
                                    'warning_limit'       => $request->input("warning_limit-$number-$item->id-$new_index"),
                                    'action_limit'        => $request->input("action_limit-$number-$item->id-$new_index"),
                                    'warning_limit_end'   => $request->input("warning_limit_end-$number-$item->id-$new_index"),
                                    'action_limit_end'    => $request->input("action_limit_end-$number-$item->id-$new_index"),
                                    'warning_limit_type'  => $request->input("warning_limit_type-$number-$item->id-$new_index"),
                                    'action_limit_type'   => $request->input("action_limit_type-$number-$item->id-$new_index"),
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.sample')->with('success', __('general.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error storing test method: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }
}

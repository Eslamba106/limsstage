<?php

namespace App\Http\Controllers\first_part;

use Carbon\Carbon;
use App\helper\Helpers;
use App\Models\part\Unit;
use Illuminate\Http\Request;
use App\Models\part\ResultType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\first_part\TestMethod;
use App\Models\first_part\TestMethodItem;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TestMethodController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {

        if (!Helpers::module_check('test_method_management')) {
            return response()->view('errors.403', [], 403);
        }

        $this->authorize('test_method_management');

        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];
            $this->authorize('change_test_methods_status');

            TestMethod::whereIn('id', $ids)->update($data);
            return back()->with('success', translate('updated_successfully'));
        }
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {
            $this->authorize('delete_test_method');
            
            $deleted = 0;
            $errors = [];
            
            foreach ($ids as $id) {
                try {
                    $test_method = TestMethod::find($id);
                    
                    if (!$test_method) {
                        continue;
                    }
                    
                    // Check if test method is being used
                    if ($test_method->isInUse()) {
                        $usage = $test_method->getUsageDetails();
                        $errors[] = __('general.cannot_delete_test_method_in_use', [
                            'name' => $test_method->name,
                            'samples' => $usage['samples'],
                            'schedulers' => $usage['schedulers'],
                            'results' => $usage['results'],
                            'total' => $usage['total']
                        ]);
                        continue;
                    }
                    
                    $test_method->delete();
                    $deleted++;
                } catch (\Exception $e) {
                    Log::error('Error deleting test method in bulk: ' . $e->getMessage(), [
                        'test_method_id' => $id
                    ]);
                    $errors[] = __('general.error_deleting_test_method', ['id' => $id]);
                }
            }
            
            if ($deleted > 0) {
                $message = __('general.deleted_successfully');
                if (count($errors) > 0) {
                    $message .= '. ' . __('general.some_items_could_not_be_deleted');
                }
                return back()->with('success', $message)->with('errors', $errors);
            } else {
                return back()->withErrors(['error' => implode(', ', $errors)]);
            }
        }

        $test_methods = TestMethod::select('id', 'name', 'status', 'description')->with('test_method_items')->orderBy("created_at", "desc")->paginate(10);
        return view("first_part.test_method.test_method_list", compact("test_methods"));
    }

    public function create()
    {
            if (!Helpers::module_check('test_method_management')) {
            return response()->view('errors.403', [], 403);
        }
        $this->authorize('create_test_method');
        $units = Unit::select('id', 'name')->get();
        $result_types = ResultType::select('id', 'name')->get();
        $data = [
            'units' => $units,
            'result_types' => $result_types,
        ];
        return view("first_part.test_method.create", $data);
    }

    public function store(Request $request)
    {

        $this->authorize('create_test_method');
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'item_name' => 'required|array',
            'item_name.*' => 'required|string|max:255',
            'unit' => 'required|array',
            'unit.*' => 'required|string|max:255',
            'result_type' => 'required|array',
            'result_type.*' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $test_method = TestMethod::create([
                'name' => $request->name,
                'description' => $request->description,

            ]);
            foreach ($request->item_name as $index => $test_method_item) {
                $test_method->test_method_items()->create([
                    'name' => $test_method_item,
                    'unit' =>  isset($request->unit[$index]) ? $request->unit[$index] : null,
                    'result_type' =>  isset($request->result_type[$index]) ? $request->result_type[$index] : null,
                    'precision' =>  isset($request->precision[$index]) ? $request->precision[$index] : null,
                    'lower_range' =>  isset($request->lower_range[$index]) ? $request->lower_range[$index] : null,
                    'upper_range' =>  isset($request->upper_range[$index]) ? $request->upper_range[$index] : null,
                    'reportable' => isset($request->reportable[$index]) ? $request->reportable[$index] : null,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', translate('something_went_wrong'));
        }

        return redirect()->route('admin.test_method')->with('success', translate('created_successfully'));
    }
    public function edit($id)
    {
        $this->authorize('edit_test_method');


        $testMethod = TestMethod::with('test_method_items')->findOrFail($id);

        $units = Unit::select('id', 'name')->get();
        $result_types = ResultType::select('id', 'name')->get();

        return view("first_part.test_method.edit", [
            'testMethod' => $testMethod,
            'units' => $units,
            'result_types' => $result_types,
        ]);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->authorize('edit_test_method');


        $testMethod = TestMethod::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',

        ]);

        DB::beginTransaction();
        try {

            $testMethod->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);


            foreach ($request->item_id as $item_id) {
                DB::table('test_method_items')->where('id', $item_id)->update([
                    'name' => $request->input("item_name-$item_id"),
                    'unit' => $request->input("unit-$item_id") ?? null,
                    'result_type' => $request->input("result_type-$item_id") ?? null,
                    'precision' => $request->input("precision-$item_id") ?? null,
                    'lower_range' => $request->input("lower_range-$item_id") ?? null,
                    'upper_range' => $request->input("upper_range-$item_id") ?? null,
                    'reportable' => ($request->has("reportable-$item_id"))  ? '1' : '0',
                ]);
            }

            if (isset($request->item_name) && count($request->item_name) > 0) {

                foreach ($request->item_name as $index => $name) {
                    $testMethod->test_method_items()->create([
                        'name' => $name,
                        'unit' => $request->unit[$index] ?? null,
                        'result_type' => $request->result_type[$index] ?? null,
                        'precision' => $request->precision[$index] ?? null,
                        'lower_range' => $request->lower_range[$index] ?? null,
                        'upper_range' => $request->upper_range[$index] ?? null,
                        'reportable' => isset($request->reportable[$index]) ? '1' : '0',
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.test_method')
                ->with('success', translate('updated_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', translate('something_went_wrong'))
                ->withInput();
        }
    }
    public function delete_component($id)
    {
        $this->authorize('delete_test_method');
        
        try {
            $test_method_item = TestMethodItem::find($id);
            
            if (!$test_method_item) {
                return redirect()->back()->with('error', translate('item_not_found'));
            }

            if ($test_method_item->delete()) {
                return redirect()->back()->with('success', translate('deleted_successfully'));
            }
            
            return redirect()->back()->with('error', translate('delete_failed'));
        } catch (\Exception $e) {
            Log::error('Error deleting test method component: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'component_id' => $id
            ]);

            return back()->withErrors(['error' => translate('something_went_wrong')]);
        }
    }
    
    public function destroy($id)
    {
        $this->authorize('delete_test_method');
        
        try {
            $test_method = TestMethod::findOrFail($id);
            
            // Check if test method is being used
            if ($test_method->isInUse()) {
                $usage = $test_method->getUsageDetails();
                $message = __('general.cannot_delete_test_method_in_use', [
                    'samples' => $usage['samples'],
                    'schedulers' => $usage['schedulers'],
                    'results' => $usage['results'],
                    'total' => $usage['total']
                ]);
                
                return back()->withErrors(['error' => $message])
                    ->with('error', $message);
            }
            
            $test_method->delete();
            
            return redirect()->route('admin.test_method')->with('success', translate('deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Error deleting test method: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'test_method_id' => $id
            ]);

            return back()->withErrors(['error' => translate('something_went_wrong')]);
        }
    }
}

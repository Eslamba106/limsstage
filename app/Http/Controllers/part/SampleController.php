<?php
namespace App\Http\Controllers\part;

use App\Http\Controllers\Controller;
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

        $samples = Sample::orderBy("created_at", "desc")->paginate(10);
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

    public function update(Request $request, $id)
    {
        $this->authorize('edit_sample');
        // dd($request->all());
        $inputs  = $request->all();
        $numbers = [];

        foreach ($inputs as $key => $value) {
            if (Str::startsWith($key, 'test_method-')) {
                $number    = (int) str_replace('test_method-', '', $key);
                $numbers[] = $number;
            }
        }

        $sample = Sample::findOrFail($id);
        $request->validate([
            'main_plant_item' => 'required',
            'sample_name'     => 'required',
        ]);

        $sample->update([
            'plant_id'        => $request->main_plant_item,
            'sub_plant_id'    => $request->sub_plant_item ?? null,
            'plant_sample_id' => $request->sample_name,
            'toxic'           => $request->toxic ?? null,
            'coa'               => ($request->coa == 'on') ? 1 : null,
        ]);
        $test_method_old = SampleTestMethod::where('sample_id', $sample->id)->get();
        foreach ($test_method_old as $old_test_method) {
            $old_test_method->update([
                'test_method_id' => $request->test_method[$old_test_method->id],
            ]);

            foreach ($old_test_method->sample_test_method_items as $old_test_method_item) {
                if (isset($request->test_method_item_id[$old_test_method_item->id])) {
                    $old_test_method_item->update([
                        'test_method_item_id' => $request->test_method_item_id[$old_test_method_item->id],
                        'warning_limit'       => $request->warning_limit_old[$old_test_method_item->id] ?? null,
                        'warning_limit_end'   => $request->warning_limit_end_old[$old_test_method_item->id] ?? null,
                        'action_limit'        => $request->action_limit_old[$old_test_method_item->id] ?? null,
                        'action_limit_end'    => $request->action_limit_end_old[$old_test_method_item->id] ?? null,
                        'warning_limit_type'  => $request->warning_limit_type_old[$old_test_method_item->id] ?? null,
                        'action_limit_type'   => $request->action_limit_type_old[$old_test_method_item->id] ?? null,
                    ]);
                }

            }
        }

        return redirect()->route('admin.sample')->with('success', __('general.updated_successfully'));
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
        ]);
        $sample = Sample::create([
            'plant_id'        => $request->main_plant_item,
            'sub_plant_id'    => $request->sub_plant_item ?? null,
            'plant_sample_id' => $request->sample_name,
            'toxic'           => $request->toxic ?? null,
            'coa'               =>  ($request->coa == 'on') ? 1 : null,
        ]);
        $test_method = TestMethod::select('id')->where('id', $request->test_method)->first();
        if (isset($request->main_components) && $request->main_components == -1) {
            $test_method_items  = TestMethodItem::select('id', 'test_method_id')->where('test_method_id', $request->test_method)->get();
            $sample_test_method = SampleTestMethod::create([
                'test_method_id' => $test_method->id,
                'sample_id'      => $sample->id,
            ]);
            foreach ($test_method_items as $item) {
                $index = $item->id;
                if ($request->has("component-$index")) {

                    DB::table('sample_test_method_items')->insert([
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
            $test_method_items = TestMethod::select('id')->where('id', $request->test_method)->first();
            if ($request->has("component-$request->main_components")) {
                $sample_test_method = SampleTestMethod::create([
                    'test_method_id' => $test_method_items->id,
                    'sample_id'      => $sample->id,
                ]);
                DB::table('sample_test_method_items')->insert([
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
        if (! empty($numbers)) {
            foreach ($numbers as $index => $number) {
                $test_method = TestMethod::select('id')->where('id', $request->input("test_method-$number"))->first();

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
                if (! empty($component_nums) && is_array($component_nums) && ! in_array(-1, $request->components)) {

                    foreach ($component_nums as $index => $component_num) {

                        DB::table('sample_test_method_items')->insert([
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
                } elseif (is_array($component_nums) && is_array($request->components) && in_array(-1, $request->components)) {
                    $test_method_items = TestMethodItem::select('id', 'test_method_id')->where('test_method_id', $test_method->id)->get();

                    foreach ($test_method_items as $index => $item) {
                        $new_index = $index + 1;
                        if ($request->has("component-$number-$item->id-$new_index")) {

                            DB::table('sample_test_method_items')->insert([
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

        return redirect()->route('admin.sample')->with('success', __('general.created_successfully'));
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
        $sample = Sample::findOrFail($id);
        $sample->delete();
        return redirect()->back()->with('success', __('general.deleted_successfully'));
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
        $inputs  = $request->all();
        $numbers = [];

        foreach ($inputs as $key => $value) {
            if (Str::startsWith($key, 'test_method-')) {
                $number    = (int) str_replace('test_method-', '', $key);
                $numbers[] = $number;
            }
        }
        // dd($request->all());
        $test_method = TestMethod::select('id')->where('id', $request->test_method)->first();
        if (isset($request->main_components) && $request->main_components == -1) {
            $test_method_items  = TestMethodItem::select('id', 'test_method_id')->where('test_method_id', $request->test_method)->get();
            $sample_test_method = SampleTestMethod::create([
                'test_method_id' => $test_method->id,
                'sample_id'      => $request->sample_id,
            ]);
            foreach ($test_method_items as $item) {
                $index = $item->id;
                if ($request->has("component-$index")) {

                    DB::table('sample_test_method_items')->insert([
                        'test_method_id'      => $sample_test_method->id,
                        'sample_id'           => $request->sample_id,
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
            $test_method_items = TestMethod::select('id')->where('id', $request->test_method)->first();
            if ($request->has("component-$request->main_components")) {
                $sample_test_method = SampleTestMethod::create([
                    'test_method_id' => $test_method_items->id,
                    'sample_id'      => $request->sample_id,
                ]);
                DB::table('sample_test_method_items')->insert([
                    'test_method_id'      => $sample_test_method->id,
                    'sample_id'           => $request->sample_id,
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
        if (! empty($numbers)) {
            foreach ($numbers as $index => $number) {
                $test_method = TestMethod::select('id')->where('id', $request->input("test_method-$number"))->first();

                $sample_test_method = SampleTestMethod::create([
                    'test_method_id' => $test_method->id,
                    'sample_id'      => $request->sample_id,
                ]);
                $component_nums = [];
                foreach ($inputs as $key => $value) {
                    if (Str::startsWith($key, "component-$number-")) {
                        $component_num    = (int) str_replace("component-$number-", '', $key);
                        $component_nums[] = $component_num;
                    }
                }
                if (! empty($component_nums) && is_array($component_nums) && ! in_array(-1, $request->components)) {

                    foreach ($component_nums as $index => $component_num) {

                        DB::table('sample_test_method_items')->insert([
                            'test_method_id'      => $sample_test_method->id,
                            'sample_id'           => $request->sample_id,
                            'test_method_item_id' => $component_num,
                            'warning_limit'       => $request->input("warning_limit-$number-$component_num"),
                            'warning_limit_end'   => $request->input("warning_limit_end-$number-$component_num"),
                            'action_limit_end'    => $request->input("action_limit_end-$number-$component_num"),
                            'action_limit'        => $request->input("action_limit-$number-$component_num"),
                            'warning_limit_type'  => $request->input("warning_limit_type-$number-$component_num"),
                            'action_limit_type'   => $request->input("action_limit_type-$number-$component_num"),
                        ]);
                    }
                } elseif (is_array($component_nums) && is_array($request->components) && in_array(-1, $request->components)) {
                    $test_method_items = TestMethodItem::select('id', 'test_method_id')->where('test_method_id', $test_method->id)->get();

                    foreach ($test_method_items as $index => $item) {
                        $new_index = $index + 1;
                        if ($request->has("component-$number-$item->id-$new_index")) {

                            DB::table('sample_test_method_items')->insert([
                                'test_method_id'      => $sample_test_method->id,
                                'sample_id'           => $request->sample_id,
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

        return redirect()->route('admin.sample')->with('success', __('general.created_successfully'));
    }

}

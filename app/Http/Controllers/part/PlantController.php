<?php

namespace App\Http\Controllers\part;

use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SamplePlant;

class PlantController extends Controller
{
    public function plant_index(Request $request)
    {
        $plants = Plant::select('id', 'name' , 'plant_id')->orderBy("created_at", "desc")->paginate(10);
        $plant_master = Plant::select('id', 'name')->whereNull('plant_id')->get();
        $data = [
            'main' => $plants,
            'plant_master' => $plant_master,
            'route' => 'plant',
        ];
        return view('sample_part.index', $data);
    }

    public function plant_create()
    {
        $data = [
            'route' => 'plant',
        ];
        return view('sample_part.create', $data);
    }

    public function plant_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);


        $plant = Plant::create([
            'name' => $request->name,
            'plant_id' => $request->plant_id ? $request->plant_id : null,
        ]);


     

        return redirect()->route('admin.plant')->with('success', __('general.added_successfully'));
    }
    // public function plant_store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //     ]);


    //     $plant = Plant::create([
    //         'name' => $request->name,
    //     ]);


    //     $generalSamples = $request->input('sample_name', []);
    //     foreach ($generalSamples as $sampleName) {
    //         $plant->samplePlants()->create([
    //             'name' => $sampleName,
    //             'plant_id' => $plant->id,
    //         ]);
    //     }

    //     $subPlantCount = (int) $request->input('sub_plant_count', 0);

    //     for ($i = 1; $i <= $subPlantCount; $i++) {
    //         $subPlantName = $request->input("sub_plant_name-$i");
    //         $subPlant = $plant->sub_plants()->create([
    //             'name' => $subPlantName,
    //             'plant_id'  => $plant->id,
    //         ]);

    //         $sampleCount = (int) $request->input("sample_counter.$i", 0);
    //         for ($j = 1; $j <= $sampleCount; $j++) {
    //             $sampleName = $request->input("sample_name-$i-$j");
    //             $subPlant->samplePlants()->create([
    //                 'name' => $sampleName,
    //                 'plant_id'  => $subPlant->id,
    //             ]);
    //         }
    //     }

    //     return redirect()->route('admin.plant')->with('success', __('general.added_successfully'));
    // }

    public function plant_edit($id)
    {
        $plant = Plant::findOrFail($id);
        $plant_master = Plant::select('id', 'name')->whereNull('plant_id')->get();
        $sub_plants = $plant->sub_plants()->with('samplePlants')->get();
        $data = [
            'main' => $plant,
            'route' => 'plant',
            'sub_plants'    => $sub_plants,
            'plant_master'      => $plant_master,
        ];
        return view('sample_part.edit', $data);
    }
    public function plant_update(Request $request, $id)
    { 
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255|unique:plants,name,' . $id . ',id',
        ]);
        $plant = Plant::findOrFail($id);
        

        $plant->update([
            'name' => $request->name,
            'plant_id' => $request->plant_id ? $request->plant_id : null,
        ]); 

        return redirect()->route('admin.plant')->with('success', __('general.updated_successfully'));
    }
    public function plant_destroy($id)
    {
        $plant = Plant::findOrFail($id);
        $plant->delete();
        return redirect()->route('admin.plant')->with('success', __('general.deleted_successfully'));
    }
    public function get_sub_plants(Request $request)
    {
        $sub_plants = Plant::select('id', 'name')->where('plant_id', $request->plant_id)->get();
        return response()->json([
            'status' => 200,
            'sub_plants' => $sub_plants,
        ]);
    }
    public function master_sample_index(){
        $plant_master = Plant::select('id', 'name' , 'plant_id')->whereNull('plant_id')->orderBy("created_at", "desc")->paginate(10);
        $sub_plants = Plant::select('id', 'name' , 'plant_id')->whereNotNull('plant_id')->get();
        $samples = SamplePlant::select('id', 'name', 'plant_id') 
            ->orderBy("created_at", "desc")
            ->paginate(10);
        $data = [
            'main' => $samples,
            'route' => 'master_sample',
            'plant_master' => $plant_master,
            'sub_plant_master' => $sub_plants,
        ];
        return view('sample_part.master_sample_index', $data);
    }

 
    public function master_sample_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'plant_id' => 'required|exists:plants,id',
        ]);

        $sample = SamplePlant::create([
            'name' => $request->name,
            'plant_id' => (isset($request->sub_plant_id)) ? $request->sub_plant_id : $request->plant_id, 
        ]);

        return redirect()->route('admin.master_sample')->with('success', __('general.added_successfully'));
    }
    public function master_sample_edit($id)
    {
        $sample = SamplePlant::findOrFail($id);
        $plant_master = Plant::select('id', 'name')->whereNull('plant_id')->get();
        $sub_plants = Plant::select('id', 'name' , 'plant_id' )->whereNotNull('plant_id')->get();
        $data = [
            'main' => $sample,
            'route' => 'master_sample',
            'plant_master' => $plant_master,
            'sub_plants' => $sub_plants,
        ];
        return view('sample_part.master_sample_edit', $data);
    }
    public function master_sample_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:plant_samples,name,' . $id . ',id',
            'plant_id' => 'required|exists:plants,id',
        ]);

        $sample = SamplePlant::findOrFail($id);
        $sample->update([
            'name' => $request->name,
            'plant_id' => (isset($request->sub_plant_id)) ? $request->sub_plant_id : $request->plant_id,
        ]);

        return redirect()->route('admin.master_sample')->with('success', __('general.updated_successfully'));
    }
    public function master_sample_destroy($id)
    {
        $sample = SamplePlant::findOrFail($id);
        $sample->delete();
        return redirect()->route('admin.master_sample')->with('success', __('general.deleted_successfully'));
    }
    public function delete_sample_from_plant($id)
    {
        $deleted = DB::connection('tenant')->table('plant_samples')->where('id', $id)->delete();

        return response()->json([
            'status'  => 200,
            'success' => $deleted > 0,
        ]);
    }
    public function delete_sub_plant_from_plant($id)
    {
        $plant = Plant::findOrFail($id);
        if ($plant->samplePlants()->count() > 0) {
            $deleted = DB::connection('tenant')->table('plant_samples')->where('id', $id)->delete();
        }
        $main_deleted = DB::connection('tenant')->table('plants')->where('id', $id)->delete();
        return response()->json([
            'status'  => 200,
            'success' => $main_deleted > 0,
        ]);
    }
}

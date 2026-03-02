<?php

namespace App\Http\Controllers\part;

use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SamplePlant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class PlantController extends Controller
{
    use AuthorizesRequests;

    public function plant_index(Request $request)
    {
        $plants = Plant::with('mainPlant')->select('id', 'name', 'plant_id')->orderBy("created_at", "desc")->paginate(10);
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
        $this->authorize('create_plant');

        $data = [
            'route' => 'plant',
        ];
        return view('sample_part.create', $data);
    }

    public function plant_store(Request $request)
    {
        $this->authorize('create_plant');

        $request->validate([
            'name' => 'required|string|max:255',
            'plant_id' => 'nullable|exists:plants,id',
        ]);

        try {
            $plant = Plant::create([
                'name' => $request->name,
                'plant_id' => $request->plant_id ?? null,
            ]);

            return redirect()->route('admin.plant')->with('success', __('general.added_successfully'));
        } catch (\Exception $e) {
            Log::error('Error creating plant: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
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
        $this->authorize('edit_plant');

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
        $this->authorize('edit_plant');

        $request->validate([
            'name' => 'required|string|max:255|unique:plants,name,' . $id . ',id',
            'plant_id' => 'nullable|exists:plants,id',
        ]);

        try {
            $plant = Plant::findOrFail($id);

            $plant->update([
                'name' => $request->name,
                'plant_id' => $request->plant_id ?? null,
            ]);

            return redirect()->route('admin.plant')->with('success', __('general.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error updating plant: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'plant_id' => $id,
                'request' => $request->except(['_token', 'password'])
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')])
                ->withInput();
        }
    }
    public function plant_destroy($id)
    {
        $this->authorize('delete_plant');

        try {
            $plant = Plant::with(['sub_plants.samplePlants', 'samplePlants'])->findOrFail($id);
            
            // Check if plant is being used (excluding sub-plants and sample plants which will be deleted)
            // We need to check if it's used in samples, submissions, results, or schedulers
            $isUsedInData = $plant->samples_as_main()->exists() 
                || $plant->samples_as_sub()->exists()
                || $plant->submissions_as_main()->exists()
                || $plant->submissions_as_sub()->exists()
                || $plant->results_as_main()->exists()
                || $plant->results_as_sub()->exists()
                || $plant->routine_schedulers_as_main()->exists()
                || $plant->routine_schedulers_as_sub()->exists();
            
            if ($isUsedInData) {
                $usage = $plant->getUsageDetails();
                $message = __('general.cannot_delete_plant_in_use', [
                    'name' => $plant->name,
                    'samples' => $usage['samples_main'] + $usage['samples_sub'],
                    'submissions' => $usage['submissions_main'] + $usage['submissions_sub'],
                    'results' => $usage['results_main'] + $usage['results_sub'],
                    'schedulers' => $usage['schedulers_main'] + $usage['schedulers_sub'],
                    'total' => $usage['samples_main'] + $usage['samples_sub'] 
                        + $usage['submissions_main'] + $usage['submissions_sub']
                        + $usage['results_main'] + $usage['results_sub']
                        + $usage['schedulers_main'] + $usage['schedulers_sub']
                ]);
                
                return back()->withErrors(['error' => $message])
                    ->with('error', $message);
            }

            // Use transaction for cascade delete
            DB::beginTransaction();

            // If this is a master plant (no plant_id), delete all sub-plants and their sample plants
            if ($plant->plant_id === null) {
                // Get all sub-plants recursively
                $subPlants = $plant->sub_plants;

                foreach ($subPlants as $subPlant) {
                    // Delete all sample plants for this sub-plant
                    $subPlant->samplePlants()->delete();

                    // Recursively get and delete nested sub-plants
                    $this->deleteSubPlantsRecursively($subPlant);
                }

                // Delete all direct sample plants of the master plant
                $plant->samplePlants()->delete();

                // Delete all sub-plants
                $plant->sub_plants()->delete();
            } else {
                // If this is a sub-plant, delete its sample plants
                $plant->samplePlants()->delete();

                // Delete nested sub-plants recursively
                $this->deleteSubPlantsRecursively($plant);
            }

            // Finally, delete the plant itself
            $plant->delete();

            DB::commit();

            return redirect()->route('admin.plant')->with('success', __('general.deleted_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting plant: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'plant_id' => $id
            ]);

            return back()->withErrors(['error' => __('general.something_went_wrong')]);
        }
    }

    private function deleteSubPlantsRecursively($plant)
    {
        $subPlants = $plant->sub_plants;

        foreach ($subPlants as $subPlant) {
            // Delete sample plants
            $subPlant->samplePlants()->delete();

            // Recursively delete nested sub-plants
            $this->deleteSubPlantsRecursively($subPlant);
        }

        // Delete the sub-plants
        $plant->sub_plants()->delete();
    }
    public function get_sub_plants(Request $request)
    {
        $sub_plants = Plant::select('id', 'name')->where('plant_id', $request->plant_id)->get();
        return response()->json([
            'status' => 200,
            'sub_plants' => $sub_plants,
        ]);
    }
    public function master_sample_index()
    {
        $plant_master = Plant::select('id', 'name', 'plant_id')->whereNull('plant_id')->orderBy("created_at", "desc")->paginate(10);
        $sub_plants = Plant::select('id', 'name', 'plant_id')->whereNotNull('plant_id')->get();
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
        $sub_plants = Plant::select('id', 'name', 'plant_id')->whereNotNull('plant_id')->get();
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

<?php
namespace App\Http\Controllers\part_three;

use App\Http\Controllers\Controller;
use App\Models\COATemplate;
use App\Models\Sample;
use App\Models\Plant;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class COATemplateController extends Controller
{
    public function template_designer()
    {
        $temp = COATemplate::select('id', 'name', 'value')->with('samples' , 'samples.sample_plant')->get();
        $data = [
            'temp' => $temp,
        ];
        return view('part_three.template_designer.template', $data);
    }
    public function template_list()
    {
        $temp = COATemplate::select('id', 'name', 'value')->with('samples' , 'samples.sample_plant')->get();
        $data = [
            'temp' => $temp,
        ];
        return view('part_three.template_designer.master_template', $data);
    }
    public function add_template_designer()
    {
        // $temp = null;
        // if(!is_null($id)){
        //     $temp = COATemplate::select('id' , 'name' , 'value')->find($id);
        // }
        // $data = [
        //     'temp'      => $temp,
        // ];
        // dd($temp);
        return view('part_three.template_designer.add-template');
    }
    public function edit_template_designer($id)
    {
        // $temp = null;
        if (! is_null($id)) {
            $temp = COATemplate::find($id);
        }
        $data = [
            'temp' => $temp,
        ];
        // dd($temp);
        return view('part_three.template_designer.edit-template', $data);
    }

    public function coa_settings(Request $request)
    {

        $data = array_merge([
            'header_information'             => 0,
            'sample_information'             => 0,
            'test_results'                   => 0,
            'footer_information'             => 0,
            'authorization'                  => 0,

            'company_logo'                   => 0,
            'company_name'                   => 0,
            'laboratory_accreditation'       => 0,
            'coa_number'                     => 0,
            'lims_number'                    => 0,
            'report_date'                    => 0,

            'sample_plant'                   => 0,
            'sample_subplant'                => 0,
            'sample_point'                   => 0,
            'sample_description'             => 0,
            'batch_lot_number'               => 0,
            'date_received'                  => 0,
            'date_analyzed'                  => 0,
            'date_authorized'                => 0,

            'component_name'                 => 0,
            'specification'                  => 0,
            'test_method'                    => 0,
            'pass_fail_status'               => 0,
            'results'                        => 0,
            'analyst'                        => 0,
            'unit'                           => 0,

            'analyzed_by'                    => 0,
            'authorized_by'                  => 0,
            'digital_signature'              => 0,
            'comments'                       => 0,

            'disclaimer_text'                => 0,
            'laboratory_contact_information' => 0,
            'page_numbers'                   => 0,
        ], $request->only([
            'header_information',
            'sample_information',
            'test_results',
            'footer_information',
            'authorization',

            'name',
            'company_logo',
            'company_name',
            'laboratory_accreditation',
            'coa_number',
            'lims_number',
            'report_date',

            'sample_plant',
            'sample_subplant',
            'sample_point',
            'sample_description',
            'batch_lot_number',
            'date_received',
            'date_analyzed',
            'date_authorized',

            'component_name',
            'specification',
            'test_method',
            'pass_fail_status',
            'results',
            'analyst',
            'unit',

            'analyzed_by',
            'authorized_by',
            'digital_signature',
            'comments',

            'disclaimer_text',
            'laboratory_contact_information',
            'page_numbers',
        ]));

        try {
            COATemplate::create($data);
            return to_route('admin.template_designer')->with('success', __('general.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error creating COA template: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            Toastr::error(translate('something_went_wrong'));
            return back()->withInput();
        }
    }
    public function coa_settings_update(Request $request, $id)
    {
        $temp = COATemplate::findOrFail($id);
        // dd($request->all());
        $data = array_merge([
            'header_information'             => 0,
            'sample_information'             => 0,
            'test_results'                   => 0,
            'footer_information'             => 0,
            'authorization'                  => 0,
            'company_logo'                   => 0,
            'company_name'                   => 0,
            'laboratory_accreditation'       => 0,
            'coa_number'                     => 0,
            'lims_number'                    => 0,
            'report_date'                    => 0,

            'sample_plant'                   => 0,
            'sample_subplant'                => 0,
            'sample_point'                   => 0,
            'sample_description'             => 0,
            'batch_lot_number'               => 0,
            'date_received'                  => 0,
            'date_analyzed'                  => 0,
            'date_authorized'                => 0,

            'component_name'                 => 0,
            'specification'                  => 0,
            'test_method'                    => 0,
            'pass_fail_status'               => 0,
            'results'                        => 0,
            'analyst'                        => 0,
            'unit'                           => 0,

            'analyzed_by'                    => 0,
            'authorized_by'                  => 0,
            'digital_signature'              => 0,
            'comments'                       => 0,

            'disclaimer_text'                => 0,
            'laboratory_contact_information' => 0,
            'page_numbers'                   => 0,
        ], $request->only([
            'header_information',
            'sample_information',
            'test_results',
            'footer_information',
            'authorization',

            'name',
            'company_logo',
            'company_name',
            'laboratory_accreditation',
            'coa_number',
            'lims_number',
            'report_date',

            'sample_plant',
            'sample_subplant',
            'sample_point',
            'sample_description',
            'batch_lot_number',
            'date_received',
            'date_analyzed',
            'date_authorized',

            'component_name',
            'specification',
            'test_method',
            'pass_fail_status',
            'results',
            'analyst',
            'unit',

            'analyzed_by',
            'authorized_by',
            'digital_signature',
            'comments',

            'disclaimer_text',
            'laboratory_contact_information',
            'page_numbers',
        ]));
        
        try {
            $temp->update($data);
            return to_route('admin.template_designer')->with('success', __('general.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Error updating COA template: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id' => $id
            ]);
            Toastr::error(translate('something_went_wrong'));
            return back()->withInput();
        }
    }
    public function update_default_status(Request $request)
    {

        COATemplate::where('id', $request->temp_id)->update([
            'value' => $request->default ?? 0,
        ]);

        Toastr::success(translate('status_Changed'));
        return back();
    }
    public function assign_page($id)
    {
        try {
            $template = COATemplate::select('name', 'id')->where('id', $id)->first();
            
            if (!$template) {
                Toastr::error(translate('Template not found.'));
                return back();
            }
            
            // Get samples - check if coa_template_samples table exists
            $samplesQuery = Sample::select('id', 'plant_sample_id', 'plant_id', 'sub_plant_id')
                ->with(['sample_plant:id,name', 'plant_main:id,name']);
            
            // Filter out already assigned samples if table exists
            if (Schema::hasTable('coa_template_samples')) {
                try {
                    $samplesQuery->whereNotIn('id', function ($query) use ($id) {
                        $query->select('sample_id')
                            ->from('coa_template_samples')
                            ->where('coa_temp_id', $id);
                    });
                } catch (\Exception $e) {
                    Log::warning('Error filtering samples: ' . $e->getMessage());
                    // Continue without filtering
                }
            }
            
            $samples = $samplesQuery->get();
                
            // Get plants, checking if coa_template_plants table exists
            $plantsQuery = Plant::select('id', 'name')
                ->whereNull('plant_id'); // Only main plants
            
            // Only filter by existing assignments if table exists
            try {
                if (Schema::hasTable('coa_template_plants')) {
                    $plantsQuery->whereNotIn('id', function ($query) use ($id) {
                        $query->select('plant_id')
                            ->from('coa_template_plants')
                            ->where('coa_temp_id', $id);
                    });
                }
            } catch (\Exception $e) {
                Log::warning('coa_template_plants table check failed: ' . $e->getMessage());
                // Table doesn't exist, continue without filtering
            }
            
            $plants = $plantsQuery->get();
                
            $data = [
                'template' => $template,
                'samples'  => $samples,
                'plants'   => $plants,
                'id'       => $id,
            ];
            
            return view('part_three.template_designer.assign', $data);
        } catch (\Exception $e) {
            Log::error('Error in assign_page: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id' => $id
            ]);
            Toastr::error(translate('something_went_wrong') . ': ' . $e->getMessage());
            return back();
        }
    }
    public function assign(Request $request)
    {
        $request->validate([
            'coa_temp_id' => 'required|exists:c_o_a_templates,id',
            'sample_id'   => 'nullable|array',
            'sample_id.*' => 'exists:samples,id',
            'plant_id'    => 'nullable|array',
            'plant_id.*'  => 'exists:plants,id',
        ]);

        // At least one assignment type must be provided
        if (empty($request->sample_id) && empty($request->plant_id)) {
            Toastr::error(translate('Please select at least one sample or plant.'));
            return back();
        }

        DB::beginTransaction();
        try {
            $template = COATemplate::findOrFail($request->coa_temp_id);

            // Assign to samples (sample-specific, highest priority)
            if (!empty($request->sample_id)) {
                // Check if table exists
                if (!Schema::hasTable('coa_template_samples')) {
                    DB::rollBack();
                    Toastr::error(translate('coa_template_samples_table_not_found_please_run_migrations'));
                    return back();
                }
                
                // Check for duplicates
                $existingSamples = DB::table('coa_template_samples')
                    ->whereIn('sample_id', $request->sample_id)
                    ->where('coa_temp_id', $request->coa_temp_id)
                    ->pluck('sample_id')
                    ->toArray();

                if (!empty($existingSamples)) {
                    DB::rollBack();
                    Toastr::error(translate('One or more selected samples already assigned to this template.'));
                    return back();
                }

                // Check if any sample already has plant-level assignment that would conflict
                if (Schema::hasTable('coa_template_plants')) {
                    try {
                        $conflictingSamples = DB::table('samples')
                            ->whereIn('samples.id', $request->sample_id)
                            ->join('coa_template_plants', function ($join) use ($request) {
                                $join->on('samples.plant_id', '=', 'coa_template_plants.plant_id')
                                     ->where('coa_template_plants.coa_temp_id', '=', $request->coa_temp_id);
                            })
                            ->pluck('samples.id')
                            ->toArray();

                        if (!empty($conflictingSamples)) {
                            // Remove plant-level assignment for these samples (sample-specific takes priority)
                            DB::table('coa_template_plants')
                                ->where('coa_temp_id', $request->coa_temp_id)
                                ->whereIn('plant_id', function ($query) use ($conflictingSamples) {
                                    $query->select('plant_id')
                                          ->from('samples')
                                          ->whereIn('id', $conflictingSamples);
                                })
                                ->delete();
                        }
                    } catch (\Exception $e) {
                        Log::warning('Error checking conflicting samples: ' . $e->getMessage());
                        // Continue without removing plant assignments
                    }
                }

                $data = [];
                $hasIsActive = Schema::hasColumn('coa_template_samples', 'is_active');
                
                foreach ($request->sample_id as $sampleId) {
                    $row = [
                        'sample_id'   => $sampleId,
                        'coa_temp_id' => $request->coa_temp_id,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                    
                    // Only add is_active if column exists
                    if ($hasIsActive) {
                        $row['is_active'] = true;
                    }
                    
                    $data[] = $row;
                }

                DB::table('coa_template_samples')->insert($data);
            }

            // Assign to plants (plant-level default, lower priority)
            if (!empty($request->plant_id)) {
                // Check if table exists first
                if (!Schema::hasTable('coa_template_plants')) {
                    DB::rollBack();
                    Toastr::error(translate('coa_template_plants_table_not_found_please_run_migrations'));
                    return back();
                }
                
                // Check for duplicates
                $existingPlants = DB::table('coa_template_plants')
                    ->whereIn('plant_id', $request->plant_id)
                    ->where('coa_temp_id', $request->coa_temp_id)
                    ->pluck('plant_id')
                    ->toArray();

                if (!empty($existingPlants)) {
                    DB::rollBack();
                    Toastr::error(translate('One or more selected plants already assigned to this template.'));
                    return back();
                }

                // Check if any plant has samples with specific assignments that would conflict
                $conflictingPlants = DB::table('coa_template_samples')
                    ->join('samples', 'coa_template_samples.sample_id', '=', 'samples.id')
                    ->where('coa_template_samples.coa_temp_id', $request->coa_temp_id)
                    ->whereIn('samples.plant_id', $request->plant_id)
                    ->pluck('samples.plant_id')
                    ->unique()
                    ->toArray();

                if (!empty($conflictingPlants)) {
                    // Don't assign plant-level if samples already have specific assignment
                    // Sample-specific takes priority, so we skip these plants
                    $request->plant_id = array_diff($request->plant_id, $conflictingPlants);
                    
                    if (empty($request->plant_id)) {
                        DB::rollBack();
                        Toastr::warning(translate('Cannot assign plant-level template: Some samples already have specific assignments. Sample-specific assignments take priority.'));
                        return back();
                    }
                }

                $plantData = [];
                $hasIsActive = Schema::hasColumn('coa_template_plants', 'is_active');
                
                foreach ($request->plant_id as $plantId) {
                    $row = [
                        'plant_id'    => $plantId,
                        'coa_temp_id' => $request->coa_temp_id,
                        'is_default'  => true,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];
                    
                    // Only add is_active if column exists
                    if ($hasIsActive) {
                        $row['is_active'] = true;
                    }
                    
                    $plantData[] = $row;
                }

                DB::table('coa_template_plants')->insert($plantData);
            }

            DB::commit();

            Toastr::success(translate('template_Assignment_Successfully'));
            return to_route('admin.template_designer');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error assigning COA template: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            Toastr::error(translate('something_went_wrong'));
            return back()->withInput();
        }
    }

    /**
     * Toggle active status for sample assignment
     */
    public function toggleSampleAssignment(Request $request, $templateId, $sampleId)
    {
        try {
            $assignment = DB::table('coa_template_samples')
                ->where('coa_temp_id', $templateId)
                ->where('sample_id', $sampleId)
                ->first();

            if (!$assignment) {
                Toastr::error(translate('Assignment not found.'));
                return back();
            }

            // Check if is_active column exists
            if (Schema::hasColumn('coa_template_samples', 'is_active')) {
                DB::table('coa_template_samples')
                    ->where('coa_temp_id', $templateId)
                    ->where('sample_id', $sampleId)
                    ->update(['is_active' => !$assignment->is_active]);
            } else {
                Toastr::warning(translate('is_active_column_not_found_please_run_migrations'));
            }

            Toastr::success(translate('Status updated successfully.'));
            return back();
        } catch (\Exception $e) {
            Log::error('Error toggling sample assignment: ' . $e->getMessage());
            Toastr::error(translate('something_went_wrong'));
            return back();
        }
    }

    /**
     * Toggle active status for plant assignment
     */
    public function togglePlantAssignment(Request $request, $templateId, $plantId)
    {
        try {
            if (!Schema::hasTable('coa_template_plants')) {
                Toastr::error(translate('coa_template_plants_table_not_found_please_run_migrations'));
                return back();
            }
            
            $assignment = DB::table('coa_template_plants')
                ->where('coa_temp_id', $templateId)
                ->where('plant_id', $plantId)
                ->first();

            if (!$assignment) {
                Toastr::error(translate('Assignment not found.'));
                return back();
            }

            // Check if is_active column exists
            if (Schema::hasColumn('coa_template_plants', 'is_active')) {
                DB::table('coa_template_plants')
                    ->where('coa_temp_id', $templateId)
                    ->where('plant_id', $plantId)
                    ->update(['is_active' => !$assignment->is_active]);
            } else {
                Toastr::warning(translate('is_active_column_not_found_please_run_migrations'));
            }

            Toastr::success(translate('Status updated successfully.'));
            return back();
        } catch (\Exception $e) {
            Log::error('Error toggling plant assignment: ' . $e->getMessage());
            Toastr::error(translate('something_went_wrong'));
            return back();
        }
    }

    /**
     * Delete sample assignment
     */
    public function deleteSampleAssignment($templateId, $sampleId)
    {
        try {
            DB::table('coa_template_samples')
                ->where('coa_temp_id', $templateId)
                ->where('sample_id', $sampleId)
                ->delete();

            Toastr::success(translate('Assignment deleted successfully.'));
            return back();
        } catch (\Exception $e) {
            Log::error('Error deleting sample assignment: ' . $e->getMessage());
            Toastr::error(translate('something_went_wrong'));
            return back();
        }
    }

    /**
     * Delete plant assignment
     */
    public function deletePlantAssignment($templateId, $plantId)
    {
        try {
            if (!Schema::hasTable('coa_template_plants')) {
                Toastr::error(translate('coa_template_plants_table_not_found_please_run_migrations'));
                return back();
            }
            
            DB::table('coa_template_plants')
                ->where('coa_temp_id', $templateId)
                ->where('plant_id', $plantId)
                ->delete();

            Toastr::success(translate('Assignment deleted successfully.'));
            return back();
        } catch (\Exception $e) {
            Log::error('Error deleting plant assignment: ' . $e->getMessage());
            Toastr::error(translate('something_went_wrong'));
            return back();
        }
    }

    /**
     * Show all COA templates with their assignments (comprehensive view)
     */
    public function assignAll()
    {
        $templates = COATemplate::with([
            'samples.sample_plant',
            'samples.plant_main',
            'plants'
        ])->get();

        $plants = Plant::whereNull('plant_id')->get();
        $allSamples = Sample::with('sample_plant', 'plant_main')->get();

        $data = [
            'templates' => $templates,
            'plants' => $plants,
            'allSamples' => $allSamples,
        ];

        return view('part_three.template_designer.assign_all', $data);
    }

}

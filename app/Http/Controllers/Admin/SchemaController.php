<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Schema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Nette\Utils\Json;

class SchemaController extends Controller
{
    public function list(Request $request)
    {
        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];

            Schema::whereIn('id', $ids)->update($data);
            return back()->with('success', translate('updated_successfully'));
        }
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {
            Schema::whereIn('id', $ids)->delete();
            return back()->with('success', translate('deleted_successfully'));
        }

        $schemas = Schema::orderBy("created_at", "desc")->paginate(10);
        return view("admin.schema.schema_list", compact("schemas"));
    }
    public function create()
    {
        return view('admin.schema.create');
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'currency' => 'required|string',
            'display' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:active,inactive',

            // count fields
            'test_method_count' => 'nullable|integer|min:0',
            'unit_count' => 'nullable|integer|min:0',
            'result_types_count' => 'nullable|integer|min:0',
            'sample_count' => 'nullable|integer|min:0',
            'plants_count' => 'nullable|integer|min:0',
            'create_sample_count' => 'nullable|integer|min:0',
            'toxic_degree_count' => 'nullable|integer|min:0',
            'submissions_count' => 'nullable|integer|min:0',
            'sample_routine_scheduler_count' => 'nullable|integer|min:0',
            'frequencies_count' => 'nullable|integer|min:0',
            'results_count' => 'nullable|integer|min:0',
            'template_designer_count' => 'nullable|integer|min:0',
            'coa_generation_settings_count' => 'nullable|integer|min:0',
            'certificate_count' => 'nullable|integer|min:0',
            'emails_count' => 'nullable|integer|min:0',
            'users_count' => 'nullable|integer|min:0',
            'clients_count' => 'nullable|integer|min:0',
        ]);

        $modules = [
            'scan_barcode',
            'test_method_management',
            'unit',
            'result_types',
            'sample_management',
            'assig_test_to_sample',
            'plants',
            'create_sample',
            'toxic_degree',
            'submissions_management',
            'sample_routine_scheduler',
            'frequencies',
            'results',
            'template_designer_list',
            'coa_generation_settings',
            'certificate_management',
            'emails',
            'users',
            'clients',
            'roles',
            'system_setup',
        ];

        $data = $validated;
        foreach ($modules as $module) {
            $data[$module] = in_array($module, $request->modules ?? []) ? 1 : 0;
        }

        Schema::create($data);

        return redirect()->route('admin.schema')->with('success', translate('Schema created successfully!'));
    }

    public function edit($id)
    {
        $schema = Schema::findOrFail($id);
        return view('admin.schema.edit', compact('schema'));
    }

    public function update(Request $request, $id)
    {
        $schema = Schema::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'currency' => 'required|string',
            'display' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:active,inactive',

            // count fields
            'test_method_count' => 'nullable|integer|min:0',
            'unit_count' => 'nullable|integer|min:0',
            'result_types_count' => 'nullable|integer|min:0',
            'sample_count' => 'nullable|integer|min:0',
            'plants_count' => 'nullable|integer|min:0',
            'create_sample_count' => 'nullable|integer|min:0',
            'toxic_degree_count' => 'nullable|integer|min:0',
            'submissions_count' => 'nullable|integer|min:0',
            'sample_routine_scheduler_count' => 'nullable|integer|min:0',
            'frequencies_count' => 'nullable|integer|min:0',
            'results_count' => 'nullable|integer|min:0',
            'template_designer_count' => 'nullable|integer|min:0',
            'coa_generation_settings_count' => 'nullable|integer|min:0',
            'certificate_count' => 'nullable|integer|min:0',
            'emails_count' => 'nullable|integer|min:0',
            'users_count' => 'nullable|integer|min:0',
            'clients_count' => 'nullable|integer|min:0',
        ]);

        $modules = [
            'scan_barcode',
            'test_method_management',
            'unit',
            'result_types',
            'sample_management',
            'assig_test_to_sample',
            'plants',
            'create_sample',
            'toxic_degree',
            'submissions_management',
            'sample_routine_scheduler',
            'frequencies',
            'results',
            'template_designer_list',
            'coa_generation_settings',
            'certificate_management',
            'emails',
            'users',
            'clients',
            'roles',
            'system_setup',
        ];

        $data = $validated;
        foreach ($modules as $module) {
            $data[$module] = in_array($module, $request->modules ?? []) ? 1 : 0;
        }
        $schema->update($data);
        return redirect()->route('admin.schema')->with('success', translate('Schema updated successfully!'));
    }

    public function list_for_api(Request $request)
    {
         
        $schemas = Schema::orderBy("created_at", "desc")->paginate(10);
        return Json::encode($schemas); 
    }

    public function show($id){
        $schema = Schema::with('tenants')->findOrFail($id);
        $tenant_counts = $schema->tenants()->count(); 
          $modules = [
        'scan_barcode' => 'Scan Barcode',
        'test_method_management' => 'Test Method Management',
        'unit' => 'Unit',
        'result_types' => 'Result Types',
        'sample_management' => 'Sample Management',
        'assig_test_to_sample' => 'Assign Test to Sample',
        'plants' => 'Plants',
        'create_sample' => 'Create Sample',
        'toxic_degree' => 'Toxic Degree',
        'submissions_management' => 'Submissions Management',
        'sample_routine_scheduler' => 'Sample Routine Scheduler',
        'frequencies' => 'Frequencies',
        'results' => 'Results',
        'template_designer_list' => 'Template Designer',
        'coa_generation_settings' => 'COA Generation Settings',
        'certificate_management' => 'Certificate Management',
        'emails' => 'Emails',
        'users' => 'Users',
        'clients' => 'Clients',
        'roles' => 'Roles',
        'system_setup' => 'System Setup',
    ];
            $countFields = [
            'test_method_count' => 'Test Method Count',
            'unit_count' => 'Unit Count',
            'result_types_count' => 'Result Types Count',
            'sample_count' => 'Sample Count',
            'plants_count' => 'Plants Count',
            'create_sample_count' => 'Create Sample Count',
            'toxic_degree_count' => 'Toxic Degree Count',
            'submissions_count' => 'Submissions Count',
            'sample_routine_scheduler_count' => 'Sample Routine Scheduler Count',
            'frequencies_count' => 'Frequencies Count',
            'results_count' => 'Results Count',
            'template_designer_count' => 'Template Designer Count',
            'coa_generation_settings_count' => 'COA Generation Settings Count',
            'certificate_count' => 'Certificate Count',
            'emails_count' => 'Emails Count',
            'users_count' => 'Users Count',
            'clients_count' => 'Clients Count',
        ];
        $data = [
            'schema'                => $schema,
            'tenant_counts'         => $tenant_counts,
            'modules'               => $modules,
            'countFields'           => $countFields,
        ];
        return view('admin.schema.show' , $data);
    }
}

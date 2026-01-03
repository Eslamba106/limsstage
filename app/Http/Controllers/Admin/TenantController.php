<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Sample;
use App\Models\Schema;
use App\Models\Tenant;
use App\helper\Helpers;
use App\Models\part\Unit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\CompanyCreated;
use App\Models\part\ResultType;
use App\Models\part_three\Result;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\first_part\TestMethod;
use App\Models\second_part\SampleRoutineScheduler;
use App\Models\second_part\Submission;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TenantController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {

        // $this->authorize('tenant_management');

        Tenant::deactivateExpiredTenants();

        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status]; 

            Tenant::whereIn('id', $ids)->update($data);
            return back()->with('success', __('general.updated_successfully'));
        }
        if ($request->bulk_action_btn === 'delete' &&  is_array($ids) && count($ids)) {


            Tenant::whereIn('id', $ids)->delete();
            return back()->with('success', __('general.deleted_successfully'));
        }

        $tenants = Tenant::orderBy("created_at", "desc")->paginate(10);
        return view("admin.tenant.tenant_list", compact("tenants"));
    }
 

    public function create()
    {
        $schemas = Schema::select('id' , 'name')->get();
        $data = [
            'schemas' => $schemas,
        ];
        return view("admin.tenant.create" , $data);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name'             => 'required|string|max:255',
            'tenant_id'         => 'required|unique:tenants,tenant_id',
            // 'phone'            => 'nullable|string|max:15', 
            'user_name'        => 'required|string|max:50',
            'password'         => 'nullable|string|min:5',
        ]);

        // DB::beginTransaction();
        // try {


        $tenant                                             = Tenant::create([
            'name'                          => $request->name ?? 0,
            'tenant_id'                     => $request->tenant_id ?? 0,
            'domain'                        => $request->tenant_id . '.limsstage.com' ,
            'user_count'                    => $request->user_count ?? 10,
            'setup_cost'                    => $request->setup_cost ?? 0,
            'creation_date'                 => $request->creation_date ?? null,
            'applicable_date'           => $request->tenant_applicable_date ?? null,
            'status'           => $request->status ?? 'active',
            'phone'            => $request->phone ?? null,
            'email'            => $request->email ?? null,
             'schema_id'       => $request->schema_id,
            'tenant_delete_days'            => $request->tenant_delete_days ,
            'expire'                 => $request->expire ?? carbon::now()->addMonth()->format('Y-m-d'),
        ]);
        $user = User::create([
            'name'             => $request->name ?? null,
            'user_name'        => $request->user_name ?? null,
            'password'         => Hash::make($request->password),
            'my_name'          => $request->password,
            'role_name'        => 'admin',
            'role_id'          => 2,
            'phone'            => $request->phone ?? null,
            'email'            => $request->email ?? null,
           
        ]);

        DB::commit();
        event(new CompanyCreated($tenant));
        return redirect()->route('admin.tenant_management')->with("success", __('general.added_successfully'));
        // } catch (Throwable $th) {
        //     DB::rollBack();
        //     return redirect()->back()->with('error', $th->getMessage());
        // }
    }
    public function register(Request $request)
    {
        // dd($request->all());
         $request->validate([
            'name'             => 'required|string|max:255',
            'tenant_id'         => 'required|unique:tenants,tenant_id', 
            'user_name'        => 'required|string|max:50',
            'password'         => 'nullable|string|min:5',
        ]);

        DB::beginTransaction();
        try {


            $tenant                                             = Tenant::create([
                'name'                          => $request->name ?? 0,
                'tenant_id'                     => $request->tenant_id ?? 0,
                'domain'                        => $request->tenant_id . '.' . $request->getHost(),
                'user_count'                    => $request->user_count ?? 10,
                'setup_cost'                    => $request->setup_cost ?? 0,
                'creation_date'                 => $request->creation_date ?? null,
                'applicable_date'           => $request->tenant_applicable_date ?? null,
                'status'           => $request->status ?? 'active',
                'phone'            => $request->phone ?? null,
                'schema_id'            => $request->schema_id,
                'email'            => $request->email ?? null,
            ]);
            $user = User::create([
                'name'             => $request->name ?? null,
                'user_name'        => $request->user_name ?? null,
                'password'         => Hash::make($request->password),
                'my_name'          => $request->password,
                'role_name'        => 'admin',
                'role_id'          => 2,
                'phone'            => $request->phone ?? null,
                'email'            => $request->email ?? null,

            ]);

            DB::commit();
            // event(new CompanyCreated($tenant));
            // if ($request->outside_register) {
            //     return redirect()->away("http://{$request->tenant_id}.limsstage.com")
            //         ->with("success", __('general.added_successfully'));
            // }
            return redirect()->route('payment.page' , [$request->schema_id ,'tenant_id'=>$tenant->id ])->with("success", translate('general.added_successfully'));
        } catch (Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        if(!Helpers::module_check('edit_tenant')){
            return abort(403);
        }
        $tenant = Tenant::findOrFail($id);
         $schemas = Schema::select('id' , 'name')->get();
         $data = [
             'schemas' => $schemas,
             'tenant' => $tenant,
         ];
        return view("admin.tenant.edit", $data);
    }

    public function update(Request $request, $id)
    {
        if(!Helpers::module_check('edit_tenant')){
            return abort(403);
        }
        $validatedData = $request->validate([
            'name'             => 'required|string|max:255',
            'tenant_id'         => 'required|unique:tenants,tenant_id,' . $id, 
            'tenant_delete_days'            => 'required|integer',  
        ]);

        $tenant = Tenant::findOrFail($id);
        $tenant->name = $request->name;
        $tenant->tenant_id = $request->tenant_id;
        $tenant->domain = $request->tenant_id . '.limsstage.com' ; 
        $tenant->tenant_delete_days = $request->tenant_delete_days; 
        $tenant->schema_id = $request->schema_id;
        $tenant->phone = $request->phone;
        $tenant->email = $request->email; 

        $tenant->save();


        // update tenant databas
        $db = "lims_{$tenant->id}";
        DB::purge('tenant');
        Config::set('database.connections.tenant.database', $db);
        DB::reconnect('tenant');
        (new Tenant())->setConnection('tenant')->where('id', $tenant->id)->update([
            'name'                          => $request->name ?? 0,
            'tenant_id'                     => $request->tenant_id ?? 0,
            'domain'                        => $request->tenant_id . '.' . '.limsstage.com', 
            'tenant_delete_days'            => $request->tenant_delete_days ,
            'phone'            => $request->phone ?? null,
            'email'            => $request->email ?? null,
            'schema_id'            => $request->schema_id,
            'expire'                 => $request->expire ,
        ]);
        return redirect()->route('admin.tenant_management')->with("success", translate('updated_successfully'));
    }

    public function registerPage($id)
    {
        $schema = Schema::findOrFail($id);
        return view("admin.tenant.register", compact("schema"));
    }
    public function show($id)
    {
        $tenant = Tenant::findOrFail($id);
        DB::purge('tenant');
        Config::set('database.connections.tenant.database', 'lims_' . $tenant->id);
        DB::reconnect('tenant'); 
        $users_count = User::on('tenant')->count(); 
        $samples_count = Sample::on('tenant')->count(); 
        $test_method_count = TestMethod::on('tenant')->count(); 
        $submission_count = Submission::on('tenant')->count();
        $units_count = Unit::on('tenant')->count();
        $result_count = Result::on('tenant')->count();
        $result_type_count = ResultType::on('tenant')->count();
        $result_pending = Result::on('tenant')->where('status' , 'pending')->count();
        $result_completed = Result::on('tenant')->where('status' ,'!=', 'pending')->count();
        $schesules_count = SampleRoutineScheduler::on('tenant')->count();
        $user = User::on('tenant')->first();
        $data = [ 
            'users_count' => $users_count,  
            'samples_count' => $samples_count,  
            'test_method_count' => $test_method_count,  
            'submission_count' => $submission_count,  
            'units_count'       => $units_count,
            'result_count'      => $result_count,
            'result_type_count' => $result_type_count,
            'result_pending'    => $result_pending,
            'result_completed'  => $result_completed,
            'schesules_count'   => $schesules_count,
            'tenant'            => $tenant,
            'user'              => $user,
        ];
        
        return view("admin.tenant.show", $data);
    }

    
}

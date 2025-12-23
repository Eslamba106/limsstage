<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Schema;
use App\Models\Tenant;
use App\helper\Helpers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\CompanyCreated;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
    // public function edit($id){
    //     $this->authorize('edit_driver');
    //     $driver = Driver::findOrFail($id);
    //     $countries = Countries::select('id', 'name' , 'nationality')->get();
    //     $dail_code_main = Countries::select('id', 'dial_code')->get();
    //     return view("general.drivers.edit", compact("driver", "countries" ,'dail_code_main'));
    // }

    public function create()
    {

        return view("admin.tenant.create");
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
        return view("admin.tenant.edit", compact("tenant"));
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
        $tenant->save();


        // update tenant databas
        $db = "lims_{$tenant->id}";
        DB::purge('tenant');
        Config::set('database.connections.tenant.database', $db);
        DB::reconnect('tenant');
        (new Tenant())->setConnection('tenant')->where('id', $tenant->id)->update([
            'name'                          => $request->name ?? 0,
            'tenant_id'                     => $request->tenant_id ?? 0,
            'domain'                        => $request->tenant_id . '.' . $request->getHost(), 
            'tenant_delete_days'            => $request->tenant_delete_days ,
        ]);
        return redirect()->route('admin.tenant_management')->with("success", translate('updated_successfully'));
    }

    public function registerPage($id)
    {
        $schema = Schema::findOrFail($id);
        return view("admin.tenant.register", compact("schema"));
    }


    
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Section;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('show_admin_roles');

        $roles = Role::with('users')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        $data = [
            'roles' => $roles,
        ];

        return view('tenant.roles.lists', $data);
    }

    public function create()
    {
        $this->authorize('create_admin_roles');

        $sections = Section::whereNull('section_group_id')
            ->with('children')
            ->get();

        $data = [
            'pageTitle' => trans('admin/main.role_new_page_title'),
            'sections' => $sections
        ];

        return view('tenant.roles.create', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('create_admin_roles');

        $request->validate([
            'name' => 'required|min:3|max:64|unique:roles,name',
            'caption' => 'required|min:3|max:64|unique:roles,caption',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();

            $role = Role::create([
                'name' => $data['name'],
                'caption' => $data['caption'],
                'is_admin' => (!empty($data['is_admin']) and $data['is_admin'] == 'on'),
                'created_at' => time(),
            ]);

            if ($request->has('permissions')) {
                $this->storePermission($role, $data['permissions']);
            }

            Cache::forget('sections');
            DB::commit();

            return redirect()->route('roles')->with('success', "Created Successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating role: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Something went wrong')->withInput();
        }
    }

    public function edit($id)
    {
        $this->authorize('edit_admin_roles');

        try {
            $role = Role::find($id);
            if (!$role) {
                return back()->with('error', 'Role not found');
            }

            $permissions = Permission::where('role_id', '=', $role->id)->get();
            $sections = Section::whereNull('section_group_id')
                ->with('children')
                ->get();

            $data = [
                'role' => $role,
                'sections' => $sections,
                'permissions' => $permissions->keyBy('section_id')
            ];

            return view('tenant.roles.edit', $data);
        } catch (\Exception $e) {
            Log::error('Error loading role edit: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update_admin_roles');

        $role = Role::find($id);
        if (!$role) {
            return back()->with('error', 'Role not found');
        }

        $request->validate([
            'caption' => 'required|min:3|max:64|unique:roles,caption,' . $id . ',id',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();

            $role->update([
                'caption' => $data['caption'],
                'is_admin' => ((!empty($data['is_admin']) and $data['is_admin'] == 'on') or $role->name == Role::$admin),
            ]);

            Permission::where('role_id', '=', $role->id)->delete();

            if (!empty($data['permissions'])) {
                $this->storePermission($role, $data['permissions']);
            }

            Cache::forget('sections');
            DB::commit();

            return redirect()->route('roles')->with('success', "Updated Successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating role: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id' => $id
            ]);
            return back()->with('error', 'Something went wrong')->withInput();
        }
    }

    public function destroy(Request $request)
    {
        $this->authorize('delete_admin_roles');

        DB::beginTransaction();
        try {
            $role = Role::find($request->id);
            if (!$role) {
                DB::rollBack();
                return back()->with('error', 'Role not found');
            }

            if ($role->id !== 2) {
                Permission::where('role_id', '=', $role->id)->delete();
                $role->delete();
            } else {
                DB::rollBack();
                return back()->with('error', 'Cannot delete admin role');
            }

            Cache::forget('sections');
            DB::commit();

            return redirect()->back()->with('success', "Deleted Successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting role: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id' => $request->id
            ]);
            return back()->with('error', 'Something went wrong');
        }
    }

    public function storePermission($role, $sections)
    {
        $sectionsId = Section::whereIn('id', $sections)->pluck('id');
        $permissions = [];
        foreach ($sectionsId as $section_id) {
            $permissions[] = [
                'role_id' => $role->id,
                'section_id' => $section_id,
                'allow' => true,
            ];
        }
        Permission::insert($permissions);
    }
}

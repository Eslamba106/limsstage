<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Schema;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant_counts = Tenant::count();
        $schemas_count = Schema::count();
        $users_count = User::count();
        $last_tenants = Tenant::latest()->take(5)->get();
        $data = [
            'tenant_counts' => $tenant_counts,
            'schemas_count' => $schemas_count,
            'users_count' => $users_count,
            'last_tenants' => $last_tenants,
            'page_title' => 'Dashboard',
        ];

        return view('admin.dashboard.index', $data);
    }
}

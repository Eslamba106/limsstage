<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Schema;
use App\Models\Tenant;
use App\Models\Payment;
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
        // $schemas = Schema::latest()->take(5)->get();
        $schemas = Schema::withCount('tenants')->latest()->get();
        $amounts = Payment::sum('amount');
        $paymentsByMonth = Payment::selectRaw('
        MONTH(payment_date) as month,
        SUM(amount) as total
    ')
            ->whereYear('payment_date', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = $paymentsByMonth->pluck('month')->map(function ($m) {
            return Carbon::create()->month($m)->format('M');
        });

        $totals = $paymentsByMonth->pluck('total');
        $tenantsByMonth = Tenant::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month');
        $activeTenants  = Tenant::where('expire', '>', now())->count();
        $expiredTenants = Tenant::where('expire', '<=', now())->count();
        $tenants = Tenant::select('name', 'expire')
            ->orderBy('name')
            ->get();

        $tenantNames = $tenants->pluck('name');

        $tenantStatus = $tenants->map(function ($tenant) {
            return $tenant->expire > now() ? 1 : 0;
        });

        $tenantColors = $tenants->map(function ($tenant) {
            return $tenant->expire > now() ? '#27ae60' : '#c0392b';
        });
        $schemaNames = $schemas->pluck('name');
        $tenantsCounts = $schemas->pluck('tenants_count');
        $payments = Payment::orderBy("created_at", "desc")->with('tenant:id,name')->latest()->take(5)->get();

        $data = [
            'tenant_counts' => $tenant_counts,
            'payments'          => $payments,
            'amounts'    => $amounts,
            'schemas_count' => $schemas_count,
            'users_count' => $users_count,
            'last_tenants' => $last_tenants,
            'page_title' => 'Dashboard',
            'tenantsByMonth' => $tenantsByMonth,
            'activeTenants' => $activeTenants,
            'expiredTenants' => $expiredTenants,
            'tenantNames' => $tenantNames,
            'tenantStatus' => $tenantStatus,
            'tenantColors' => $tenantColors,
            'schemas'       => $schemas,
            'schemaNames'   => $schemaNames,
            'tenantsCounts'  => $tenantsCounts,
            'months' => $months,
            'totals' => $totals,
            'PaymentsByMonth' => $paymentsByMonth,
        ];

        return view('admin.dashboard.index', $data);
    }
}

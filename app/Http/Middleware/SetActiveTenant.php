<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Services\CurrentTenant;

class SetActiveTenant
{
    /**
     * Handle an incoming request.
     * App\Http\Middleware\SetActiveTenant.php
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host       = $request->getHost();
        if ($host === 'localhost' || str_ends_with($host, '.localhost')) {
            $mainDomain = 'localhost';
        } elseif ($host == 'limsstage.com' || str_ends_with($host, '.limsstage.com')) {
            $mainDomain = 'limsstage.com';
        }

        // dd($host, $mainDomain);
        if ($host != $mainDomain) {
            if($host == ('admin.'.$mainDomain )) { 
                Config::set('database.connections.mysql.database', 'lims');
                DB::purge('mysql');
                DB::reconnect('mysql');
                DB::setDefaultConnection('mysql');
                return $next($request);
            }
            if (!session()->has('tenant_id')) {
                $tenant = Tenant::where('domain', $host)->first();

                if ($tenant) {
                    session(['tenant_id' => $tenant->id]);
                    $db = $tenant->database_options['dbname'] ?? 'lims_' . $tenant->id;
                    Config::set('database.connections.tenant.database', $db);
                    DB::purge('tenant');
                    DB::reconnect('tenant');
                    DB::setDefaultConnection('tenant');
                    app()->instance('current_tenant', $tenant);
                } else {
                    return abort(404);
                }
            } else {
                $tenant = Tenant::find(session('tenant_id'));
//                app()->instance('current_tenant', $tenant);
//app()->instance(CurrentTenant::class, new CurrentTenant($tenant));
            }
        } else {
            Config::set('database.connections.mysql.database', 'lims');
            DB::purge('mysql');
            DB::reconnect('mysql');
            DB::setDefaultConnection('mysql');
        }

        // $mainDomain = 'limsstage.com';

        // $tenant = Tenant::active()->where('domain', $request->getHost())->first();
        // if ($tenant) {
        //     $db = $tenant->database_options['dbname'] ?? 'lims_' . $tenant->id;
        //     Config::set('database.connections.tenant.database', $db);
        //     DB::purge('tenant');
        //     DB::reconnect('tenant');
        //     DB::setDefaultConnection('tenant');

        //     app()->instance('current_tenant', $tenant);
        // }
        return $next($request);
    }
}

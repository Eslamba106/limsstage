<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $mainDomain = null;

        if ($host === 'localhost' || str_ends_with($host, '.localhost')) {
            $mainDomain = 'localhost';
        } elseif ($host == 'limsstage.com' || str_ends_with($host, '.limsstage.com')) {
            $mainDomain = 'limsstage.com';
        }

        // If no main domain matched, default to localhost for development
        if ($mainDomain === null) {
            $mainDomain = 'localhost';
        }

        // dd($host, $mainDomain);
        if ($host != $mainDomain) {
            if ($host == ('admin.' . $mainDomain)) {
                Config::set('database.connections.mysql.database', 'lims');
                DB::purge('mysql');
                DB::reconnect('mysql');
                DB::setDefaultConnection('mysql');
                return $next($request);
            }
            if (!session()->has('tenant_id')) {
                try {
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
                } catch (\Exception $e) {
                    // If database query fails, fall back to main database
                    Config::set('database.connections.mysql.database', 'lims');
                    DB::purge('mysql');
                    DB::reconnect('mysql');
                    DB::setDefaultConnection('mysql');
                }
            } else {
                try {
                    $tenant = Tenant::find(session('tenant_id'));
                    if ($tenant) {
                        $db = $tenant->database_options['dbname'] ?? 'lims_' . $tenant->id;
                        Config::set('database.connections.tenant.database', $db);
                        DB::purge('tenant');
                        DB::reconnect('tenant');
                        DB::setDefaultConnection('tenant');
                        app()->instance('current_tenant', $tenant);
                    }
                } catch (\Exception $e) {
                    // If database query fails, continue with default connection
                    Log::error('Error setting tenant in session: ' . $e->getMessage());
                }
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

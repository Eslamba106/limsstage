<?php

namespace App\Listeners;

use DirectoryIterator;
use App\Events\CompanyCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class CreateCompanyDatabase
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
    public function handle(CompanyCreated $event): void
    {
        $tenant = $event->tenant;
        $db = "lims_{$tenant->id}";
        $tenant->database_options = [
            'dbname'        => $db,
        ];
        $tenant->save();

        DB::statement("CREATE DATABASE `{$db}`");

        Config::set('database.connections.tenant.database', $db);
        // Log::info('Tenant database created: ' . $db);
        $dir = new DirectoryIterator(database_path('migrations/tenants'));
        foreach ($dir as $file) {
            if ($file->isFile()) {
                Artisan::call('migrate', [
                    '--database'        => 'tenant',
                    '--path'  =>  'database/migrations/tenants/' . $file->getFilename(),
                    '--force'   => true,
                ]);
            };
        }

        $this->copyDataToTenantDB($db, $tenant);
    }


    private function copyDataToTenantDB(string $db, $tenant)
    {
        DB::purge('tenant');
        Config::set('database.connections.tenant.database', $db);
        DB::reconnect('tenant');
        $tablesToCopy = ['roles', 'sections', 'permissions','business_settings'];
        foreach ($tablesToCopy as $table) {
            $data = DB::table($table)->get();
            if ($data->isNotEmpty()) {
                DB::connection('tenant')->table($table)->insert($data->map(function ($row) {
                    return (array) $row;
                })->toArray());
            }
        }
        $latestUser = DB::table('users')->orderBy('id', 'desc')->first();

        if ($latestUser) {
            DB::connection("tenant")->table('users')->insert((array) $latestUser);
        }

        $latestCompany = DB::table('tenants')->orderBy('id', 'desc')->first();
        if ($latestCompany) {
              $companyArray = (array) $latestCompany;
 
    $columnsToIgnore = ['expire'];  
    foreach ($columnsToIgnore as $col) {
        unset($companyArray[$col]);
    }

    DB::connection("tenant")->table('tenants')->insert($companyArray);
            
            // DB::connection("tenant")->table('tenants')->insert((array) $latestCompany);
        }
    
    }
}

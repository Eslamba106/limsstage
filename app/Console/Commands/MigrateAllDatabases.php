<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class MigrateAllDatabases extends Command
{
    protected $signature = 'migrate:all';
    protected $description = 'Run migrations for both main and tenant databases';

    public function handle()
    {
        // 1. Main DB - default path
        // $this->info("Migrating main database...");
        // Artisan::call('migrate', [
        //     '--database' => 'mysql',  
        //     '--path' => 'database/migrations',
        //     '--force' => true,
        // ]);
        // $this->info(Artisan::output());
        $tenants =(new Tenant())->setConnection('mysql')->all(); 

        foreach ($tenants as $tenant) {
            $dbOptions = json_decode($tenant->database_options, true);
        
            if (!$dbOptions || !isset($dbOptions['dbname'])) {
                $this->error("Invalid database options for tenant ID: " . $tenant->id);
                continue;
            }
        
            $this->info("Migrating database for tenant: " . $dbOptions['dbname']);
        
            Config::set('database.connections.tenant.database', $dbOptions['dbname']);
            DB::purge('tenant');
            DB::reconnect('tenant');
        
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path'     => 'database/migrations/tenants',
                '--force' => true,
            ]);
        
            $this->info("Migrated database for tenant: " . $dbOptions['dbname']);
        }
        
        // 2. Tenant DB - custom path
        // $this->info("Migrating tenant database...");
        // Artisan::call('migrate', [
        //     '--database' => 'finexerp_95',  
        //     '--path' => 'database/migrations/tenant',
        //     '--force' => true,
        // ]);
        // $this->info(Artisan::output());

        $this->info('✅ All migrations done!');
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class SeedAllDatabases extends Command
{
    protected $signature = 'db:seed:all';
    protected $description = 'Seed all tenant databases';

    public function handle()
    {
        $tenants = (new Tenant())->setConnection('mysql')->pluck('database_options');

        foreach ($tenants as $tenantJson) {
            $tenantOptions = json_decode($tenantJson, true);
            $dbname = $tenantOptions['dbname'] ?? null;

            if (!$dbname) {
                $this->warn("⛔ Skipping tenant due to missing dbname.");
                continue;
            }

            config(['database.connections.tenant.database' => $dbname]);
            DB::purge('tenant');
            DB::reconnect('tenant');

            $this->info("🔄 Seeding database for tenant: $dbname");
            Artisan::call('db:seed', [
                '--database' => 'tenant',
                '--force' => true,
            ]);
            $this->info(Artisan::output());
        }

        $this->info('✅ All seeding done!');
    }
}

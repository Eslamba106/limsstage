<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class MigrateCoaTemplatePlants extends Command
{
    protected $signature = 'migrate:coa-template-plants';
    protected $description = 'Run coa_template_plants migration for all tenant databases';

    public function handle()
    {
        $tenants = (new Tenant())->setConnection('mysql')->all(); 

        foreach ($tenants as $tenant) {
            $dbOptions = json_decode($tenant->database_options, true);
        
            if (!$dbOptions || !isset($dbOptions['dbname'])) {
                $this->error("Invalid database options for tenant ID: " . $tenant->id);
                continue;
            }
        
            $this->info("Migrating coa_template_plants for tenant: " . $dbOptions['dbname']);
        
            Config::set('database.connections.tenant.database', $dbOptions['dbname']);
            DB::purge('tenant');
            
            // Check if database exists first
            try {
                DB::reconnect('tenant');
            } catch (\Exception $e) {
                $this->warn("⚠️  Database " . $dbOptions['dbname'] . " does not exist, skipping...");
                continue;
            }
        
            // Check if table exists
            try {
                if (Schema::connection('tenant')->hasTable('coa_template_plants')) {
                    $this->info("✓ Table coa_template_plants already exists for tenant: " . $dbOptions['dbname']);
                    continue;
                }
            } catch (\Exception $e) {
                $this->warn("⚠️  Could not check table for tenant " . $dbOptions['dbname'] . ": " . $e->getMessage());
                continue;
            }
        
            // Create table manually
            try {
                DB::connection('tenant')->statement("
                    CREATE TABLE IF NOT EXISTS `coa_template_plants` (
                        `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                        `coa_temp_id` int(11) NOT NULL,
                        `plant_id` int(11) NOT NULL,
                        `is_default` tinyint(1) NOT NULL DEFAULT '1',
                        `created_at` timestamp NULL DEFAULT NULL,
                        `updated_at` timestamp NULL DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `coa_template_plants_unique` (`coa_temp_id`,`plant_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
                
                $this->info("✅ Created coa_template_plants table for tenant: " . $dbOptions['dbname']);
            } catch (\Exception $e) {
                $this->error("❌ Error creating table for tenant " . $dbOptions['dbname'] . ": " . $e->getMessage());
            }
        }
        
        $this->info('✅ All coa_template_plants migrations done!');
    }
}

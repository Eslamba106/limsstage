<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class RollbackLastTenantTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:rollback-last';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback the last migration (table) for all tenant databases';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tenantConnections = $this->getTenantDatabaseConnections();

        if (empty($tenantConnections)) {
            $this->info('No tenant database connections found.');
            return 0;
        }

        foreach ($tenantConnections as $connectionName) {
            $this->info("Rolling back last migration for connection: {$connectionName}");
            try {
                DB::connection($connectionName)->transaction(function () use ($connectionName) {
                    $migration = $this->getLastMigration($connectionName);

                    if ($migration) {
                        $this->call('migrate:rollback', [
                            '--database' => $connectionName,
                            '--path' => database_path('migrations'), // تأكد من تعديل هذا المسار إذا كانت ملفات الترحيل في مكان آخر
                            '--step' => 1, // للتراجع عن آخر دفعة فقط
                        ]);

                        // بعد التراجع عن الدفعة، قد تحتاج إلى ترحيل الدفعة السابقة إذا كنت تريد الحفاظ على الجداول الأخرى
                        // يمكنك إضافة منطق هنا إذا لزم الأمر، ولكن كن حذرًا فقد يؤدي ذلك إلى تعقيد العملية.
                    } else {
                        $this->info("No migrations found for connection: {$connectionName}");
                    }
                });
                $this->info("Last migration rolled back successfully for connection: {$connectionName}");
            } catch (\Exception $e) {
                $this->error("Error rolling back last migration for connection {$connectionName}: {$e->getMessage()}");
            }
        }

        $this->info('Finished rolling back the last migration for all tenants.');
        return 0;
    }

    /**
     * Get the list of tenant database connection names.
     *
     * This method needs to be adapted based on how you manage your tenant connections.
     *
     * @return array
     */
    protected function getTenantDatabaseConnections()
    {
        // **تعديل هنا حسب طريقة إدارة اتصالات قواعد بيانات المستأجرين لديك**
        return Config::get('database.connections.tenant', []);
    }

    /**
     * Get the last migration file name for a given connection.
     *
     * @param string $connectionName
     * @return string|null
     */
    protected function getLastMigration($connectionName)
    {
        if (!Schema::connection($connectionName)->hasTable('migrations')) {
            return null;
        }

        $lastMigration = DB::connection($connectionName)
            ->table('migrations')
            ->orderBy('batch', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        return $lastMigration ? $lastMigration->migration : null;
    }
}
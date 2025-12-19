<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Carbon\Carbon;

class DeactivateExpiredTenants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deactivate-expired-tenants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */


    public function handle()
    {
        Tenant::whereDate('expire', Carbon::today())
            ->where('status', '!=', 'inactive')
            ->update([
                'status' => 'inactive'
            ]);

        $this->info('Expired tenants deactivated successfully.');
    }
}

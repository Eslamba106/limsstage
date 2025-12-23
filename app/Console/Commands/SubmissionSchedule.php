<?php
namespace App\Console\Commands;

use App\Models\second_part\Frequency;
use App\Models\second_part\SampleRoutineSchedulerItem;
use App\Models\second_part\Submission;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubmissionSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:submission-schedule';

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
        $tenants = Tenant::select('database_options', 'id', 'domain')->get();
        $currentHour = Carbon::now()->format('H');
        $now = Carbon::now();

        foreach ($tenants as $tenant) { 
            $db = $tenant->database_options['dbname'] ?? 'lims_' . $tenant->id;
            Config::set('database.connections.tenant.database', $db);
            DB::purge('tenant');
            DB::reconnect('tenant');
            DB::setDefaultConnection('tenant');

            $connection = DB::connection(); 

            $items = DB::table('sample_routine_scheduler_items as item')
                ->join('sample_routine_schedulers as sched', 'item.sample_scheduler_id', '=', 'sched.id')
                ->select('item.*', 'sched.plant_id' , 'sched.sub_plant_id', 'sched.sample_id', 'sched.sample_id')
                ->whereTime('item.schedule_hour', '>=', $now->copy()->startOfHour())
                ->whereTime('item.schedule_hour', '<=', $now->copy()->endOfHour())
                ->get();

            Log::info("⏰ Found {$items->count()} items scheduled for hour {$currentHour}");

         foreach ($items as $item) {
    $frequency = Frequency::select('id', 'time_by_hours')->where('id', $item->frequency_id)->first();
    $intervalHours = $frequency ? $frequency->time_by_hours : 24;  
 
    $samplingDateTime = Carbon::today()->setTimeFromTimeString($item->schedule_hour);

    while ($samplingDateTime->isToday()) {  
        $exists = DB::table('submissions')
            ->where('plant_id', $item->plant_id)
            ->whereDate('sampling_date_and_time', $samplingDateTime->toDateString())
            ->whereTime('sampling_date_and_time', $samplingDateTime->format('H:i:s'))
            ->exists();

        if (!$exists) {
            DB::beginTransaction();
            try {
                $submissionId = DB::table('submissions')->insertGetId([
                    'plant_id'               => $item->plant_id,
                    'sub_plant_id'           => $item->sub_plant_id,
                    'plant_sample_id'        => $item->sample_id,
                    'sample_id'              => $item->sample_id,
                    'priority'               => 'normal',
                    'sampling_date_and_time' => $samplingDateTime,
                    'comment'                => '',
                    'created_at'             => now(),
                    'updated_at'             => now(),
                ]);

                $submissionNumber = 'SCH-' . str_pad($submissionId, 6, '0', STR_PAD_LEFT);
                DB::table('submissions')->where('id', $submissionId)->update(['submission_number' => $submissionNumber]);

                // ربط العنصر بالـ submission
                DB::table('submission_items')->insert([
                    'sample_test_method_item_id' => $item->id,
                    'submission_id'              => $submissionId,
                    'created_at'                 => now(),
                    'updated_at'                 => now(),
                ]);

                DB::commit();
                Log::info("✅ Created submission {$submissionNumber} for item {$item->id} (tenant {$tenant->domain}) at {$samplingDateTime}");
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("❌ Failed to create submission for item {$item->id} (tenant {$tenant->domain}): " . $e->getMessage());
            }
        } else {
            Log::info("⏭️ Submission already exists for item {$item->id} at {$samplingDateTime}");
        }

        // نضيف فترة التكرار للوقت الحالي
        $samplingDateTime->addHours($intervalHours);
    }
}


            Log::info("✅ Finished processing tenant {$tenant->domain}");
        }

        Log::info("✅ Cron job completed for all tenants at hour {$currentHour}");
 

    }
}

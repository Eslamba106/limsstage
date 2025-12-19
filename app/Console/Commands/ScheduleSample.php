<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\second_part\Submission;
use App\Models\second_part\SampleRoutineScheduler;

class ScheduleSample extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:schedule-sample';

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
        $sample_routine_schedulers = SampleRoutineScheduler::get();

        foreach ($sample_routine_schedulers as $sample_routine_scheduler_master) {
            $submission = Submission::create([
                'plant_id'               => $sample_routine_scheduler_master->plant_id,
                'sub_plant_id'           => $sample_routine_scheduler_master->sub_plant_id,
                'plant_sample_id'        => $sample_routine_scheduler_master->plant_sample_id,
                'sample_id'              => $sample_routine_scheduler_master->sample_id,
                'priority'               => $sample_routine_scheduler_master->priority ?? 'normal',
                'sampling_date_and_time' => today(),
                'comment'                => $sample_routine_scheduler_master->comment,
            ]);
            $submission->submission_number = 'SCH-' . str_pad($submission->id, 6, '0', STR_PAD_LEFT);
            $submission->save();
            foreach ($sample_routine_scheduler_master->sample_routine_scheduler_items as $key => $sample_test_method_item_main) {
            // dd($sample_test_method_item);
            DB::table('submission_items')->insert([
                'sample_test_method_item_id' => $sample_test_method_item_main,
                'submission_id'              => $submission->id,
            ]);
        }
        }
    }
}

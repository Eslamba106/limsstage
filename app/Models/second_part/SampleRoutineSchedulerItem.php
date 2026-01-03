<?php
namespace App\Models\second_part;

use App\Models\Plant;
use App\Models\Sample;
use App\Models\Tenant;
use App\Models\first_part\TestMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SampleRoutineSchedulerItem extends Model
{
    use HasFactory;
    protected $guarded    = ['id'];
    protected $connection = 'tenant';

   
    use Prunable;
   public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    } 
    public function sample_routine_scheduler()
    {
        return $this->belongsTo(SampleRoutineScheduler::class, 'sample_scheduler_id', 'id');
    }
    public function sample()
    {
        return $this->belongsTo(Sample::class, 'sample_id', 'id');
    }
    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_id', 'id');
    }
    public function sub_plant()
    {
        return $this->belongsTo(Plant::class, 'sub_plant_id', 'id');
    }

    public function test_method()
    {
        return $this->belongsTo(TestMethod::class, 'test_method_ids');
    }
}

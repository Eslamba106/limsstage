<?php

namespace App\Models;

use App\Models\Tenant;
use App\Models\second_part\Submission;
use App\Models\part_three\Result;
use App\Models\second_part\SampleRoutineScheduler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
class Sample extends Model
{
    use HasFactory;
//    
    use Prunable;
   public function prunable()
    {
        $days = Tenant::first()?->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }     protected $guarded = ['id'];
    public function sample_plant()
    {
        return $this->belongsTo(SamplePlant::class, 'plant_sample_id', 'id');
    }
    // public function sample_plant()
    // {
    //     return $this->hasOne(SamplePlant::class ,'id', 'plant_sample_id');
    // }
    public function plant_main()
    {
        return $this->belongsTo(Plant::class, 'plant_id', 'id');
    }
    public function sub_plant ()
    {
        return $this->hasOne(Plant::class ,'id', 'sub_plant_id');
    }
    public function test_methods()
    {
        return $this->hasMany(SampleTestMethod::class ,'sample_id', 'id');
    }
    
    /**
     * Get submissions that use this sample
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'sample_id', 'id');
    }
    
    /**
     * Get results that use this sample
     */
    public function results()
    {
        return $this->hasMany(Result::class, 'sample_id', 'id');
    }
    
    /**
     * Get routine schedulers that use this sample
     */
    public function routine_schedulers()
    {
        return $this->hasMany(SampleRoutineScheduler::class, 'sample_id', 'id');
    }
    
    /**
     * Check if this sample is being used in operational data
     * Note: Test methods association doesn't prevent deletion
     */
    public function isInUse(): bool
    {
        return $this->submissions()->exists() 
            || $this->results()->exists() 
            || $this->routine_schedulers()->exists();
    }
    
    /**
     * Get usage count and details (excluding test methods)
     */
    public function getUsageDetails(): array
    {
        return [
            'submissions' => $this->submissions()->count(),
            'results' => $this->results()->count(),
            'schedulers' => $this->routine_schedulers()->count(),
            'total' => $this->submissions()->count() 
                + $this->results()->count() 
                + $this->routine_schedulers()->count(),
        ];
    }
}

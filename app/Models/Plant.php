<?php

namespace App\Models;

use App\Models\Tenant;
use App\Models\Sample;
use App\Models\second_part\Submission;
use App\Models\part_three\Result;
use App\Models\second_part\SampleRoutineScheduler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
class Plant extends Model
{
    use HasFactory;
   
    use Prunable;
   public function prunable()
    {
        $days = Tenant::first()?->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    } 
    protected $guarded = ['id'];

    public function sub_plants()
    {
        return $this->hasMany(Plant::class, 'plant_id');
    }
    public function mainPlant()
    {
        return $this->belongsTo(Plant::class, 'plant_id');
    }
    public function samplePlants()
    {
        return $this->hasMany(SamplePlant::class, 'plant_id');
    }
    
    /**
     * Get samples that use this plant as main plant
     */
    public function samples_as_main()
    {
        return $this->hasMany(Sample::class, 'plant_id', 'id');
    }
    
    /**
     * Get samples that use this plant as sub-plant
     */
    public function samples_as_sub()
    {
        return $this->hasMany(Sample::class, 'sub_plant_id', 'id');
    }
    
    /**
     * Get submissions that use this plant
     */
    public function submissions_as_main()
    {
        return $this->hasMany(Submission::class, 'plant_id', 'id');
    }
    
    /**
     * Get submissions that use this plant as sub-plant
     */
    public function submissions_as_sub()
    {
        return $this->hasMany(Submission::class, 'sub_plant_id', 'id');
    }
    
    /**
     * Get results that use this plant
     */
    public function results_as_main()
    {
        return $this->hasMany(Result::class, 'plant_id', 'id');
    }
    
    /**
     * Get results that use this plant as sub-plant
     */
    public function results_as_sub()
    {
        return $this->hasMany(Result::class, 'sub_plant_id', 'id');
    }
    
    /**
     * Get routine schedulers that use this plant
     */
    public function routine_schedulers_as_main()
    {
        return $this->hasMany(SampleRoutineScheduler::class, 'plant_id', 'id');
    }
    
    /**
     * Get routine schedulers that use this plant as sub-plant
     */
    public function routine_schedulers_as_sub()
    {
        return $this->hasMany(SampleRoutineScheduler::class, 'sub_plant_id', 'id');
    }
    
    /**
     * Check if this plant is being used anywhere
     */
    public function isInUse(): bool
    {
        return $this->samples_as_main()->exists() 
            || $this->samples_as_sub()->exists()
            || $this->submissions_as_main()->exists()
            || $this->submissions_as_sub()->exists()
            || $this->results_as_main()->exists()
            || $this->results_as_sub()->exists()
            || $this->routine_schedulers_as_main()->exists()
            || $this->routine_schedulers_as_sub()->exists()
            || $this->samplePlants()->exists()
            || $this->sub_plants()->exists();
    }
    
    /**
     * Get usage count and details
     */
    public function getUsageDetails(): array
    {
        return [
            'samples_main' => $this->samples_as_main()->count(),
            'samples_sub' => $this->samples_as_sub()->count(),
            'submissions_main' => $this->submissions_as_main()->count(),
            'submissions_sub' => $this->submissions_as_sub()->count(),
            'results_main' => $this->results_as_main()->count(),
            'results_sub' => $this->results_as_sub()->count(),
            'schedulers_main' => $this->routine_schedulers_as_main()->count(),
            'schedulers_sub' => $this->routine_schedulers_as_sub()->count(),
            'sample_plants' => $this->samplePlants()->count(),
            'sub_plants' => $this->sub_plants()->count(),
            'total' => $this->samples_as_main()->count() 
                + $this->samples_as_sub()->count()
                + $this->submissions_as_main()->count()
                + $this->submissions_as_sub()->count()
                + $this->results_as_main()->count()
                + $this->results_as_sub()->count()
                + $this->routine_schedulers_as_main()->count()
                + $this->routine_schedulers_as_sub()->count()
                + $this->samplePlants()->count()
                + $this->sub_plants()->count(),
        ];
    }
}

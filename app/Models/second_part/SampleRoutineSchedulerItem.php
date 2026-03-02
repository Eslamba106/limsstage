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
        $days = Tenant::first()?->tenant_delete_days ?? 30;

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
    
    /**
     * Get sample test method item through sample and test method.
     */
    public function getSampleTestMethodItemAttribute()
    {
        if (!$this->sample_id || !$this->test_method_ids) {
            return null;
        }
        
        // Find SampleTestMethod for this sample and test method
        $sampleTestMethod = \App\Models\SampleTestMethod::where('sample_id', $this->sample_id)
            ->where('test_method_id', $this->test_method_ids)
            ->first();
            
        if (!$sampleTestMethod) {
            return null;
        }
        
        // Return first sample test method item (or we can return all items)
        return $sampleTestMethod->sample_test_method_items->first();
    }
    
    /**
     * Get all sample test method items for this scheduler item.
     */
    public function getSampleTestMethodItemsAttribute()
    {
        if (!$this->sample_id || !$this->test_method_ids) {
            return collect([]);
        }
        
        // Find SampleTestMethod for this sample and test method
        $sampleTestMethod = \App\Models\SampleTestMethod::where('sample_id', $this->sample_id)
            ->where('test_method_id', $this->test_method_ids)
            ->first();
            
        if (!$sampleTestMethod) {
            return collect([]);
        }
        
        return $sampleTestMethod->sample_test_method_items;
    }
    
    public function result()
    {
        // Relationship to ResultTestMethodItem through submission_item field
        return $this->hasOne(\App\Models\part_three\ResultTestMethodItem::class, 'submission_item', 'id');
    }
}

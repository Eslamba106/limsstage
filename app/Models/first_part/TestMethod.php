<?php

namespace App\Models\first_part;

use App\Models\Tenant;
use App\Models\SampleTestMethod;
use App\Models\second_part\SampleRoutineSchedulerItem;
use App\Models\part_three\ResultTestMethod;
use Illuminate\Database\Eloquent\Model;
use App\Models\first_part\TestMethodItem;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestMethod extends Model
{
    use HasFactory;
        use Prunable;
    public function prunable()
    {
        $days = Tenant::first()?->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }
    protected $guarded = ['id'];
  //  protected $connection ='tenant';
    public function test_method_items(){
        return $this->hasMany(TestMethodItem::class, 'test_method_id', 'id');
    }
    public function test_method_items_count(){
        return $this->hasMany(TestMethodItem::class, 'test_method_id', 'id')->count();
    }
    
    /**
     * Get sample test methods that use this test method
     */
    public function sample_test_methods()
    {
        return $this->hasMany(SampleTestMethod::class, 'test_method_id', 'id');
    }
    
    /**
     * Get routine scheduler items that use this test method
     */
    public function routine_scheduler_items()
    {
        return $this->hasMany(SampleRoutineSchedulerItem::class, 'test_method_ids', 'id');
    }
    
    /**
     * Get result test methods that use this test method
     */
    public function result_test_methods()
    {
        return $this->hasMany(ResultTestMethod::class, 'test_method_id', 'id');
    }
    
    /**
     * Check if this test method is being used anywhere
     */
    public function isInUse(): bool
    {
        return $this->sample_test_methods()->exists() 
            || $this->routine_scheduler_items()->exists() 
            || $this->result_test_methods()->exists();
    }
    
    /**
     * Get usage count and details
     */
    public function getUsageDetails(): array
    {
        return [
            'samples' => $this->sample_test_methods()->count(),
            'schedulers' => $this->routine_scheduler_items()->count(),
            'results' => $this->result_test_methods()->count(),
            'total' => $this->sample_test_methods()->count() 
                + $this->routine_scheduler_items()->count() 
                + $this->result_test_methods()->count(),
        ];
    }
}

<?php

namespace App\Models;

use App\Models\Tenant;
use App\Models\SampleTestMethod;
use App\Models\part_three\ResultItem;
use Illuminate\Database\Eloquent\Model;
use App\Models\first_part\TestMethodItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
class SampleTestMethodItem extends Model
{
    use HasFactory;

   use SoftDeletes;
    use Prunable;
   public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }   protected $guarded = ['id'];
    public function sample_test_method()
    {
        return $this->belongsTo(SampleTestMethod::class, 'sample_test_method_id');
    }
    public function test_method_item(){
        return $this->belongsTo(TestMethodItem::class, 'test_method_item_id');
    }

    // public function results_for_item(){
    //     return $this->hasMany(ResultItem::class , '');
    // }
}

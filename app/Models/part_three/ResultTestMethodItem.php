<?php

namespace App\Models\part_three;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use App\Models\first_part\TestMethodItem;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResultTestMethodItem extends Model
{
    use HasFactory;

    use Prunable;
    public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }    protected $guarded =[];
    

    public function main_result(){
        return $this->belongsTo(Result::class, 'result_id');
    }
    public function main_result_test_method(){
        return $this->belongsTo(ResultTestMethod::class, 'result_test_method_id');
    }
    public function main_test_method_item(){
        return $this->belongsTo(TestMethodItem::class, 'test_method_item_id');
    }

}

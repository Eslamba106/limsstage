<?php

namespace App\Models\part_three;

use App\Models\Tenant;
use App\Models\first_part\TestMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResultTestMethod extends Model
{
    use HasFactory;
        use Prunable;
    public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }
    protected $guarded = ['id'];
    public function result()
    {
        return $this->belongsTo(Result::class, 'result_id');
    }
    public function test_method(){
        return $this->belongsTo(TestMethod::class, 'test_method_id');
    }
    public function result_test_method_items()
    {
        return $this->hasMany(ResultTestMethodItem::class, 'result_test_method_id', 'id');
    }
    public function result_test_method_child()
    {
        return $this->hasMany(ResultTestMethodItem::class, 'result_test_method_id', 'id');
    }

  
}

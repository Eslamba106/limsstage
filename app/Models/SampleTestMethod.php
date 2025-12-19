<?php

namespace App\Models;

use App\Models\Tenant;
use App\Models\SampleTestMethodItem;
use App\Models\first_part\TestMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
class SampleTestMethod extends Model
{
    use HasFactory;
    protected $guarded = [];
    use SoftDeletes;
    use Prunable;
    public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }
    public function master_test_method()
    {
        return $this->hasOne(TestMethod::class, 'id', 'test_method_id');
        // return $this->belongsTo(TestMethod::class);
    }
    public function sample_test_method_items()
    {
        return $this->hasMany(SampleTestMethodItem::class, 'test_method_id', 'id');
    }
}

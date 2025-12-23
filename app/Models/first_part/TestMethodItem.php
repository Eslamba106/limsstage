<?php

namespace App\Models\first_part;

use App\Models\Tenant;
use App\Models\part\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestMethodItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // protected $connection = 'tenant';
    use Prunable;
    public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }
    public function test_method()
    {
        return $this->belongsTo(TestMethod::class, 'test_method_id', 'id');
    }
    public function main_unit()
    {
        return $this->belongsTo(Unit::class, 'unit');
    }

}

<?php

namespace App\Models\part;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use App\Models\first_part\TestMethodItem;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
        use Prunable;
    public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }
    // protected $connection = 'tenant';
    public function test_method_items()
    {
        return $this->hasMany(TestMethodItem::class, 'unit', 'id');
    }

}

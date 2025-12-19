<?php

namespace App\Models\first_part;

use App\Models\Tenant;
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
        $days = Tenant::first()->tenant_delete_days ?? 30;

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
}

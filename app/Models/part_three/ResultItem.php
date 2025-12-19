<?php

namespace App\Models\part_three;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResultItem extends Model
{
    use HasFactory;

    use Prunable;
    public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }    protected $guarded = ['id'];
    protected $table = 'result_test_method_items';
    public function result()
    {
        return $this->belongsTo(Result::class, 'result_id');
    }
  
    
}

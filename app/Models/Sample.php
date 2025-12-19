<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
class Sample extends Model
{
    use HasFactory;
   use SoftDeletes;
    use Prunable;
   public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }     protected $guarded = ['id'];
    public function sample_plant()
    {
        return $this->belongsTo(SamplePlant::class, 'plant_sample_id', 'id');
    }
    // public function sample_plant()
    // {
    //     return $this->hasOne(SamplePlant::class ,'id', 'plant_sample_id');
    // }
    public function plant_main()
    {
        return $this->hasOne(Plant::class ,'id', 'plant_id');
    }
    public function sub_plant ()
    {
        return $this->hasOne(Plant::class ,'id', 'sub_plant_id');
    }
    public function test_methods()
    {
        return $this->hasMany(SampleTestMethod::class ,'sample_id', 'id');
    }
}

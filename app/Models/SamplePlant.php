<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
class SamplePlant extends Model
{
    use HasFactory;

   use SoftDeletes;
    use Prunable;
   public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }     protected $guarded = ['id'];
    protected $table = 'plant_samples';
    public function sample()
    {
        return $this->belongsTo(Sample::class, 'plant_sample_id', 'id');
    }
    // public function sample()
    // {
    //     return $this->hasOne(Sample::class, 'plant_sample_id', 'id');
    // }
    public function mainPlant()
    {
        return $this->belongsTo(Plant::class, 'plant_id', 'id');
    }


    protected $appends = ['main_plant_name'];

    public function getMainPlantNameAttribute()
    {
        return $this->mainPlant?->name;
    }
    // protected $appends = ['test_methods'];

    // public function getTestMethodsAttribute()
    // {
    //     return $this->mainPlant?->name;
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
class Plant extends Model
{
    use HasFactory;
   use SoftDeletes;
    use Prunable;
   public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    } 
    protected $guarded = ['id'];

    public function sub_plants()
    {
        return $this->hasMany(Plant::class, 'plant_id');
    }
    public function mainPlant()
    {
        return $this->belongsTo(Plant::class, 'plant_id');
    }
    public function samplePlants()
    {
        return $this->hasMany(SamplePlant::class, 'plant_id');
    }
   


}

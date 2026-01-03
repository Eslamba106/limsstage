<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
class COATemplate extends Model
{
    use HasFactory;

   
    use Prunable;
   public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    } 
    protected $guarded = [];

    public function samples()
    {
        return $this->belongsToMany(Sample::class, 'coa_template_samples', 'coa_temp_id', 'sample_id');
    }
}

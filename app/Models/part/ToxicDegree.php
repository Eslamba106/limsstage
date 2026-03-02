<?php

namespace App\Models\part;

use App\Models\Tenant;
use App\Models\Sample;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToxicDegree extends Model
{
    use HasFactory;
        use Prunable;
    public function prunable()
    {
        $days = Tenant::first()?->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }
    protected $guarded = ['id'];
    
    /**
     * Get samples that use this toxic degree
     */
    public function samples()
    {
        return $this->hasMany(Sample::class, 'toxic', 'id');
    }
    
    /**
     * Check if this toxic degree is being used in any samples
     */
    public function isInUse(): bool
    {
        return $this->samples()->exists();
    }
    
    /**
     * Get usage count
     */
    public function getUsageCount(): int
    {
        return $this->samples()->count();
    }
}

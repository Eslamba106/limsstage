<?php

namespace App\Models\part;

use App\Models\Tenant;
use App\Models\first_part\TestMethodItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResultType extends Model
{
    use HasFactory;
    use Prunable;
    public function prunable()
    {
        $days = Tenant::first()?->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }
    protected $guarded = ['id'];
    
    public function test_method_items()
    {
        return $this->hasMany(TestMethodItem::class, 'result_type', 'id');
    }
    
    /**
     * Check if this result type is being used in any test method items
     */
    public function isInUse(): bool
    {
        return $this->test_method_items()->exists();
    }
}

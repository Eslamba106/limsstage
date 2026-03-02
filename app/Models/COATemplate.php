<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Support\Facades\Schema;

class COATemplate extends Model
{
    use HasFactory;


    use Prunable;
    public function prunable()
    {
        $days = Tenant::first()?->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }
    protected $guarded = [];

    public function samples()
    {
        // Note: Add 'is_active' to withPivot after running migration: 2025_01_15_000001_add_is_active_to_coa_template_samples
        $pivotColumns = [];

        // Check if is_active column exists
        try {
            if (Schema::hasColumn('coa_template_samples', 'is_active')) {
                $pivotColumns[] = 'is_active';
            }
        } catch (\Exception $e) {
            // Column doesn't exist yet, continue without it
        }

        $relation = $this->belongsToMany(Sample::class, 'coa_template_samples', 'coa_temp_id', 'sample_id')
            ->withTimestamps();

        if (!empty($pivotColumns)) {
            $relation->withPivot($pivotColumns);
        }

        return $relation;
    }

    public function plants()
    {
        // Note: Add 'is_active' to withPivot after running migration: 2025_01_15_000002_add_is_active_to_coa_template_plants
        $pivotColumns = ['is_default'];

        // Check if is_active column exists
        try {
            if (Schema::hasColumn('coa_template_plants', 'is_active')) {
                $pivotColumns[] = 'is_active';
            }
        } catch (\Exception $e) {
            // Column doesn't exist yet, continue without it
        }

        $relation = $this->belongsToMany(Plant::class, 'coa_template_plants', 'coa_temp_id', 'plant_id')
            ->withPivot($pivotColumns)
            ->withTimestamps();

        return $relation;
    }

    /**
     * Get COA template for a sample with priority logic:
     * 1. Sample-specific assignment (highest priority)
     * 2. Plant-level default (fallback)
     *
     * @param int $sampleId
     * @param int|null $plantId
     * @return COATemplate|null
     */
    public static function getTemplateForSample(int $sampleId, ?int $plantId = null): ?self
    {
        // First, try to get sample-specific template
        $sampleTemplate = self::whereHas('samples', function ($query) use ($sampleId) {
            $query->where('samples.id', $sampleId);
        })->first();

        if ($sampleTemplate) {
            return $sampleTemplate;
        }

        // If no sample-specific template, try plant-level default
        if ($plantId) {
            $plantTemplate = self::whereHas('plants', function ($query) use ($plantId) {
                $query->where('plants.id', $plantId)
                    ->where('coa_template_plants.is_default', true);
            })->first();

            if ($plantTemplate) {
                return $plantTemplate;
            }
        }

        return null;
    }
}

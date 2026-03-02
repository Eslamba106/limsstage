<?php
namespace App\Models;

use App\Models\second_part\Frequency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;

class ReportGenerationSetting extends Model
{
    use HasFactory;
    use Prunable;
    
    public function prunable()
    {
        $days = Tenant::first()?->tenant_delete_days ?? 30;
        return static::where('created_at', '<=', now()->subDays($days));
    }
    
    protected $guarded = [];

    public function frequency_master()
    {
        return $this->belongsTo(Frequency::class, 'frequency_id');
    }
    
    public function emails()
    {
        return $this->belongsToMany(
            WebEmail::class,
            'report_generation_settings_emails',
            'report_generation_setting_id',
            'email_id'
        )->withTimestamps();
    }
    
    public function samples()
    {
        return $this->belongsToMany(
            Sample::class,
            'report_generation_settings_samples',
            'report_generation_setting_id',
            'sample_id'
        )->withTimestamps();
    }
}

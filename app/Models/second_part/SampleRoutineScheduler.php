<?php
namespace App\Models\second_part;

use App\Models\Plant;
use App\Models\Sample;
use App\Models\Tenant;
use Milon\Barcode\DNS1D;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SampleRoutineScheduler extends Model
{
    use HasFactory;
    protected $guarded    = ['id'];
    protected $connection = 'tenant';

   
    use Prunable;
   public function prunable()
    {
        $days = Tenant::first()?->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    } 
    public function sample()
    {
        return $this->belongsTo(Sample::class, 'sample_id', 'id');
    }
    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_id', 'id');
    }
    public function sub_plant()
    {
        return $this->belongsTo(Plant::class, 'sub_plant_id', 'id');
    }
    public function frequency()
    {
        return $this->belongsTo(Frequency::class, 'frequency_id', 'id');
    }
    public function sample_routine_scheduler_items()
    {
        return $this->hasMany(SampleRoutineSchedulerItem::class, 'sample_scheduler_id', 'id');
    }
    
    /**
     * Get master sample (alias for sample relationship).
     * Used for compatibility with submission structure.
     */
    public function getMasterSampleAttribute()
    {
        return $this->sample;
    }

    /**
     * Get barcode HTML attribute.
     *
     * @return string
     */
    public function getBarcodeAttribute()
    {
        if (!$this->submission_number) {
            return '';
        }
        
        $barcode = new DNS1D();
        $barcode->setStorPath(storage_path('framework/barcodes/'));
        return $barcode->getBarcodeHTML($this->submission_number, 'C39', 1, 40);
    }

    /**
     * Get barcode image attribute.
     *
     * @return string
     */
    public function getBarcodeImageAttribute()
    {
        if (!$this->submission_number) {
            return '';
        }
        
        $barcode = new DNS1D();
        $barcode->setStorPath(storage_path('framework/barcodes/'));

        return '<img src="data:image/png;base64,'
            . $barcode->getBarcodePNG($this->submission_number, 'C39', 1, 50)
            . '" alt="barcode" />';
    }
}

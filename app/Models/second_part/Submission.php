<?php
namespace App\Models\second_part;

use App\Models\Plant;
use App\Models\Sample;
use App\Models\Tenant;
use Milon\Barcode\DNS1D;
use App\Models\SamplePlant;
use App\Models\part_three\Result;
use Illuminate\Database\Eloquent\Model;
use App\Models\second_part\SubmissionItem;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory;

   
    use Prunable;
   public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    } 
    protected $guarded = ['id'];
    protected $connection = 'tenant';
    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_id');
    }
    public function sub_plant()
    {
        return $this->belongsTo(Plant::class, 'sub_plant_id');
    }
    public function sample_main()
    {
        return $this->belongsTo(SamplePlant::class, 'plant_sample_id');
    }
    public function sample()
    {
        return $this->belongsTo(Sample::class, 'sample_id');
    }
    public function master_sample()
    {
        return $this->belongsTo(Sample::class, 'sample_id');
    }
    public function new_sample_main()
    {
        return $this->belongsTo(SamplePlant::class, 'plant_sample_id');
    }
    public function submission_test_method_items()
    {
        return $this->hasMany(SubmissionItem::class, 'submission_id', 'id');
    }
    public function result()
    {
        return $this->hasOne(Result::class, 'submission_id', 'id');
    }

    public function getBarcodeAttribute()
    {
        $barcode = new DNS1D();
        $barcode->setStorPath(storage_path('framework/barcodes/'));
        return $barcode->getBarcodeHTML($this->submission_number, 'C39', 1, 40);
    }

    public function getBarcodeImageAttribute()
    {
        $barcode = new DNS1D();
        $barcode->setStorPath(__DIR__ . "/cache/");

        return '<img src="data:image/png;base64,'
        . $barcode->getBarcodePNG($this->submission_number, 'C39', 1, 50)
            . '" alt="barcode" />';
    }

}

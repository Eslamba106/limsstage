<?php
namespace App\Models;

use App\Models\part_three\Result;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
class Certificate extends Model
{
    use HasFactory;

   
    use Prunable;
   public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }     protected $guarded = [];

    public function certificate_items()
    {
        return $this->hasMany(CertificateItem::class, 'certificate_id');
    }
    public function result()
    {
        return $this->belongsTo(Result::class, 'result_id');
    }
    public function sample()
    {
        return $this->belongsTo(Sample::class, 'sample_id');
    }
    public function authorized_By()
    {
        return $this->belongsTo(User::class, 'authorized_id');
    }
}

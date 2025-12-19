<?php

namespace App\Models\part_three;

use App\Models\User;
use App\Models\Plant;
use App\Models\Sample;
use App\Models\Tenant;
use App\Models\SamplePlant;
use App\Models\second_part\Submission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;
        use Prunable;
    public function prunable()
    {
        $days = Tenant::first()->tenant_delete_days ?? 30;

        return static::where('created_at', '<=', now()->subDays($days));
    }
    protected $guarded = ['id'];

    public function submission()
    {
        return $this->belongsTo( Submission::class, 'submission_id');
    }
    public function plant()
    {
        return $this->belongsTo( Plant::class, 'plant_id');
    }
    public function sub_plant()
    {
        return $this->belongsTo(Plant::class, 'sub_plant_id');
    }
    public function plant_sample(){
        return $this->belongsTo(SamplePlant::class, 'plant_sample_id');
    }
    public function sample()
    {
        return $this->belongsTo(Sample::class, 'sample_id');
    }
    public function result_test_method_items()
    {
        return $this->hasMany(ResultTestMethod::class, 'result_id', 'id');
    }
    public function result_test_method()
    {
        return $this->hasMany(ResultTestMethod::class, 'result_id', 'id');
    }
      public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function result_items()
{
    return $this->hasManyThrough(
        ResultTestMethodItem::class,  
        ResultTestMethod::class,      
        'result_id',                  
        'result_test_method_id',      
        'id',                         
        'id'                         
    );
}

}

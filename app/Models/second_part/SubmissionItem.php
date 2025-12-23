<?php

namespace App\Models\second_part;

use App\Models\Tenant;
use App\Models\SampleTestMethod;
use App\Models\part_three\ResultItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubmissionItem extends Model
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
        return $this->belongsToMany(Submission::class, 'submission_id');
    }
    public function sample_test_method()
    {
        return $this->belongsTo(SampleTestMethod::class, 'sample_test_method_item_id');
    }

    public function result()
    {
        return $this->hasOne(ResultItem::class, 'submission_item', 'id');
    }
}

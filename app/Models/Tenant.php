<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;

class Tenant extends Model
{
    use HasFactory;


    protected $guarded = [];


    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function schema()
    {
        return $this->belongsTo(Schema::class, 'schema_id');
    }


    public static function deactivateExpiredTenants()
    {
        return self::whereDate('expire', '<=', Carbon::today())
            ->where('status', '!=', 'inactive')
            ->update(['status' => 'inactive']);
    }
}

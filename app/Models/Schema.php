<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schema extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $connection = 'mysql';

    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'schema_id', 'id');
    }
public function getTenantsCountAttribute()
{
    return $this->tenants()->count();
}

}

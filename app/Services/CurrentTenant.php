<?php

namespace App\Services;

use App\Models\Tenant;

class CurrentTenant
{
    public Tenant $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }
}

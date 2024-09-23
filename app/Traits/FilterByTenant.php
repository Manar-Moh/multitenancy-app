<?php

namespace App\Traits;

trait FilterByTenant
{
    public static function booted(): void
    {

       $currentTenantId = auth()->user()->current_tenant_id;

       static::creating(function ($model) {
            $model->tenant_id = auth()->user()->tenant_id;
        });

       static::addGlobalScope(function ($builder) use ($currentTenantId) {
            $builder->where('tenant_id', $currentTenantId);
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToPrimaryModel;
use Stancl\Tenancy\Database\Concerns\TenantConnection;

class Task extends Model
{
    use HasFactory;
    use BelongsToPrimaryModel;
    //use TenantConnection;
    protected static $unguarded = true;


    public function getRelationshipToPrimaryModel(): string
    {
        return 'project';
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

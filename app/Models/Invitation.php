<?php

namespace App\Models;

use App\Traits\FilterByTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    use HasFactory;
    //use FilterByTenant;
    protected $guarded = [];
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}

<?php

namespace App\Models;

use App\Traits\FilterByTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Stancl\Tenancy\Database\Concerns\TenantConnection;

class Project extends Model
{
    //use TenantConnection;
    use HasFactory;
//    use FilterByTenant;
    use BelongsToTenant;

    protected $table = 'projects';
    protected static $unguarded = true;
}

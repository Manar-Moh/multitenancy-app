<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

class Domain extends Model
{
    use CentralConnection;
    protected static $unguarded = true;
}

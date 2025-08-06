<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'status',
        'default',
    ];
}

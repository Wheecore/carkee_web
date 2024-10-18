<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageProduct extends Model
{
    protected $fillable=[
        'package_id',
        'products',
        'type',
    ];
}

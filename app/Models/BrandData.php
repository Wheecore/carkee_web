<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandData extends Model
{
    protected $table = 'brand_datas';
    public $timestamps = false;
    use HasFactory;
}

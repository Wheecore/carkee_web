<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'package_id'];

    public function package(){
        return $this->belongsTo(Package::class);
    }
}

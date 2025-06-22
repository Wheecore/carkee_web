<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartTypeTranslation extends Model
{
  protected $fillable = ['name', 'lang', 'part_type_id'];

  public function partType(){
    return $this->belongsTo(PartType::class);
  }
}

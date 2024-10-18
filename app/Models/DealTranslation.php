<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealTranslation extends Model
{
  protected $fillable = ['title', 'lang', 'deal_id'];

  public function deal(){
    return $this->belongsTo(Deal::class);
  }

}

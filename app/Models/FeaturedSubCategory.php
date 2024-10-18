<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedSubCategory extends Model
{
   protected $fillable=[
       'featured_category_id',
       'name'
   ];
}

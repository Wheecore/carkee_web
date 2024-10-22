<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'user_id',
		'code',
		'name',
		'company_phone',
		'company_number',
		'email',
		'pic_name',
		'pic_phone',
		'address',
	];

}

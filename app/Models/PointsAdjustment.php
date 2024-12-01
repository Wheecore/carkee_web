<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsAdjustment extends Model
{
	use HasFactory;

	protected $table = 'points_adjustment';

	protected $fillable = [
		'user_id',
		'point',
		'remark',
	];

	/**
	 * Define the relationship with the User model.
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Calculate the sum of points for a specific user.
	 *
	 * @param int $userId
	 * @return int
	 */
	public static function sumPointsForUser($userId)
	{
		return self::where('user_id', $userId)->sum('point');
	}

	/**
	 * Calculate the sum of all points across all users.
	 *
	 * @return int
	 */
	public static function sumAllPoints()
	{
		return self::sum('point');
	}
}

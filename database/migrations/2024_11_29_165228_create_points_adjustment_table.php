<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointsAdjustmentTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('points_adjustment', function (Blueprint $table) {
			$table->id(); // Auto-incrementing ID
			$table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
			$table->string('point', 255); // Use VARCHAR instead of INTEGER for points
			$table->string('remark')->nullable(); // Optional remark
			$table->timestamps(); // Created at and updated at
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('points_adjustment');
	}
}

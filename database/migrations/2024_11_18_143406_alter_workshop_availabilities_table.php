<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterWorkshopAvailabilitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('workshop_availabilities', function (Blueprint $table) {
			$table->integer('shop_id')->nullable(false); // Add shop_id column
			$table->date('date')->nullable(false); // Add date column
			$table->time('from_time')->nullable(); // Add from_time column, nullable
			$table->time('to_time')->nullable(); // Add to_time column, nullable
			$table->integer('booked_appointments')->default(0)->nullable(false); // Add booked_appointments column with default value 0
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('workshop_availabilities', function (Blueprint $table) {
			$table->dropColumn('shop_id');
			$table->dropColumn('date');
			$table->dropColumn('from_time');
			$table->dropColumn('to_time');
			$table->dropColumn('booked_appointments');
		});
	}
}

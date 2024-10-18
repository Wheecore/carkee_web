<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopAvailabilitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('workshop_availabilities')) {
			Schema::create('workshop_availabilities', function (Blueprint $table) {
				$table->id(); // Add a primary key if needed
				$table->timestamps(); // This will add 'created_at' and 'updated_at' columns
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('workshop_availabilities');
	}
}

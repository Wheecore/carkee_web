<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('batteries')) {
			Schema::create('batteries', function (Blueprint $table) {
				$table->id();
				$table->integer('user_id');
				$table->integer('attachment_id');
				$table->integer('car_brand_id')->nullable();
				$table->integer('car_model_id')->nullable();
				$table->integer('car_detail_id')->nullable();
				$table->integer('car_year_id')->nullable();
				$table->integer('car_type_id')->nullable();
				$table->char('service_type', 1)->default('N');
				$table->string('name')->nullable();
				$table->string('warranty')->nullable();
				$table->string('model')->nullable();
				$table->double('amount', 20, 2)->default(0.00);
				$table->double('discount', 20, 2)->default(0.00);
				$table->string('capacity')->nullable();
				$table->string('cold_cranking_amperes')->nullable();
				$table->string('mileage_warranty')->nullable();
				$table->string('reserve_capacity')->nullable();
				$table->string('height')->nullable();
				$table->string('length')->nullable();
				$table->char('start_stop_function', 1)->default('N');
				$table->string('jis')->nullable();
				$table->char('absorbed_glass_mat', 1)->default('N');
				$table->timestamps();
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
		Schema::dropIfExists('batteries');
	}
};

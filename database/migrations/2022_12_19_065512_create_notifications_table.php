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
		if (!Schema::hasTable('notifications')) {
			Schema::create('notifications', function (Blueprint $table) {
				$table->id();
				$table->integer('user_id');
				$table->boolean('is_admin')->default(1);
				$table->char('type', 1);
				$table->text('body');
				$table->boolean('is_viewed')->default(0);
				$table->integer('order_id')->nullable();
				$table->integer('availability_request_id')->nullable();
				$table->integer('package_remind_id')->nullable();
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
		Schema::dropIfExists('notifications');
	}
};

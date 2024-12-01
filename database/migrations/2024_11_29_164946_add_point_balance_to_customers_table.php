<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPointBalanceToCustomersTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table('customers', function (Blueprint $table) {
			$table->string('point_balance', 255)->default('0')->after('user_id'); // Add column as VARCHAR
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('customers', function (Blueprint $table) {
			$table->dropColumn('point_balance'); // Remove the column
		});
	}
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerCodeToShopsTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::table('shops', function (Blueprint $table) {
			$table->string('customer_code')->nullable()->after('rating'); // Add the customer_code column
		});

		// Update data using SQL
		DB::statement("
				UPDATE `carkee_carkee.my`.shops AS s
				JOIN `carkee_sales.carkee.my`.customers AS c
				ON s.name = c.name
				SET s.customer_code = c.code,
				    s.address = c.address,
                    s.phone = c.company_phone,
                    s.name = c.name
                ;
			");

	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('shops', function (Blueprint $table) {
			$table->dropColumn('customer_code'); // Remove the column
		});
	}

    // php artisan migrate --path=/database/migrations/2024_12_14_170439_add_customer_code_to_shops_table.php
    // php artisan migrate:rollback --path=/database/migrations/2024_12_14_170439_add_customer_code_to_shops_table.php
}

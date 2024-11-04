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
		Schema::table('categories', function (Blueprint $table) {
			$table->integer('active')->default(1)->after('meta_description');
		});

		DB::table('categories')->insert([
			['name' => 'Parts','commision_rate'=>'0.00','meta_title'=>'Parts','meta_description'=>'Parts', 'active' => 1]
		]);

        // update the categories table, where name is "Services" & "Emergency Services", active = 0
        DB::table('categories')->where('name', 'Services')->update(['active' => 0]);
        DB::table('categories')->where('name', 'Emergency Services')->update(['active' => 0]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('categories', function (Blueprint $table) {
			$table->dropColumn('active');
		});
	}
};

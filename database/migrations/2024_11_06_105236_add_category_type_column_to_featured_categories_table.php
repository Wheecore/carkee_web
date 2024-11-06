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
		Schema::table('featured_categories', function (Blueprint $table) {
            $table->string('type')->default(null)->after('slug');
        });

        // update current featured categories, set category_type = "tyre"
        DB::table('featured_categories')->update(['type' => 'tyre']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('featured_categories', function (Blueprint $table) {
			//
		});
	}
};

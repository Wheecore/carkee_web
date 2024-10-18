<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('phone');
			$table->dropColumn('fax');
			$table->string('company_number')->after('code')->nullable();
			$table->string('company_phone')->after('company_number')->nullable();
			$table->string('pic_name')->after('company_phone')->nullable();
			$table->string('pic_phone')->after('pic_name')->nullable();
			$table->string('email')->after('pic_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('company_number');
			$table->dropColumn('company_phone');
			$table->dropColumn('pic_name');
			$table->dropColumn('pic_phone');
			$table->dropColumn('email');
			$table->string('phone')->after('code')->nullable();
			$table->string('fax')->after('phone')->nullable();
        });
    }
};

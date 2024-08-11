<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYearToInitialData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('electricity_productions', function (Blueprint $table) {
            $table->integer('year')->nullable();
        });
        Schema::table('year_start_data', function (Blueprint $table) {
            $table->integer('year')->nullable();
        });
        Schema::table('coal_receipt_plans', function (Blueprint $table) {
            $table->integer('year')->nullable();
        });
        Schema::table('consumption_plans', function (Blueprint $table) {
            $table->integer('year')->nullable();
        });
        Schema::table('bbm_receipt_plans', function (Blueprint $table) {
            $table->integer('year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('electricity_productions', function (Blueprint $table) {
            $table->dropColumn('year');
        });
        Schema::table('year_start_data', function (Blueprint $table) {
            $table->dropColumn('year');
        });
        Schema::table('coal_receipt_plans', function (Blueprint $table) {
            $table->dropColumn('year');
        });
        Schema::table('consumption_plans', function (Blueprint $table) {
            $table->dropColumn('year');
        });
        Schema::table('bbm_receipt_plans', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
}

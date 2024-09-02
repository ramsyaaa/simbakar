<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnalyticsColumnsToBbmReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bbm_receipts', function (Blueprint $table) {
            $table->foreignId('analytic_before_id')->nullable();
            $table->foreignId('analytic_after_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bbm_receipts', function (Blueprint $table) {
            //
        });
    }
}

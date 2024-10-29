<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartDateUnloadingToDetailBiomassaReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_biomassa_receipts', function (Blueprint $table) {
            $table->date('start_date_unloading')->nullable();
            $table->date('end_date_unloading')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_biomassa_receipts', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplierIdToCoalContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coal_contracts', function (Blueprint $table) {
            $table->string('supplier_id')->references('id')->on('suppliers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coal_contracts', function (Blueprint $table) {
            $table->dropColumn('supplier_id');
        });
    }
}

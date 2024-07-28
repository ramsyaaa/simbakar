<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContractIdToCoalUnloadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coal_unloadings', function (Blueprint $table) {
            $table->string('contract_id')->references('id')->on('coal_contracts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coal_unloadings', function (Blueprint $table) {
            $table->dropColumn('contract_id');
        });
    }
}

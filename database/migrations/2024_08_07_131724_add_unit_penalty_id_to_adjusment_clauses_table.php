<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitPenaltyIdToAdjusmentClausesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjusment_clauses', function (Blueprint $table) {
            $table->integer('unit_penalty_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adjusment_clauses', function (Blueprint $table) {
            $table->dropColumn('unit_penalty_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPenaltyIdToRefusalPenaltyClausesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refusal_penalty_clauses', function (Blueprint $table) {
            $table->integer('penalty_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refusal_penalty_clauses', function (Blueprint $table) {
            $table->dropColumn('penalty_id');
        });
    }
}

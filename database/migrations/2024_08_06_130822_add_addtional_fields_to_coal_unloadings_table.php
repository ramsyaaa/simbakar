<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddtionalFieldsToCoalUnloadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coal_unloadings', function (Blueprint $table) {
            $table->bigInteger('ds')->nullable();
            $table->bigInteger('tug_3_accept')->nullable();
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
           $table->dropColumn('ds');
           $table->dropColumn('tug_3_accept');
        });
    }
}

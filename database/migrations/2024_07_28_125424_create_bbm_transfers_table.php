<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbmTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbm_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('kind_bbm')->nullable();
            $table->integer('bunker_source_id')->nullable();
            $table->integer('start_level_source')->nullable();
            $table->integer('end_level_source')->nullable();
            $table->integer('start_sounding_source')->nullable();
            $table->integer('end_sounding_source')->nullable();
            $table->integer('bunker_destination_id')->nullable();
            $table->integer('start_level_destination')->nullable();
            $table->integer('end_level_destination')->nullable();
            $table->integer('start_sounding_destination')->nullable();
            $table->integer('end_sounding_destination')->nullable();
            $table->integer('ba_number')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('volume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bbm_transfers');
    }
}

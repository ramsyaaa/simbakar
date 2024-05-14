<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearStartDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('year_start_data', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('setting_bpb_uuid');
            $table->string('type');
            $table->string('planning')->nullable();
            $table->string('actual')->nullable();
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
        Schema::dropIfExists('year_start_data');
    }
}

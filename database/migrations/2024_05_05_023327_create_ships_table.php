<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ships', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('type_ship_uuid');
            $table->string('load_type_uuid');
            $table->string('name');
            $table->string('year_created');
            $table->string('flag');
            $table->string('grt');
            $table->string('dwt');
            $table->string('loa');
            $table->boolean('status');
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
        Schema::dropIfExists('ships');
    }
}

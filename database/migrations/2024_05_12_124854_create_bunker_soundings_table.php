<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBunkerSoundingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bunker_soundings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('bunker_uuid');
            $table->string('meter')->nullable();
            $table->string('centimeter')->nullable();
            $table->string('milimeter')->nullable();
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
        Schema::dropIfExists('bunker_soundings');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeShipDockAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_ship_dock_availabilities', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('type_ship_uuid');
            $table->string('dock_uuid');
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
        Schema::dropIfExists('type_ship_dock_availabilities');
    }
}

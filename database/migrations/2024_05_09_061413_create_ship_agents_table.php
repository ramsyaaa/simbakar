<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_agents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('load_type_uuid');
            $table->string('name');
            $table->text('address');
            $table->string('phone');
            $table->string('fax');
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
        Schema::dropIfExists('ship_agents');
    }
}

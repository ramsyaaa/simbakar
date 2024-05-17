<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingBpbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_bpbs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('year');
            $table->string('last_bpb_coal');
            $table->string('last_bpb_solar');
            $table->string('last_bpb_residu');
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
        Schema::dropIfExists('setting_bpbs');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoalUnloadingDisruptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coal_unloading_disruptions', function (Blueprint $table) {
            $table->id();
            $table->integer('unloading_id')->nullable();
            $table->string('kind_disruption')->nullable();
            $table->string('group_disruption')->nullable();
            $table->timestamp('start_disruption_date')->nullable();
            $table->timestamp('end_disruption_date')->nullable();
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
        Schema::dropIfExists('coal_unloading_disruptions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugs', function (Blueprint $table) {
            $table->id();
            $table->integer('tug')->nullable();
            $table->string('tug_number')->nullable();
            $table->string('bpb_number')->nullable();
            $table->bigInteger('usage_amount')->nullable();
            $table->integer('coal_unloading_id')->nullable();
            $table->integer('coal_usage_id')->nullable();
            $table->integer('bbm_receipt_id')->nullable();
            $table->integer('bbm_usage_id')->nullable();
            $table->string('unit')->nullable();
            $table->string('type_fuel')->nullable();
            $table->string('type_tug')->nullable();
            $table->string('warehouse')->nullable();
            $table->string('user_inspections')->nullable();
            $table->string('general_manager')->nullable();
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
        Schema::dropIfExists('tugs');
    }
}

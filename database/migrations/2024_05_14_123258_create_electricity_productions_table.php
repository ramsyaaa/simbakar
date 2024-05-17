<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectricityProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electricity_productions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('setting_bpb_uuid');
            $table->string('planning_january')->nullable();
            $table->string('planning_february')->nullable();
            $table->string('planning_march')->nullable();
            $table->string('planning_april')->nullable();
            $table->string('planning_may')->nullable();
            $table->string('planning_june')->nullable();
            $table->string('planning_july')->nullable();
            $table->string('planning_august')->nullable();
            $table->string('planning_september')->nullable();
            $table->string('planning_october')->nullable();
            $table->string('planning_november')->nullable();
            $table->string('planning_december')->nullable();
            $table->string('actual_january')->nullable();
            $table->string('actual_february')->nullable();
            $table->string('actual_march')->nullable();
            $table->string('actual_april')->nullable();
            $table->string('actual_may')->nullable();
            $table->string('actual_june')->nullable();
            $table->string('actual_july')->nullable();
            $table->string('actual_august')->nullable();
            $table->string('actual_september')->nullable();
            $table->string('actual_october')->nullable();
            $table->string('actual_november')->nullable();
            $table->string('actual_december')->nullable();
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
        Schema::dropIfExists('electricity_productions');
    }
}

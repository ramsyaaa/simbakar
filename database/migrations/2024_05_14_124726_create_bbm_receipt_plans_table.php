<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbmReceiptPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbm_receipt_plans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('setting_bpb_uuid');
            $table->string('type');
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
        Schema::dropIfExists('bbm_receipt_plans');
    }
}

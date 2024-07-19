<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbmReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbm_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_type')->nullable();
            $table->string('bbm_type')->nullable();
            $table->string('load_company_uuid')->nullable();
            $table->string('bpb_number')->nullable();
            $table->string('order_number')->nullable();
            $table->string('faktur_number')->nullable();
            $table->string('port_origin')->nullable();
            $table->string('destination_port')->nullable();
            $table->string('dock')->nullable();
            $table->string('ship_agent_uuid')->nullable();
            $table->string('supplier_uuid')->nullable();
            $table->string('bunker_uuid')->nullable();
            $table->string('ship_uuid')->nullable();
            $table->string('captain')->nullable();
            $table->string('transporter_uuid')->nullable();
            $table->datetime('load_date')->nullable();
            $table->datetime('arrival_date')->nullable();
            $table->datetime('docked_date')->nullable();
            $table->datetime('unload_date')->nullable();
            $table->datetime('finish_date')->nullable();
            $table->datetime('departure_date')->nullable();
            $table->string('car_type')->nullable();
            $table->string('police_number')->nullable();
            $table->string('note')->nullable();
            $table->string('faktur_obs')->nullable();
            $table->string('faktur_ltr15')->nullable();
            $table->string('ubl_obs')->nullable();
            $table->string('ubl_ltr15')->nullable();
            $table->string('ual_obs')->nullable();
            $table->string('ual_ltr15')->nullable();
            $table->string('ubd_obs')->nullable();
            $table->string('ubd_ltr15')->nullable();
            $table->string('uad_obs')->nullable();
            $table->string('uad_ltr15')->nullable();
            $table->string('vol_level_awal_obs')->nullable();
            $table->string('vol_level_akhir_abs')->nullable();
            $table->string('vol_level_awal_ltr15')->nullable();
            $table->string('vol_level_akhir_ltr15')->nullable();
            $table->string('hasil_sond_awal')->nullable();
            $table->string('hasil_sond_akhir')->nullable();
            $table->string('flow_meter_awal')->nullable();
            $table->string('flow_meter_akhir')->nullable();
            $table->string('liter_15_tug3')->nullable();
            $table->string('tug3_number')->nullable();
            $table->date('date_receipt')->nullable();
            $table->string('norm_number')->nullable();
            $table->string('unit')->nullable();
            $table->string('amount_receipt')->nullable();
            $table->string('inspector')->nullable();
            $table->string('head_of_warehouse')->nullable();
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
        Schema::dropIfExists('bbm_receipts');
    }
}

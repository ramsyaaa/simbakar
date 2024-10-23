<?php

namespace App\Http\Controllers\Input\BbmReceipt;

use App\BbmReceipt;
use App\Bunkers;
use App\Dock;
use App\Harbor;
use App\Http\Controllers\Controller;
use App\LoadingCompany;
use App\Models\BbmBookContract;
use App\Models\HeadWarehouse;
use App\Models\Tug;
use App\Models\UserInspection;
use App\Ship;
use App\ShipAgent;
use App\Supplier;
use App\Transporter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BbmReceiptController extends Controller
{
    public $amount_receipts = [
        "Selisih Volume Level",
        "Selisih Volume Level (Liter 15)",
        "Selisih Hasil Sounding",
        "Selisih Flow Meter",
        "Faktur",
        "Faktur Liter 15",
    ];

    public function index(Request $request, $shipment_type)
    {
        $data['shipment_type'] = $shipment_type;

        if($data['shipment_type'] != "ship" && $data['shipment_type'] != 'car'){
            $data['shipment_type'] = "ship";
        }

        $loadings = BbmReceipt::query();

        $loadings->where(['shipment_type' => $data['shipment_type']])->when($request->year, function ($query) use ($request) {
            $query->whereYear('created_at', $request->year);
        });

        $data['loadings'] = $loadings->latest()->paginate(10)->appends(request()->query());
        return view('inputs.bbm_receipt.bbm_receipt.index', ['shipment_type' => $shipment_type],$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($shipment_type)
    {
        $data['shipment_type'] = $shipment_type;
        $data['amount_receipts'] = $this->amount_receipts;

        if($data['shipment_type'] != "ship" && $data['shipment_type'] != 'car'){
            $data['shipment_type'] = "ship";
        }

        $data['load_companies'] = LoadingCompany::get();
        $data['ship_agents'] = ShipAgent::get();
        $data['harbors'] = Harbor::get();
        $data['suppliers'] = Supplier::get();
        $data['bunkers'] = Bunkers::get();
        $data['ships'] = Ship::get();
        $data['transporters'] = Transporter::get();
        $data['docks'] = Dock::get();
        $data['heads'] = HeadWarehouse::all();
        $data['inspections'] = UserInspection::all();
        $data['bbm_books'] = BbmBookContract::all();

        return view('inputs.bbm_receipt.bbm_receipt.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $shipment_type)
    {
        $request->validate([
            'port_origin' => 'required_if:shipment_type,ship',
            'destination_port' => 'required_if:shipment_type,ship',
            'dock' => 'required_if:shipment_type,ship',
            'ship_uuid' => 'required_if:shipment_type,ship',
            'captain' => 'required_if:shipment_type,ship',
            'load_date' => 'required_if:shipment_type,ship',
            'arrival_date' => 'required_if:shipment_type,ship',
            'docked_date' => 'required_if:shipment_type,ship',
            'departure_date' => 'required_if:shipment_type,ship',
            'car_type' => 'required_if:shipment_type,car',
            'police_number' => 'required_if:shipment_type,car',
            // Validasi lainnya
            'bbm_type' => 'required',
            'load_company_uuid' => 'required',
            'ship_agent_uuid' => 'required',
            // 'bpb_number' => 'required',
            'order_number' => 'required',
            'faktur_number' => 'required',
            'supplier_uuid' => 'required',
            'bunker_uuid' => 'required',
            'transporter_uuid' => 'required',
            'unload_date' => 'required',
            'finish_date' => 'required',
            'note' => 'required',
            'faktur_obs' => 'required',
            'faktur_ltr15' => 'required',
            // 'ubl_obs' => 'required',
            // 'ubl_ltr15' => 'required',
            'ual_obs' => 'required',
            'ual_ltr15' => 'required',
            'ubd_obs' => 'required',
            'ubd_ltr15' => 'required',
            'uad_obs' => 'required',
            'uad_ltr15' => 'required',
            'vol_level_awal_obs' => 'required',
            'vol_level_akhir_abs' => 'required',
            'vol_level_awal_ltr15' => 'required',
            'vol_level_akhir_ltr15' => 'required',
            'hasil_sond_awal' => 'required',
            'hasil_sond_akhir' => 'required',
            'flow_meter_awal' => 'required',
            'flow_meter_akhir' => 'required',
            'liter_15_tug3' => 'required',
            // 'tug3_number' => 'required',
            'date_receipt' => 'required',
            'norm_number' => 'required',
            'unit' => 'required',
            'amount_receipt' => 'required',
            'inspector' => 'required',
            'head_of_warehouse' => 'required',
        ], [
            'port_origin.required_if' => 'Pelabuhan asal wajib diisi jika jenis pengiriman adalah kapal',
            'destination_port.required_if' => 'Pelabuhan tujuan wajib diisi jika jenis pengiriman adalah kapal',
            'dock.required_if' => 'Dermaga wajib diisi jika jenis pengiriman adalah kapal',
            'ship_uuid.required_if' => 'UUID kapal wajib diisi jika jenis pengiriman adalah kapal',
            'captain.required_if' => 'Kapten wajib diisi jika jenis pengiriman adalah kapal',
            'load_date.required_if' => 'Tanggal muat wajib diisi jika jenis pengiriman adalah kapal',
            'arrival_date.required_if' => 'Tanggal kedatangan wajib diisi jika jenis pengiriman adalah kapal',
            'docked_date.required_if' => 'Tanggal berlabuh wajib diisi jika jenis pengiriman adalah kapal',
            'departure_date.required_if' => 'Tanggal keberangkatan wajib diisi jika jenis pengiriman adalah kapal',
            'car_type.required_if' => 'Jenis mobil wajib diisi jika jenis pengiriman adalah mobil',
            'police_number.required_if' => 'Nomor polisi wajib diisi jika jenis pengiriman adalah mobil',
            // Pesan validasi lainnya
            'bbm_type.required' => 'Jenis BBM wajib diisi',
            'load_company_uuid.required' => 'UUID perusahaan pemuat wajib diisi',
            'ship_agent_uuid.required' => 'Agen wajib diisi',
            // 'bpb_number.required' => 'Nomor BPB wajib diisi',
            'order_number.required' => 'Nomor pesanan wajib diisi',
            'faktur_number.required' => 'Nomor faktur wajib diisi',
            'supplier_uuid.required' => 'UUID pemasok wajib diisi',
            'bunker_uuid.required' => 'UUID bunker wajib diisi',
            'transporter_uuid.required' => 'UUID transporter wajib diisi',
            'unload_date.required' => 'Tanggal bongkar wajib diisi',
            'finish_date.required' => 'Tanggal selesai wajib diisi',
            'note.required' => 'Catatan wajib diisi',
            'faktur_obs.required' => 'Faktur OBS wajib diisi',
            'faktur_ltr15.required' => 'Faktur LTR15 wajib diisi',
            'ubl_obs.required' => 'UBL OBS wajib diisi',
            'ubl_ltr15.required' => 'UBL LTR15 wajib diisi',
            'ual_obs.required' => 'UAL OBS wajib diisi',
            'ual_ltr15.required' => 'UAL LTR15 wajib diisi',
            'ubd_obs.required' => 'UBD OBS wajib diisi',
            'ubd_ltr15.required' => 'UBD LTR15 wajib diisi',
            'uad_obs.required' => 'UAD OBS wajib diisi',
            'uad_ltr15.required' => 'UAD LTR15 wajib diisi',
            'vol_level_awal_obs.required' => 'Volume level awal OBS wajib diisi',
            'vol_level_akhir_abs.required' => 'Volume level akhir OBS wajib diisi',
            'vol_level_awal_ltr15.required' => 'Volume level awal LTR15 wajib diisi',
            'vol_level_akhir_ltr15.required' => 'Volume level akhir LTR15 wajib diisi',
            'hasil_sond_awal.required' => 'Hasil sond awal wajib diisi',
            'hasil_sond_akhir.required' => 'Hasil sond akhir wajib diisi',
            'flow_meter_awal.required' => 'Flow meter awal wajib diisi',
            'flow_meter_akhir.required' => 'Flow meter akhir wajib diisi',
            'liter_15_tug3.required' => 'Liter 15 tug3 wajib diisi',
            'tug3_number.required' => 'Nomor tug3 wajib diisi',
            'date_receipt.required' => 'Tanggal tanda terima wajib diisi',
            'norm_number.required' => 'Nomor norma wajib diisi',
            'unit.required' => 'Unit wajib diisi',
            'amount_receipt.required' => 'Jumlah tanda terima wajib diisi',
            'inspector.required' => 'Inspektur wajib diisi',
            'head_of_warehouse.required' => 'Kepala gudang wajib diisi',
        ]);

        $date = Carbon::parse($request->date_receipt); // Mengubah string menjadi instance Carbon
        $formattedDate = $date->format('Y-m-d'); 
        $formattedYear = $date->format('Y'); 
        $lastUnloadingToday = BbmReceipt::whereDate('date_receipt', $formattedDate)->get()->count() + 1;

        $count = sprintf("%02d", $lastUnloadingToday);
        $tugNumber = 'S.'.$date->format('Ymd').'.'.$count;

        $lastUnloadingYear = BbmReceipt::whereYear('date_receipt',$formattedYear)->get()->count() + 1;
        $bpbNumber = 'S.'.$formattedYear.'.'.$lastUnloadingYear;

        $bbm = BbmReceipt::create([
            'shipment_type' => $shipment_type,
            'port_origin' => $request->port_origin,
            'destination_port' => $request->destination_port,
            'dock' => $request->dock,
            'ship_agent_uuid' => $request->ship_agent_uuid,
            'ship_uuid' => $request->ship_uuid,
            'captain' => $request->captain,
            'load_date' => $request->load_date,
            'arrival_date' => $request->arrival_date,
            'docked_date' => $request->docked_date,
            'departure_date' => $request->departure_date,
            'car_type' => $request->car_type,
            'police_number' => $request->police_number,
            'bbm_type' => $request->bbm_type,
            'load_company_uuid' => $request->load_company_uuid,
            'bpb_number' => $bpbNumber,
            'order_number' => $request->order_number,
            'faktur_number' => $request->faktur_number,
            'supplier_uuid' => $request->supplier_uuid,
            'bunker_uuid' => $request->bunker_uuid,
            'transporter_uuid' => $request->transporter_uuid,
            'unload_date' => $request->unload_date,
            'finish_date' => $request->finish_date,
            'note' => $request->note,
            'faktur_obs' => $request->faktur_obs,
            'faktur_ltr15' => $request->faktur_ltr15,
            // 'ubl_obs' => $request->ubl_obs,
            // 'ubl_ltr15' => $request->ubl_ltr15,
            'ual_obs' => $request->ual_obs,
            'ual_ltr15' => $request->ual_ltr15,
            'ubd_obs' => $request->ubd_obs,
            'ubd_ltr15' => $request->ubd_ltr15,
            'uad_obs' => $request->uad_obs,
            'uad_ltr15' => $request->uad_ltr15,
            'vol_level_awal_obs' => $request->vol_level_awal_obs,
            'vol_level_akhir_abs' => $request->vol_level_akhir_abs,
            'vol_level_awal_ltr15' => $request->vol_level_awal_ltr15,
            'vol_level_akhir_ltr15' => $request->vol_level_akhir_ltr15,
            'hasil_sond_awal' => $request->hasil_sond_awal,
            'hasil_sond_akhir' => $request->hasil_sond_akhir,
            'flow_meter_awal' => $request->flow_meter_awal,
            'flow_meter_akhir' => $request->flow_meter_akhir,
            'liter_15_tug3' => $request->liter_15_tug3,
            'tug3_number' => $tugNumber,
            'date_receipt' => $request->date_receipt,
            'norm_number' => $request->norm_number,
            'unit' => $request->unit,
            'amount_receipt' => $request->amount_receipt,
            'inspector' => $request->inspector,
            'head_of_warehouse' => $request->head_of_warehouse,
        ]);

        Tug::create([
            'tug' => 3,
            'tug_number' => $tugNumber,
            'bpb_number' => $bpbNumber,
            'type_tug' => 'bbm-receipt',
            'usage_amount' => $request->amount_receipt,
            'unit' => 'L',
            'type_fuel' => $request->bbm_type,
            'bbm_receipt_id' => $bbm->id,
        ]);

        return redirect(route('inputs.bbm_receipts.index', ['shipment_type' => $shipment_type]))->with('success', 'Penerimaan BBM baru baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($shipment_type, $id)
    {
        $data['shipment_type'] = $shipment_type;

        if($data['shipment_type'] != "ship" && $data['shipment_type'] != 'car'){
            $data['shipment_type'] = "ship";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($shipment_type, $id)
    {
        $data['shipment_type'] = $shipment_type;
        $data['amount_receipts'] = $this->amount_receipts;

        if($data['shipment_type'] != "ship" && $data['shipment_type'] != 'car'){
            $data['shipment_type'] = "ship";
        }
        $data['bbm'] = BbmReceipt::where('id', $id)->first();
        $data['load_companies'] = LoadingCompany::get();
        $data['ship_agents'] = ShipAgent::get();
        $data['harbors'] = Harbor::get();
        $data['suppliers'] = Supplier::get();
        $data['bunkers'] = Bunkers::get();
        $data['ships'] = Ship::get();
        $data['transporters'] = Transporter::get();
        $data['docks'] = Dock::get();
        $data['heads'] = HeadWarehouse::all();
        $data['inspections'] = UserInspection::all();
        $data['bbm_books'] = BbmBookContract::all();

        return view('inputs.bbm_receipt.bbm_receipt.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shipment_type, $id)
    {
        $request->validate([
            'port_origin' => 'required_if:shipment_type,ship',
            'destination_port' => 'required_if:shipment_type,ship',
            'dock' => 'required_if:shipment_type,ship',
            'ship_uuid' => 'required_if:shipment_type,ship',
            'captain' => 'required_if:shipment_type,ship',
            'load_date' => 'required_if:shipment_type,ship',
            'arrival_date' => 'required_if:shipment_type,ship',
            'docked_date' => 'required_if:shipment_type,ship',
            'departure_date' => 'required_if:shipment_type,ship',
            'car_type' => 'required_if:shipment_type,car',
            'police_number' => 'required_if:shipment_type,car',
            // Validasi lainnya
            'bbm_type' => 'required',
            'load_company_uuid' => 'required',
            'ship_agent_uuid' => 'required',
            // 'bpb_number' => 'required',
            'order_number' => 'required',
            'faktur_number' => 'required',
            'supplier_uuid' => 'required',
            'bunker_uuid' => 'required',
            'transporter_uuid' => 'required',
            'unload_date' => 'required',
            'finish_date' => 'required',
            'note' => 'required',
            'faktur_obs' => 'required',
            'faktur_ltr15' => 'required',
            // 'ubl_obs' => 'required',
            // 'ubl_ltr15' => 'required',
            'ual_obs' => 'required',
            'ual_ltr15' => 'required',
            'ubd_obs' => 'required',
            'ubd_ltr15' => 'required',
            'uad_obs' => 'required',
            'uad_ltr15' => 'required',
            'vol_level_awal_obs' => 'required',
            'vol_level_akhir_abs' => 'required',
            'vol_level_awal_ltr15' => 'required',
            'vol_level_akhir_ltr15' => 'required',
            'hasil_sond_awal' => 'required',
            'hasil_sond_akhir' => 'required',
            'flow_meter_awal' => 'required',
            'flow_meter_akhir' => 'required',
            'liter_15_tug3' => 'required',
            // 'tug3_number' => 'required',
            'date_receipt' => 'required',
            'norm_number' => 'required',
            'unit' => 'required',
            'amount_receipt' => 'required',
            'inspector' => 'required',
            'head_of_warehouse' => 'required',
        ], [
            'port_origin.required_if' => 'Pelabuhan asal wajib diisi jika jenis pengiriman adalah kapal',
            'destination_port.required_if' => 'Pelabuhan tujuan wajib diisi jika jenis pengiriman adalah kapal',
            'dock.required_if' => 'Dermaga wajib diisi jika jenis pengiriman adalah kapal',
            'ship_uuid.required_if' => 'UUID kapal wajib diisi jika jenis pengiriman adalah kapal',
            'captain.required_if' => 'Kapten wajib diisi jika jenis pengiriman adalah kapal',
            'load_date.required_if' => 'Tanggal muat wajib diisi jika jenis pengiriman adalah kapal',
            'arrival_date.required_if' => 'Tanggal kedatangan wajib diisi jika jenis pengiriman adalah kapal',
            'docked_date.required_if' => 'Tanggal berlabuh wajib diisi jika jenis pengiriman adalah kapal',
            'departure_date.required_if' => 'Tanggal keberangkatan wajib diisi jika jenis pengiriman adalah kapal',
            'car_type.required_if' => 'Jenis mobil wajib diisi jika jenis pengiriman adalah mobil',
            'police_number.required_if' => 'Nomor polisi wajib diisi jika jenis pengiriman adalah mobil',
            // Pesan validasi lainnya
            'bbm_type.required' => 'Jenis BBM wajib diisi',
            'load_company_uuid.required' => 'UUID perusahaan pemuat wajib diisi',
            'ship_agent_uuid.required' => 'Agen wajib diisi',
            // 'bpb_number.required' => 'Nomor BPB wajib diisi',
            'order_number.required' => 'Nomor pesanan wajib diisi',
            'faktur_number.required' => 'Nomor faktur wajib diisi',
            'supplier_uuid.required' => 'UUID pemasok wajib diisi',
            'bunker_uuid.required' => 'UUID bunker wajib diisi',
            'transporter_uuid.required' => 'UUID transporter wajib diisi',
            'unload_date.required' => 'Tanggal bongkar wajib diisi',
            'finish_date.required' => 'Tanggal selesai wajib diisi',
            'note.required' => 'Catatan wajib diisi',
            'faktur_obs.required' => 'Faktur OBS wajib diisi',
            'faktur_ltr15.required' => 'Faktur LTR15 wajib diisi',
            'ubl_obs.required' => 'UBL OBS wajib diisi',
            'ubl_ltr15.required' => 'UBL LTR15 wajib diisi',
            'ual_obs.required' => 'UAL OBS wajib diisi',
            'ual_ltr15.required' => 'UAL LTR15 wajib diisi',
            'ubd_obs.required' => 'UBD OBS wajib diisi',
            'ubd_ltr15.required' => 'UBD LTR15 wajib diisi',
            'uad_obs.required' => 'UAD OBS wajib diisi',
            'uad_ltr15.required' => 'UAD LTR15 wajib diisi',
            'vol_level_awal_obs.required' => 'Volume level awal OBS wajib diisi',
            'vol_level_akhir_abs.required' => 'Volume level akhir OBS wajib diisi',
            'vol_level_awal_ltr15.required' => 'Volume level awal LTR15 wajib diisi',
            'vol_level_akhir_ltr15.required' => 'Volume level akhir LTR15 wajib diisi',
            'hasil_sond_awal.required' => 'Hasil sond awal wajib diisi',
            'hasil_sond_akhir.required' => 'Hasil sond akhir wajib diisi',
            'flow_meter_awal.required' => 'Flow meter awal wajib diisi',
            'flow_meter_akhir.required' => 'Flow meter akhir wajib diisi',
            'liter_15_tug3.required' => 'Liter 15 tug3 wajib diisi',
            'tug3_number.required' => 'Nomor tug3 wajib diisi',
            'date_receipt.required' => 'Tanggal tanda terima wajib diisi',
            'norm_number.required' => 'Nomor norma wajib diisi',
            'unit.required' => 'Unit wajib diisi',
            'amount_receipt.required' => 'Jumlah tanda terima wajib diisi',
            'inspector.required' => 'Inspektur wajib diisi',
            'head_of_warehouse.required' => 'Kepala gudang wajib diisi',
        ]);

        BbmReceipt::where('id',$id)->update([
            'shipment_type' => $shipment_type,
            'port_origin' => $request->port_origin,
            'destination_port' => $request->destination_port,
            'dock' => $request->dock,
            'ship_agent_uuid' => $request->ship_agent_uuid,
            'ship_uuid' => $request->ship_uuid,
            'captain' => $request->captain,
            'load_date' => $request->load_date,
            'arrival_date' => $request->arrival_date,
            'docked_date' => $request->docked_date,
            'departure_date' => $request->departure_date,
            'car_type' => $request->car_type,
            'police_number' => $request->police_number,
            'bbm_type' => $request->bbm_type,
            'load_company_uuid' => $request->load_company_uuid,
            'bpb_number' => $request->bpb_number,
            'order_number' => $request->order_number,
            'faktur_number' => $request->faktur_number,
            'supplier_uuid' => $request->supplier_uuid,
            'bunker_uuid' => $request->bunker_uuid,
            'transporter_uuid' => $request->transporter_uuid,
            'unload_date' => $request->unload_date,
            'finish_date' => $request->finish_date,
            'note' => $request->note,
            'faktur_obs' => $request->faktur_obs,
            'faktur_ltr15' => $request->faktur_ltr15,
            // 'ubl_obs' => $request->ubl_obs,
            // 'ubl_ltr15' => $request->ubl_ltr15,
            'ual_obs' => $request->ual_obs,
            'ual_ltr15' => $request->ual_ltr15,
            'ubd_obs' => $request->ubd_obs,
            'ubd_ltr15' => $request->ubd_ltr15,
            'uad_obs' => $request->uad_obs,
            'uad_ltr15' => $request->uad_ltr15,
            'vol_level_awal_obs' => $request->vol_level_awal_obs,
            'vol_level_akhir_abs' => $request->vol_level_akhir_abs,
            'vol_level_awal_ltr15' => $request->vol_level_awal_ltr15,
            'vol_level_akhir_ltr15' => $request->vol_level_akhir_ltr15,
            'hasil_sond_awal' => $request->hasil_sond_awal,
            'hasil_sond_akhir' => $request->hasil_sond_akhir,
            'flow_meter_awal' => $request->flow_meter_awal,
            'flow_meter_akhir' => $request->flow_meter_akhir,
            'liter_15_tug3' => $request->liter_15_tug3,
            // 'tug3_number' => $request->tug3_number,
            'date_receipt' => $request->date_receipt,
            'norm_number' => $request->norm_number,
            'unit' => $request->unit,
            'amount_receipt' => $request->amount_receipt,
            'inspector' => $request->inspector,
            'head_of_warehouse' => $request->head_of_warehouse,
        ]);

        return redirect(route('inputs.bbm_receipts.index', ['shipment_type' => $shipment_type]))->with('success', 'Penerimaan BBM berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($shipment_type, $id)
    {
        BbmReceipt::where('id',$id)->first()->delete();

        return redirect(route('inputs.bbm_receipts.index', ['shipment_type' => $shipment_type]))->with('success', 'Penerimaan BBM berhasil dihapus.');
    }
}

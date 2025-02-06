<?php

namespace App\Http\Controllers\Input\BiomassaReceipt;

use App\BbmReceipt;
use App\BiomassaReceipt;
use App\Bunkers;
use App\DetailBiomassaReceipt;
use App\DetailUnloadingBiomassaReceipt;
use App\Dock;
use App\Harbor;
use App\Http\Controllers\Controller;
use App\LoadingCompany;
use App\Models\AnalyticBiomassa;
use App\Models\BbmBookContract;
use App\Models\BiomassaContract;
use App\Models\HeadWarehouse;
use App\Models\Tug;
use App\Models\UserInspection;
use App\Ship;
use App\ShipAgent;
use App\Supplier;
use App\Transporter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BiomassaReceiptController extends Controller
{
    public function index(Request $request)
    {
        $receipts = BiomassaReceipt::query();

        $receipts->when($request->year, function ($query) use ($request) {
            $query->whereYear('created_at', $request->year);
        });

        $data['receipts'] = $receipts->with(['detailReceipt'])->latest()->paginate(10)->appends(request()->query());
        foreach ($data['receipts'] as $receipt) {
            $receipt->total_volume = $receipt->detailReceipt->sum('volume');
        }

        return view('inputs.biomassa_receipt.biomassa_receipt.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['suppliers'] = Supplier::get();
        $data['contracts'] = [];

        return view('inputs.biomassa_receipt.biomassa_receipt.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lastUnloadingToday = BiomassaReceipt::whereDate('created_at', Carbon::today())->get()->count() + 1;

        $count = sprintf("%02d", $lastUnloadingToday);
        $date = isset($request->end_date_unloading[1]) ? date('Ymd', strtotime($request->end_date_unloading[1])) : date('Ymd');
        $tugNumber = 'Biomassa.'.$date.'.'.$count;

        $lastUnloadingYear = BiomassaReceipt::whereYear('created_at',date('Y'))->get()->count() + 1;
        $year = isset($request->end_date_unloading[1]) ? date('Y', strtotime($request->end_date_unloading[1])) : date('Ymd');
        $bpbNumber = 'Biomassa.'.$year.'.'.$lastUnloadingYear;

        $biomassa = BiomassaReceipt::create([
            'bpb_number' => $bpbNumber,
            'faktur_number' => $request->faktur_number,
            'main_supplier_uuid' => $request->main_supplier_uuid,
            'note' => $request->note,
            'tug3_number' => $tugNumber,
            'contract_id' => $request->contract_id,
        ]);

        $detail_biomassa = [];
        $totalVolume = 0;
        $latest_receipt_date= null;
        if(isset($request->supplier_uuid)){
            if(count($request->supplier_uuid) > 1){
                foreach ($request->supplier_uuid as $key => $supplier) {
                    if($key == 0){
                        continue;
                    }

                    $totalVolume += isset($request->volume[$key]) ? $request->volume[$key] : 0;
                    $latest_receipt_date = isset($request->end_date_unloading[$key]) ? $request->end_date_unloading[$key] : null;

                    $detail = DetailBiomassaReceipt::create([
                                'biomassa_receipt_id' => $biomassa->id,
                                'supplier_uuid' => $supplier,
                                'start_date_unloading' => isset($request->start_date_unloading[$key]) ? $request->start_date_unloading[$key] : null,
                                'end_date_unloading' => isset($request->end_date_unloading[$key]) ? $request->end_date_unloading[$key] : null,
                                'volume' => isset($request->volume[$key]) ? $request->volume[$key] : null,
                                'number_of_shipper' => isset($request->number_of_shipper[$key]) ? $request->number_of_shipper[$key] : null,
                                'date_shipment' => isset($request->date_shipment[$key]) ? $request->date_shipment[$key] : null,
                    ]);

                    AnalyticBiomassa::create([
                        'biomassa_receipt_id' => $biomassa->id,
                        'sub_supplier_id' => $detail->id,
                        'analysis_number' => isset($request->analysis_number[$key]) ? $request->analysis_number[$key] : null,
                        'analysis_date' => isset($request->date_shipment[$key]) ? $request->date_shipment[$key] : null,
                        'tonage' => isset($request->volume[$key]) ? $request->volume[$key] : null,
                        'total_moisure' => isset($request->total_moisure[$key]) ? $request->total_moisure[$key] : null,
                        'moisure_in_analysis' => isset($request->moisure_in_analysis[$key]) ? $request->moisure_in_analysis[$key] : null,
                        'calorivic_value' => isset($request->calorivic_value[$key]) ? $request->calorivic_value[$key] : null,
                        'retained_5' => isset($request->retained_5[$key]) ? $request->retained_5[$key] : null,
                    ]);
                }
            }
        }

        $unloading_biomassa = [];

        if(isset($request->start)){
            if(count($request->start) > 1){
                foreach ($request->start as $key => $start) {
                    if($key == 0){
                        continue;
                    }
                    $unloading_biomassa[] = [
                        'biomassa_receipt_id' => $biomassa->id,
                        'start' => $start,
                        'end' => isset($request->end[$key]) ? $request->end[$key] : null,
                        'date_unloading' => isset($request->date_unloading[$key]) ? $request->date_unloading[$key] : null,
                    ];
                }
            }
        }

        if(count($unloading_biomassa) > 0){
            DetailUnloadingBiomassaReceipt::insert($unloading_biomassa);
        }

        Tug::create([
            'tug' => 3,
            'tug_number' => $tugNumber,
            'bpb_number' => $bpbNumber,
            'type_tug' => 'biomassa-receipt',
            'typefuel' => 'biomassa',
            'unit' => 'Kg',
            'usage_amount' => $totalVolume,
            'biomassa_receipt_id' => $biomassa->id,
            'receipt_date' => $latest_receipt_date,
        ]);

        return redirect(route('inputs.biomassa_receipts.index'))->with('success', 'Penerimaan Biomassa baru baru berhasil dibuat.');
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
    public function edit($id)
    {
        $data['biomassa'] = BiomassaReceipt::where('id', $id)->first();
        $data['suppliers'] = Supplier::get();
        $data['contracts'] = BiomassaContract::get();

        return view('inputs.biomassa_receipt.biomassa_receipt.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        BiomassaReceipt::where(['id' => $id])->update([
            'faktur_number' => $request->faktur_number,
            'main_supplier_uuid' => $request->main_supplier_uuid,
            'note' => $request->note,
            'tug3_number' => $request->tug3_number,
            'contract_id' => $request->contract_id,
        ]);

        $biomassa = BiomassaReceipt::where(['id' => $id])->first();

        DetailBiomassaReceipt::where([
            'biomassa_receipt_id' => $biomassa->id,
        ])->delete();
        AnalyticBiomassa::where([
            'biomassa_receipt_id' => $biomassa->id,
        ])->delete();
        $detail_biomassa = [];
        $totalVolume = 0;
        $latest_receipt_date = null;
        if(isset($request->supplier_uuid)){
            if(count($request->supplier_uuid) > 1){
                foreach ($request->supplier_uuid as $key => $supplier) {
                    if($key == 0){
                        continue;
                    }

                    $totalVolume += isset($request->volume[$key]) ? $request->volume[$key] : 0;
                    $latest_receipt_date = isset($request->end_date_unloading[$key]) ? $request->end_date_unloading[$key] : null;

                    // dd($request->total_moisure3);
                    $detail = DetailBiomassaReceipt::create([
                                'biomassa_receipt_id' => $biomassa->id,
                                'supplier_uuid' => $supplier,
                                'start_date_unloading' => isset($request->start_date_unloading[$key]) ? $request->start_date_unloading[$key] : null,
                                'end_date_unloading' => isset($request->end_date_unloading[$key]) ? $request->end_date_unloading[$key] : null,
                                'volume' => isset($request->volume[$key]) ? $request->volume[$key] : null,
                                'number_of_shipper' => isset($request->number_of_shipper[$key]) ? $request->number_of_shipper[$key] : null,
                                'date_shipment' => isset($request->date_shipment[$key]) ? $request->date_shipment[$key] : null,
                    ]);

                    AnalyticBiomassa::create([
                        'biomassa_receipt_id' => $biomassa->id,
                        'sub_supplier_id' => $detail->id,
                        'analysis_number' => isset($request->analysis_number[$key]) ? $request->analysis_number[$key] : null,
                        'analysis_date' => isset($request->date_shipment[$key]) ? $request->date_shipment[$key] : null,
                        'tonage' => isset($request->volume[$key]) ? $request->volume[$key] : null,
                        'total_moisure' => isset($request->total_moisure[$key]) ? $request->total_moisure[$key] : null,
                        'moisure_in_analysis' => isset($request->moisure_in_analysis[$key]) ? $request->moisure_in_analysis[$key] : null,
                        'calorivic_value' => isset($request->calorivic_value[$key]) ? $request->calorivic_value[$key] : null,
                        'retained_5' => isset($request->retained_5[$key]) ? $request->retained_5[$key] : null,
                    ]);
                }
            }
        }

        if(count($detail_biomassa) > 0){
            DetailBiomassaReceipt::insert($detail_biomassa);
        }

        DetailUnloadingBiomassaReceipt::where([
            'biomassa_receipt_id' => $biomassa->id,
        ])->delete();

        $unloading_biomassa = [];

        if(isset($request->start)){
            if(count($request->start) > 1){
                foreach ($request->start as $key => $start) {
                    if($key == 0){
                        continue;
                    }
                    $unloading_biomassa[] = [
                        'biomassa_receipt_id' => $biomassa->id,
                        'start' => $start,
                        'end' => isset($request->end[$key]) ? $request->end[$key] : null,
                        'date_unloading' => isset($request->date_unloading[$key]) ? $request->date_unloading[$key] : null,
                    ];
                }
            }
        }

        if(count($unloading_biomassa) > 0){
            DetailUnloadingBiomassaReceipt::insert($unloading_biomassa);
        }

        Tug::where([
            'tug' => 3,
            'type_tug' => 'biomassa-receipt',
            'biomassa_receipt_id' => $biomassa->id,
        ])->update([
            'tug_number' => $request->tug3_number,
            'usage_amount' => $totalVolume,
            'receipt_date' => $latest_receipt_date,
        ]);

        return redirect(route('inputs.biomassa_receipts.index'))->with('success', 'Penerimaan Biomassa berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BiomassaReceipt::where('id',$id)->first()->delete();
        DetailBiomassaReceipt::where([
            'biomassa_receipt_id' => $id,
        ])->delete();
        DetailUnloadingBiomassaReceipt::where([
            'biomassa_receipt_id' => $id,
        ])->delete();
        AnalyticBiomassa::where([
            'biomassa_receipt_id' => $id,
        ])->delete();

        return redirect(route('inputs.biomassa_receipts.index'))->with('success', 'Penerimaan Biomassa berhasil dihapus.');
    }
}

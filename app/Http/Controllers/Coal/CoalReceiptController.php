<?php

namespace App\Http\Controllers\Coal;

use App\Dock;
use App\Ship;
use App\Labor;
use App\Harbor;
use App\Loading;
use App\Supplier;
use App\Surveyor;
use App\ShipAgent;
use App\Unloading;
use Carbon\Carbon;
use App\Models\Tug;
use App\Transporter;
use App\LoadingCompany;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Models\HeadWarehouse;
use App\Models\PenaltyClause;
use App\Models\UserInspection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SpesificationContractCoal;

class CoalReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $receipts = CoalUnloading::query();
        $receipts->when($request->date, function ($query) use ($request) {
            $date = explode('-', $request->date);
            $query->whereYear('unloading_date', $date[0]);
            $query->whereMonth('unloading_date', $date[1]);
        });
        $data['receipts'] = $receipts->latest()->paginate(10)->appends(request()->query());
        // dd($data);
        return view('coals.receipts.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['companies'] = LoadingCompany::all();
        $data['suppliers'] = Supplier::all();
        $data['docks'] = Dock::all();
        $data['ships'] = Ship::all();
        return view('coals.receipts.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $lastUnloadingToday = Tug::whereDate('created_at', Carbon::today())->get()->count() + 1;

            $count = sprintf("%02d", $lastUnloadingToday);
            $tugNumber = 'B.'.date('Ymd').'.'.$count;

            $requestData = $request->all();
            $requestData['tug_number'] = $tugNumber;
            
            $receipt = CoalUnloading::create($requestData);

            Tug::create([
                'tug' => 3,
                'tug_number' => $tugNumber,
                'bpb_number' => $bpbNumber,
                'tug_type' => 'coal-unloading',
                'usage_amount' => $requestData['bl'],
                'unit' => 'Kg',
                'type_fuel' => 'Batu Bara',
                'coal_unloading' => $unloading->id,
            ]);

            DB::commit();
            return redirect(route('coals.receipts.index'))->with('success', 'Pembongkaran Batu Bara berhasil di buat.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Pembongkaran Batu Bara gagal di buat');
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $receipt = CoalUnloading::where('id', $id)->first();
        $data['company'] = LoadingCompany::where('id',$receipt->load_company_id)->first();
        $data['supplier'] = Supplier::where('id',$receipt->supplier_id)->first();
        $data['docks'] = Dock::get();
        $data['ship'] = Ship::where('id',$receipt->ship_id)->first();
        $data['harbors'] = Harbor::get();
        $data['surveyors'] = Surveyor::get();
        $data['transporters'] = Transporter::get();
        $data['agents'] = ShipAgent::get();
        $data['heads'] = HeadWarehouse::get();
        $data['inspections'] = UserInspection::get();
        $data['loading'] = Loading::where('id',$receipt->analysis_loading_id)->first();
        $data['unloading'] = Unloading::where('id',$receipt->analysis_unloading_id)->first();
        $data['labor'] = Labor::where('id',$receipt->analysis_labor_id)->first();
        $data['contracts'] = CoalContract::where('supplier_id', $receipt->supplier_id)->get();
        $data['receipt'] = $receipt;

        return view('coals.receipts.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTug(Request $request,$id)
    {
  
        DB::beginTransaction();
        try {

            $requestData = $request->except(['_token','_method','check_tug']);

            if($request->has('check_tug')){

                $lastUnloadingToday = CoalUnloading::whereDate('created_at', Carbon::today())->get()->count() + 1;

                $countTug = sprintf("%02d", $lastUnloadingToday);
                $tugNumber = 'B.'.date('Ymd').'.'.$countTug;
                $requestData['tug_number'] = $tugNumber;

            }
            CoalUnloading::where('id',$id)->update($requestData);

            Tug::where('type_tug','coal-unloading')->where('coal_unloading_id',$id)->update([
                'tug_number' => $requestData['tug_number'],
            ]);

            DB::commit();
            return redirect(route('coals.receipts.index'))->with('success', 'Data Tambahan TUG 3 berhasil di ubah.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Data Tambahan TUG 3 gagal di ubah');
        }
    }
    public function updateDetail(Request $request,$id)
    {
        DB::beginTransaction();
        try {
            CoalUnloading::where('id',$id)->update($request->except(['_token','_method']));

            DB::commit();
            return redirect(route('coals.receipts.index'))->with('success', 'Pembongkaran Batu Bara berhasil di ubah.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Pembongkaran Batu Bara gagal di ubah');
        }
    }
    public function updateAnalytic(Request $request,$id)
    {
        DB::beginTransaction();
        try {
            $coal = CoalUnloading::where('id',$id)->first();
            if($request->kind_contract == 'FOB'){
                $coal->bl = $request->bl;
            }
            if($request->kind_contract == 'CIF'){
                $coal->ds = $request->ds;
            }
            $coal->bw = 0;
            $coal->tug_3_accept = $request->tug_3_accept;
            $coal->kind_contract = $request->kind_contract;
            $coal->save();

            DB::commit();
            return redirect()->back()->with('success', 'Data Analisa Kualitas berhasil di ubah.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Data Analisa Kualitas gagal di ubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function quality($id){

        $data['receipt'] = CoalUnloading::where('id', $id)->first();

        return view('coals.receipts.quality',$data);
    } 

    public function destroy($id)
    {
        CoalUnloading::where('id', $id)->delete();
        return redirect(route('coals.receipts.index'))->with('success', 'Pembongkaran Batu Bara berhasil di hapus.');
    }

    public function analyticLoading($id){
        $loading = CoalUnloading::where('id', $id)->first();
        $certificate = Loading::where('id',$loading->analysis_loading_id)->first();

        $data['coal'] = $loading;
        $data['certificate'] = $this->certificate($certificate);
        $data['spesification'] = SpesificationContractCoal::where('contract_id',$loading->contract_id)->first();
        $data['penalties'] = PenaltyClause::join('unit_penalties','unit_penalties.id','refusal_penalty_clauses.unit_penalty_id')->where('contract_id',$loading->contract_id)->get();
        return view('coals.receipts.loading',$data);
    }
    public function analyticUnloading($id){

        $unloading = CoalUnloading::where('id', $id)->first();
        $certificate = Unloading::where('id',$unloading->analysis_unloading_id)->first();

        $data['coal'] = $unloading;
        $data['certificate'] = $this->certificate($certificate);
        
        $data['spesification'] = SpesificationContractCoal::where('contract_id',$unloading->contract_id)->first();
        $data['penalties'] = PenaltyClause::join('unit_penalties','unit_penalties.id','refusal_penalty_clauses.unit_penalty_id')->where('contract_id',$unloading->contract_id)->get();
        return view('coals.receipts.unloading',$data);
    }
    public function analyticLabor($id){

        $labor = CoalUnloading::where('id', $id)->first();
        $certificate = Labor::where('id',$labor->analysis_labor_id)->first();

        $data['coal'] = $labor;
        $data['certificate'] = $this->certificate($certificate);

        $data['spesification'] = SpesificationContractCoal::where('contract_id',$labor->contract_id)->first();
        $data['penalties'] = PenaltyClause::join('unit_penalties','unit_penalties.id','refusal_penalty_clauses.unit_penalty_id')->where('contract_id',$labor->contract_id)->get();
        return view('coals.receipts.labor',$data);
    }

    private function certificate($certificate){

        $sulfur_db = ($certificate->total_sulfur * 100) / (100 - $certificate->moisture_total);
                
        $total_base = $certificate->cao + $certificate->mgo + $certificate->fe2o3 + $certificate->na2o + $certificate->k2o ;
        
        $total_acid = $certificate->sio2 + $certificate->al2o3 + $certificate->tlo2;
        
        if($total_acid == 0){
            $total_slagging = 0;
            $total_fouling = 0;
        }else{
            $total_slagging = ($total_base / $total_acid ) * $sulfur_db;
            $total_fouling = ($total_base / $total_acid ) * $certificate->na2o;
        }
        
        $check = $certificate->cao + $certificate->mgo;
        
        $slagging_index = $certificate->fe2o3 > $check ?  $total_slagging: '' ;
        $fouling_index = $certificate->fe2o3 > $check ?  $total_fouling: '' ;

        $total_1 = $certificate->fe2o3 + $certificate->cao + $certificate->mgo;

        $total_2 = $certificate->na2o + $certificate->k2o + $total_1;

        $total_3 = $certificate->sio2 + $certificate->al2o3 + $certificate->tlo2 ;

        if ($slagging_index == "") {
            $slagging_potensial = "";
        } elseif ($slagging_index > 2.6) {
            $slagging_potensial = "SEVERE";
        } elseif ($slagging_index > 2) {
            $slagging_potensial = "HIGH";
        } elseif ($slagging_index > 0.6) {
            $slagging_potensial = "MEDIUM";
        } else {
            $slagging_potensial = "LOW";
        }
        
        if ($fouling_index == "") {
            $fouling_potensial = "";
        } elseif ($fouling_index > 2.6) {
            $fouling_potensial = "SEVERE";
        } elseif ($fouling_index > 2) {
            $fouling_potensial = "HIGH";
        } elseif ($fouling_index > 0.6) {
            $fouling_potensial = "MEDIUM";
        } else {
            $fouling_potensial = "LOW";
        }

        if ($certificate->fe2o3 > ($check)) {
            $result = "BITUMINOUS";
        } elseif ($certificate->fe2o3 === "") {
            $result = "";
        } elseif ($certificate->cao === "") {
            $result = "";
        } elseif ($certificate->mgo === "") {
            $result = "";
        } else {
            $result = "LIGNITIC";
        }
        
        $certificate['total_1'] = round($total_1,2);
        $certificate['total_2'] = round($total_2,2);
        $certificate['total_3'] = round($total_3,2);
        $certificate['sulfur_db'] = round($sulfur_db,2);
        $certificate['slagging_index'] = round($slagging_index,2);
        $certificate['fouling_index'] = round($fouling_index,2);
        $certificate['slagging_potensial'] = $slagging_potensial;
        $certificate['fouling_potensial'] = $fouling_potensial;
        $certificate['result'] = $result;

        return  $certificate;
    }
}

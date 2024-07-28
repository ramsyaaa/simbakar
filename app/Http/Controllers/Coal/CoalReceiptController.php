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
use App\Models\UserInspection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
        $data['companies'] = LoadingCompany::all();
        $data['suppliers'] = Supplier::all();
        $data['docks'] = Dock::all();
        $data['ships'] = Ship::all();
        $data['harbors'] = Harbor::all();
        $data['surveyors'] = Surveyor::all();
        $data['transporters'] = Transporter::all();
        $data['agents'] = ShipAgent::all();
        $data['heads'] = HeadWarehouse::all();
        $data['inspections'] = UserInspection::all();
        $data['loadings'] = Loading::all();
        $data['unloadings'] = Unloading::all();
        $data['labors'] = Labor::all();
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
            return redirect(route('coals.receipts.index'))->with('success', 'Penerimaan Batu Bara berhasil di ubah.');
            
        } catch (\ValidationException $th) {
            DB::rollback();

            return redirect()->back()->with('error','Penerimaan Batu Bara gagal di ubah');
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
}

<?php

namespace App\Http\Controllers\Report\Contract;

use Carbon\Carbon;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Models\DeliveryClause;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Supplier;

class CoalRecapitulationController extends Controller
{
    public function index(Request $request)
    {
     
        $data['suppliers'] = Supplier::all();

        if($request->has('supplier_id')){
            if(!$request->has('contract_id')){
                return redirect()->back()->with('danger', 'Nomor kontrak harus di isi');
            }
            $contracts = CoalUnloading::with('dock')->where('supplier_id', $request->get('supplier_id'))
            ->where('contract_id', $request->get('contract_id'))
            ->get();

            $ds = $contracts->sum('ds');
            $bl = $contracts->sum('bl');
            $tug = $contracts->sum('tug_3_accept');

            $contracts->map(function ($item){
                $time1 = Carbon::parse($item->unloading_date);
                $time2 = Carbon::parse($item->end_date);
                
                // Menghitung selisih menit
                $time3 = $time1->diffInMinutes($time2);
                $bongkarTime = $time3 / 60;

                $item->duration_time = number_format($bongkarTime,2);
                return $item;

                });


            $data['contracts']= $contracts;
            $data['numbers'] = CoalContract::where('supplier_id',$request->get('supplier_id'))->get();
            $data['contract_data'] = CoalContract::where('id', $request->get('contract_id'))->where('supplier_id',$request->get('supplier_id'))->first();
            $data['ds']= $ds;
            $data['bl']= $bl;
            $data['tug']= $tug;

        }
        return view('reports.contracts.coal-recapitulation',$data);
    }
}

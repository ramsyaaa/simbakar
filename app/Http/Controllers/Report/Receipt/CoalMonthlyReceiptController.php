<?php

namespace App\Http\Controllers\Report\Receipt;

use App\Dock;
use App\Ship;
use App\Labor;
use App\Loading;
use App\Supplier;
use App\Unloading;
use Carbon\Carbon;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Http\Controllers\Controller;

class CoalMonthlyReceiptController extends Controller
{
    public function index(Request $request)
    {
        $data['suppliers'] = Supplier::all();
        $data['docks'] = Dock::all();
        $data['ships'] = Ship::all();
        if($request->has('supplier_id')){
            $date = explode('-', $request->date);
            if(!$request->has('ship_id')){
                return redirect()->back()->with('danger','Kapal harus di isi!');
            }
            $coal = CoalUnloading::with('ship','dock','supplier')
            ->when($request->supplier_id, function ($query) use ($request) {
                $query->where('supplier_id', $request->supplier_id);
            })
            ->when($request->dock_id, function ($query) use ($request) {
                $query->where('dock_id', $request->dock_id);
            })
            ->when($request->ship_id, function ($query) use ($request) {
                $query->where('ship_id', $request->ship_id);
            })
            ->whereYear('receipt_date',$date[0])
            ->whereMonth('receipt_date',$date[1])
            ->get()
            ->map(function($item){
                $time1 = Carbon::parse($item->unloading_date);
                $time2 = Carbon::parse($item->end_date);
                
                // Menghitung selisih menit
                $time3 = $time1->diffInMinutes($time2);
                $bongkarTime = $time3 / 60;

                $item->duration_time = number_format($bongkarTime,2);
                return $item;
            });
            $data['pemasok'] = Supplier::where('id',$request->get('supplier_id'))->first();
            $data['dermaga'] = Dock::where('id',$request->get('dock_id'))->first();
            $data['coals'] = $coal;
        }
        return view('reports.receipt.coal-monthly',$data);
    }

    
}

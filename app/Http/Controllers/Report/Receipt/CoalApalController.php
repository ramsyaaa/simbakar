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
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CoalApalController extends Controller
{
    public function index(Request $request)
    {   
        $data = [];
        $coals = [];
        if($request->has('year')){
            $getCoals = CoalUnloading::whereYear('receipt_date',$request->year)
            ->get();

            for ($i = 1; $i <= 12 ; $i++){
                $monthData = $getCoals->filter(function ($coal) use ($i) {
                    return \Carbon\Carbon::parse($coal->receipt_date)->month == $i;
                });
            
                // Push the data to the array, or null if no records
                $coals[] = $monthData->isNotEmpty() ? $monthData : null;
            }
            $docksId = $getCoals->unique('dock_id')->pluck('dock_id')->sort()->toArray();
            $docks = Dock::whereIn('id',$docksId)->select('id','name')->orderBy('name','asc')->get();
    
            $data['docks'] = $docks;
            $data['coals'] = $coals;
            $data['getCoals'] = $getCoals;
        }
        return view('reports.receipt.coal-apal',$data);
    }

    
}

<?php

namespace App\Http\Controllers\Report\Unloading;

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
use App\Models\CoalUnloadingDisruption;

class DisruptionDataController extends Controller
{
    public function index(Request $request)
    {
        $data['suppliers'] = Supplier::all();
        if($request->has('supplier_id')){
            $date = explode('-', $request->date);
            $coal = CoalUnloadingDisruption::select(
                'coal_unloading_disruptions.*',
                'coal_unloadings.receipt_date',
                'coal_unloadings.tug_3_accept',
                'ships.name'
            )
            ->join('coal_unloadings','coal_unloadings.id','coal_unloading_disruptions.unloading_id')
            ->join('ships','ships.id','coal_unloadings.ship_id')
            ->whereYear('receipt_date',$date[0])
            ->whereMonth('receipt_date',$date[1])
            ->get()
            ->groupBy('unloading_id')
            ->map(function($groupedItems) {
                // Mapping within each group
                return $groupedItems->map(function($item) {
                    // Perform mapping or transformation on individual items within the group
                    $time1 = Carbon::parse($item->start_disruption_date);
                    $time2 = Carbon::parse($item->end_disruption_date);
                    
                    // Menghitung selisih menit
                    $time3 = $time1->diffInMinutes($time2);
                    $item->minutes = $time3;
                    return $item;
                });
            });
            $data['pemasok'] = Supplier::where('id',$request->get('supplier_id'))->first();
            $data['coals'] = $coal;

        }
        return view('reports.unloading.disruption-data',$data);
    }

    
}

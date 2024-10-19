<?php

namespace App\Http\Controllers\Report\Unloading;

use App\Dock;
use App\Ship;
use App\Labor;
use App\Loading;
use App\Supplier;
use App\Unloading;
use Carbon\Carbon;
use App\Models\TypeShip;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Http\Controllers\Controller;

class CoalUnloadingReportController extends Controller
{
    public function index(Request $request)
    {
        $filterType = $request->filter_type;
        $data['filter_type'] = $filterType;
        $data['docks'] = Dock::all();
        $data['ships'] = Ship::all();
        $data['types'] = TypeShip::all();
        $validFilterTypes = ['month', 'dock','ship'];
        if($request->has('filter_type')){

            $date = explode('-', $request->date);
            switch ($filterType) {


                case 'month':
                   
                    $coals = CoalUnloading::with('ship','supplier','agent','dock')
                    ->whereMonth('receipt_date',$date[1])
                    ->whereYear('receipt_date',$date[0])
                    ->get();
                    $data['coals'] = $coals;
                    
                    break;


                case 'dock':

                    $coals = CoalUnloading::with('ship','supplier','agent','dock')
                    ->join('docks','docks.id','coal_unloadings.dock_id')
                    ->join('ships','ships.id','coal_unloadings.ship_id')
                    ->leftJoin('type_ships','type_ships.uuid','ships.type_ship_uuid')
                    ->where('docks.id',$request->dock_id)
                    ->when($request->type_id, function ($query) use ($request) {
                        $query->where('type_ships.id', $request->type_id);
                    })
                    ->whereMonth('receipt_date',$date[1])
                    ->whereYear('receipt_date',$date[0])
                    ->get();
                   $data['coals'] = $coals;
                   $data['dermaga'] = Dock::where('id',$request->dock_id)->first();
                   break;

                case 'ship':
                    $coals = CoalUnloading::with('ship','supplier','agent','dock')
                    ->join('ships','ships.id','coal_unloadings.ship_id')
                    ->where('ships.id',$request->ship_id)
                    ->whereMonth('receipt_date',$date[1])
                    ->whereYear('receipt_date',$date[0])
                    ->get();
                   $data['coals'] = $coals;
                   $data['kapal'] = Ship::where('id',$request->ship_id)->first();
                   break;
                
            }
        }        

        return view('reports.unloading.coal-unloading-report', $data);
    }
    
}

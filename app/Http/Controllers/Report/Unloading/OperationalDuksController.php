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

class OperationalDuksController extends Controller
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
            $coal = CoalUnloading::with('ship','originHarbor')
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
            ->get();
            $data['pemasok'] = Supplier::where('id',$request->get('supplier_id'))->first();
            $data['dermaga'] = Dock::where('id',$request->get('dock_id'))->first();
            $data['coals'] = $coal;
        }
        return view('reports.unloading.operation-duks',$data);
    }

    
}

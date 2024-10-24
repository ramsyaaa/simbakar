<?php

namespace App\Http\Controllers\Report\CoalQuality;

use App\Ship;
use App\Labor;
use App\Loading;
use App\Supplier;
use App\Surveyor;
use App\Unloading;
use Carbon\Carbon;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Http\Controllers\Controller;

class CoalAllItemController extends Controller
{
    public function index(Request $request)
    {
        $data['suppliers'] = Supplier::all();
        $data['surveyors'] = Surveyor::all();

        if($request->has('supplier_id')){
            $date = explode('-', $request->get('date'));
            $month = $date[1];
            $year = $date[0];

            $coals = CoalUnloading::with('ship','supplier')
            ->whereMonth('receipt_date', $month)
            ->whereYear('receipt_date', $year)
            ->when($request->supplier_id != 0, function ($query) use ($request) {
                $query->where('supplier_id', $request->supplier_id);
            })
            ->get()
            ->map(function($item) use ($request) {

                $item->unloading = Unloading::where('id',$item->analysis_unloading_id)
                ->when($request->surveyor_uuid != 0, function ($query) use ($request) {
                    $query->where('surveyor_uuid', $request->surveyor_uuid);
                })
                ->first();
                $item->loading = Loading::where('id',$item->analysis_loading_id)
                ->when($request->surveyor_uuid != 0, function ($query) use ($request) {
                    $query->where('surveyor_uuid', $request->surveyor_uuid);
                })
                ->first();
                $item->labor = Labor::where('id',$item->analysis_labor_id)->first();

                return $item;
            });
            $data['coals'] = $coals;
            $data['analytic'] = $request->analytic ?? [];
        }
        return view('reports.coal-quality.coal-all-item',$data);
    }

    
}

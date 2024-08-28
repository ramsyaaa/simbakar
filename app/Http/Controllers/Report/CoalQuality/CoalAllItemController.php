<?php

namespace App\Http\Controllers\Report\CoalQuality;

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

class CoalAllItemController extends Controller
{
    public function index(Request $request)
    {
        $data['suppliers'] = Supplier::all();

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
            ->whereNotNull('analysis_loading_id')
            ->whereNotNull('analysis_unloading_id')
            ->whereNotNull('analysis_labor_id')
            ->get()
            ->map(function($item){

                $item->unloading = Unloading::where('id',$item->analysis_unloading_id)->first();
                $item->loading = Loading::where('id',$item->analysis_loading_id)->first();
                $item->labor = Labor::where('id',$item->analysis_labor_id)->first();

                return $item;
            });
            $data['coals'] = $coals;
            $data['analytic'] = $request->analytic ?? [];
        }
        return view('reports.coal-quality.coal-all-item',$data);
    }

    
}

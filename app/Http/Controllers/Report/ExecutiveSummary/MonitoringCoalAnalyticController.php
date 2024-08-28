<?php

namespace App\Http\Controllers\Report\ExecutiveSummary;

use App\Ship;
use App\Labor;
use App\Loading;
use App\BbmUsage;
use App\Supplier;
use App\Unloading;
use Carbon\Carbon;
use App\BbmReceipt;
use App\Models\UnitPenalty;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Http\Controllers\Controller;

class MonitoringCoalAnalyticController extends Controller
{
    public function index(Request $request)
    {

        $filterType = $request->filter_type ?? null;
        $data['suppliers'] = Supplier::all();
        $data['units'] = UnitPenalty::where('is_true',0)->get();
    
        $data['filter_type'] = $filterType;
        if ($request->has('supplier_id')) {
            $parameter = UnitPenalty::where('id',$request->unit_id)->first();
            $data['parameter'] = $parameter;
            $data['numbers'] = CoalContract::all();
            switch ($filterType) {

                case 'kontrak':
                    $coals = CoalUnloading::with('ship','supplier')->where('supplier_id',$request->supplier_id)
                    ->where('contract_id',$request->contract_id)
                    ->whereNotNull('analysis_loading_id')
                    ->whereNotNull('analysis_unloading_id')
                    ->whereNotNull('analysis_labor_id')
                    ->get()
                    ->map(function($item) use ($parameter,$request) {
                        if($request->basis == 'AR'){

                            $unloading = Unloading::select($parameter->unit.' AS parameter')->where('id',$item->analysis_unloading_id)->first();
                            $loading = Loading::select($parameter->unit.' AS parameter')->where('id',$item->analysis_loading_id)->first();
                            $labor = Labor::select($parameter->unit.' AS parameter')->where('id',$item->analysis_labor_id)->first();

                            $item->unloading = $unloading['parameter'];
                            $item->loading = $loading['parameter'];
                            $item->labor = $labor['parameter'];
                        }else{
                            $unloading = Unloading::select($parameter->unit)->where('id',$item->analysis_unloading_id)->first();
                            $loading = Loading::select($parameter->unit)->where('id',$item->analysis_loading_id)->first();
                            $labor = Labor::select($parameter->unit)->where('id',$item->analysis_labor_id)->first();

                            $item->unloading = (100 - $unloading->moisture_total) / (100 - $unloading->air_dried_moisture ) * $unloading[$parameter->unit];
                            $item->loading = (100 - $loading->moisture_total) / (100 - $loading->air_dried_moisture ) * $unloading[$parameter->unit];
                            $item->labor = (100 - $labor->moisture_total) / (100 - $labor->air_dried_moisture ) * $labor[$parameter->unit];
                        }
                        return $item;
                    });

                    $data['coals'] = $coals;
                    $data['contract'] = CoalContract::where('id',$request->contract_id)->first();
                    break;

                case 'tahunan':
                    $coals = CoalUnloading::with('ship','supplier','contract')->where('supplier_id',$request->supplier_id)
                    ->whereYear('receipt_date','>=', $request->start_year)
                    ->whereYear('receipt_date','<=', $request->end_year)
                    ->whereNotNull('analysis_loading_id')
                    ->whereNotNull('analysis_unloading_id')
                    ->whereNotNull('analysis_labor_id')
                    ->get()
                    ->map(function($item) use ($parameter,$request) {
                        if($request->basis == 'AR'){

                            $unloading = Unloading::select($parameter->unit.' AS parameter')->where('id',$item->analysis_unloading_id)->first();
                            $loading = Loading::select($parameter->unit.' AS parameter')->where('id',$item->analysis_loading_id)->first();
                            $labor = Labor::select($parameter->unit.' AS parameter')->where('id',$item->analysis_labor_id)->first();

                            $item->unloading = $unloading['parameter'];
                            $item->loading = $loading['parameter'];
                            $item->labor = $labor['parameter'];
                        }else{
                            $unloading = Unloading::select($parameter->unit)->where('id',$item->analysis_unloading_id)->first();
                            $loading = Loading::select($parameter->unit)->where('id',$item->analysis_loading_id)->first();
                            $labor = Labor::select($parameter->unit)->where('id',$item->analysis_labor_id)->first();

                            $item->unloading = (100 - $unloading->moisture_total) / (100 - $unloading->air_dried_moisture ) * $unloading[$parameter->unit];
                            $item->loading = (100 - $loading->moisture_total) / (100 - $loading->air_dried_moisture ) * $unloading[$parameter->unit];
                            $item->labor = (100 - $labor->moisture_total) / (100 - $labor->air_dried_moisture ) * $labor[$parameter->unit];
                        }
                        return $item;
                    });
                    $data['coals'] = $coals;
                    break;


                case 'periodik':
                    $monthStart = explode('-', $request->month_start);
                    $monthEnd = explode('-', $request->month_end);
                    $startDate = "{$monthStart[0]}-{$monthStart[1]}-01";
                    $endDate = "{$monthEnd[0]}-{$monthEnd[1]}-".date('t', strtotime($request->month_end));
                    $coals = CoalUnloading::with('ship','supplier','contract')->where('supplier_id',$request->supplier_id)
                    ->whereBetween('receipt_date', [$startDate, $endDate])
                    ->whereNotNull('analysis_loading_id')
                    ->whereNotNull('analysis_unloading_id')
                    ->whereNotNull('analysis_labor_id')
                    ->get()
                    ->map(function($item) use ($parameter,$request) {
                        if($request->basis == 'AR'){

                            $unloading = Unloading::select($parameter->unit.' AS parameter')->where('id',$item->analysis_unloading_id)->first();
                            $loading = Loading::select($parameter->unit.' AS parameter')->where('id',$item->analysis_loading_id)->first();
                            $labor = Labor::select($parameter->unit.' AS parameter')->where('id',$item->analysis_labor_id)->first();

                            $item->unloading = $unloading['parameter'];
                            $item->loading = $loading['parameter'];
                            $item->labor = $labor['parameter'];
                        }else{
                            $unloading = Unloading::select($parameter->unit)->where('id',$item->analysis_unloading_id)->first();
                            $loading = Loading::select($parameter->unit)->where('id',$item->analysis_loading_id)->first();
                            $labor = Labor::select($parameter->unit)->where('id',$item->analysis_labor_id)->first();

                            $item->unloading = (100 - $unloading->moisture_total) / (100 - $unloading->air_dried_moisture ) * $unloading[$parameter->unit];
                            $item->loading = (100 - $loading->moisture_total) / (100 - $loading->air_dried_moisture ) * $unloading[$parameter->unit];
                            $item->labor = (100 - $labor->moisture_total) / (100 - $labor->air_dried_moisture ) * $labor[$parameter->unit];
                        }
                        return $item;
                    });
                    $data['coals'] = $coals;
                    break;
            }
        }

        return view('reports.executive-summary.monitoring-coal-analytic',$data);
    }
}

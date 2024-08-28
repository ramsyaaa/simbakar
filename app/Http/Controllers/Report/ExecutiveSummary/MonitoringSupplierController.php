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

class MonitoringSupplierController extends Controller
{
    public function index(Request $request)
    {

        $filterType = $request->filter_type ?? null;
        $data['suppliers'] = Supplier::all();
        $data['units'] = UnitPenalty::where('is_true',0)->get();
        $data['filter_type'] = $filterType;
        $bulanTahun = $request->input('bulan_tahun', date('Y-m'));
        list($tahun, $bulan) = explode('-', $bulanTahun);
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $tahunInput = $request->input('tahun', date('Y'));
        $data['tahunInput'] = $tahunInput;
        $startYear = $request->input('start_year', date('Y'));
        $data['start_year'] = $startYear;
        $endYear = $request->input('end_year', date('Y'));
        $data['end_year'] = $endYear;
        $data['analytic'] = $request->analytic ?? [];
        $monthNames = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
        if ($request->has('supplier_id')) {
            $data['pemasok'] = Supplier::where('id',$request->supplier_id)->first();
            $parameter = UnitPenalty::where('id',$request->unit_id)->first();
            $data['parameter'] = $parameter;
            $data['numbers'] = CoalContract::all();
            switch ($filterType) {

                case 'day':
                    $coals = CoalUnloading::with('ship')->where('supplier_id',$request->supplier_id)->whereMonth('unloading_date',$bulan)
                    ->whereYear('unloading_date',$tahun)
                    ->whereNotNull('analysis_loading_id')
                    ->whereNotNull('analysis_unloading_id')
                    ->whereNotNull('analysis_labor_id')
                    ->get()
                    ->map(function($item) use ($parameter,$request){
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
                        $item->origin = Loading::select('origin_of_goods')->where('id',$item->analysis_loading_id)->first();
                        return $item;
                    });

                    $data['coals'] = $coals;
                
                    break;

                case 'month':
                    $coals = [];
                    for ($i = 1; $i <=12 ; $i++){
                        $coal = CoalUnloading::where('supplier_id',$request->supplier_id)
                        ->whereMonth('unloading_date',$i)
                        ->whereYear('unloading_date',$tahunInput)
                        ->whereNotNull('analysis_loading_id')
                        ->whereNotNull('analysis_unloading_id')
                        ->whereNotNull('analysis_labor_id')
                        ->get()
                        ->map(function($item) use ($parameter,$request){
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
                        if(!empty($coal)){
                            $coals [] = [
                                'month' => $monthNames[$i],
                                'tug_3_accept' => $coal->sum('tug_3_accept') ?? 0,
                                'unloading' => $coal->pluck('unloading')->avg() ?? null,
                                'loading' => $coal->pluck('loading')->avg() ?? null,
                                'labor' => $coal->pluck('labor')->avg() ?? null
                            ];
                        }else{
                            $coals [] = [
                                'month' => $monthNames[$i],
                                'tug_3_accept' => 0,
                                'unloading' => null,
                                'loading' => null,
                                'labor' =>  null,
                            ];
                        }
                    }
                    $data['coals'] = $coals;
                    break;


                case 'year':
                    $coals = [];
                    for ($i = $startYear; $i <=$endYear ; $i++){
                        $coal = CoalUnloading::where('supplier_id',$request->supplier_id)
                        ->whereYear('unloading_date',$i)
                        ->whereNotNull('analysis_loading_id')
                        ->whereNotNull('analysis_unloading_id')
                        ->whereNotNull('analysis_labor_id')
                        ->get()
                        ->map(function($item) use ($parameter,$request){
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
                        if(!empty($coal)){
        
                            $coals [] = [
                                'month' => $i,
                                'tug_3_accept' => $coal->sum('tug_3_accept') ?? 0,
                                'unloading' => $coal->pluck('unloading')->avg() ?? null,
                                'loading' => $coal->pluck('loading')->avg() ?? null,
                                'labor' => $coal->pluck('labor')->avg() ?? null
                            ];
                        }else{
                            $coals [] = [
                                'month' => $i,
                                'tug_3_accept' => 0,
                                'unloading' => null,
                                'loading' => null,
                                'labor' =>  null,
                            ];
                        }
                    }
                    $data['coals'] = $coals;
                
                    break;
            }
        }

        return view('reports.executive-summary.coal-calor-supplier',$data);
    }
}

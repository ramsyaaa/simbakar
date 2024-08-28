<?php

namespace App\Http\Controllers\Report\CoalQuality;

use App\Ship;
use App\Labor;
use App\Loading;
use App\BbmUsage;
use App\Supplier;
use App\Unloading;
use Carbon\Carbon;
use App\BbmReceipt;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Http\Controllers\Controller;

class CoalCalorMonthlyController extends Controller
{
    public function index(Request $request)
    {

        $filterType = $request->filter_type ?? null;

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
        $monthNames = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
    
        $data['analytic'] = $request->analytic ?? [];
        $data['filter_type'] = $filterType;
        switch ($filterType) {

            case 'day':
                $coals = CoalUnloading::with('ship','supplier')->whereMonth('unloading_date',$bulan)
                ->whereYear('unloading_date',$tahun)
                ->whereNotNull('analysis_loading_id')
                ->whereNotNull('analysis_unloading_id')
                ->whereNotNull('analysis_labor_id')
                ->get()
                ->map(function($item){
                    $item->unloading = Unloading::select('calorivic_value','moisture_total')->where('id',$item->analysis_unloading_id)->first();
                    $item->loading = Loading::select('calorivic_value','moisture_total')->where('id',$item->analysis_loading_id)->first();
                    $item->labor = Labor::select('calorivic_value','moisture_total')->where('id',$item->analysis_labor_id)->first();
                    return $item;
                });

                $data['coals'] = $coals;
               
                break;

            case 'month':
                $coals = [];
                for ($i = 1; $i <=12 ; $i++){
                    $coal = CoalUnloading::whereMonth('unloading_date',$i)
                    ->whereYear('unloading_date',$tahunInput)
                    ->whereNotNull('analysis_loading_id')
                    ->whereNotNull('analysis_unloading_id')
                    ->whereNotNull('analysis_labor_id')
                    ->get()
                    ->map(function($item){
                        $item->unloading = Unloading::select('calorivic_value','moisture_total')->where('id',$item->analysis_unloading_id)->first();
                        $item->loading = Loading::select('calorivic_value','moisture_total')->where('id',$item->analysis_loading_id)->first();
                        $item->labor = Labor::select('calorivic_value','moisture_total')->where('id',$item->analysis_labor_id)->first();
                        return $item;
                    });
                    if(!empty($coal)){
                        $coals [] = [
                            'month' => $monthNames[$i],
                            'tug_3_accept' => $coal->sum('tug_3_accept') ?? 0,
                            'unloading_calor' => $coal->pluck('unloading.calorivic_value')->avg() ?? 0,
                            'loading_calor' => $coal->pluck('loading.calorivic_value')->avg() ?? 0,
                            'labor_calor' => $coal->pluck('labor.calorivic_value')->avg() ?? 0,
                            'unloading_moisture' => $coal->pluck('unloading.moisture_total')->avg() ?? 0,
                            'loading_moisture' => $coal->pluck('loading.moisture_total')->avg() ?? 0,
                            'labor_moisture' => $coal->pluck('labor.moisture_total')->avg() ?? 0,
                        ];
                    }else{
                        $coals [] = [
                            'month' => $monthNames[$i],
                            'tug_3_accept' => 0,
                            'unloading_calor' => 0,
                            'loading_calor' => 0,
                            'labor_calor' =>  0,
                            'unloading_moisture' => 0,
                            'loading_moisture' =>  0,
                            'labor_moisture' =>  0
                        ];
                    }
                }
                $data['coals'] = $coals;
                break;


            case 'year':
                $coals = [];
                for ($i = $startYear; $i <=$endYear ; $i++){
                    $coal = CoalUnloading::whereYear('unloading_date',$i)
                    ->whereNotNull('analysis_loading_id')
                    ->whereNotNull('analysis_unloading_id')
                    ->whereNotNull('analysis_labor_id')
                    ->get()
                    ->map(function($item){
                        $item->unloading = Unloading::select('calorivic_value','moisture_total')->where('id',$item->analysis_unloading_id)->first();
                        $item->loading = Loading::select('calorivic_value','moisture_total')->where('id',$item->analysis_loading_id)->first();
                        $item->labor = Labor::select('calorivic_value','moisture_total')->where('id',$item->analysis_labor_id)->first();
                        return $item;
                    });
                    if(!empty($coal)){
      
                        $coals [] = [
                            'month' => $i,
                            'tug_3_accept' => $coal->sum('tug_3_accept') ?? 0,
                            'unloading_calor' => $coal->pluck('unloading.calorivic_value')->avg() ?? 0,
                            'loading_calor' => $coal->pluck('loading.calorivic_value')->avg() ?? 0,
                            'labor_calor' => $coal->pluck('labor.calorivic_value')->avg() ?? 0,
                            'unloading_moisture' => $coal->pluck('unloading.moisture_total')->avg() ?? 0,
                            'loading_moisture' => $coal->pluck('loading.moisture_total')->avg() ?? 0,
                            'labor_moisture' => $coal->pluck('labor.moisture_total')->avg() ?? 0,
                        ];
                    }else{
                        $coals [] = [
                            'month' => $i,
                            'tug_3_accept' => 0,
                            'unloading_calor' => 0,
                            'loading_calor' => 0,
                            'labor_calor' =>  0,
                            'unloading_moisture' => 0,
                            'loading_moisture' =>  0,
                            'labor_moisture' =>  0
                        ];
                    }
                }
                $data['coals'] = $coals;
               
                break;
        }
        return view('reports.coal-quality.coal-calor-monthly',$data);
    }
}

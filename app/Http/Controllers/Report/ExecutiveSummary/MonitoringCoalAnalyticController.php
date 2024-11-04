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
            $data['pemasok'] = Supplier::where('id',$request->supplier_id)->first();
            $parameter = UnitPenalty::where('id',$request->unit_id)->first();
            $data['parameter'] = $parameter;
            $data['numbers'] = CoalContract::all();
            switch ($filterType) {

                case 'kontrak':
                    $coals = CoalUnloading::with(['ship', 'supplier'])
                    ->where('supplier_id', $request->supplier_id)
                    ->where('contract_id', $request->contract_id)
                    // ->whereNotNull('analysis_loading_id')
                    // ->whereNotNull('analysis_unloading_id')
                    // ->whereNotNull('analysis_labor_id')
                    ->orderBy('end_date','asc')->get();
                
                    // Step 2: Collect all relevant analysis IDs to batch query related data
                    $unloadingIds = $coals->pluck('analysis_unloading_id')->unique();
                    $loadingIds = $coals->pluck('analysis_loading_id')->unique();
                    $laborIds = $coals->pluck('analysis_labor_id')->unique();
                    
                    // Step 3: Batch fetch all necessary analysis data in one go
                    $unloadings = Unloading::whereIn('id', $unloadingIds)->get()->keyBy('id');
                    $loadings = Loading::whereIn('id', $loadingIds)->get()->keyBy('id');
                    $labors = Labor::whereIn('id', $laborIds)->get()->keyBy('id');
                    
                    // Step 4: Iterate over each item and map the necessary calculations
                    $coals = $coals->map(function($item) use ($parameter, $request, $unloadings, $loadings, $labors) {
                        // Get the corresponding analysis data
                        $unloading = $unloadings->get($item->analysis_unloading_id);
                        $loading = $loadings->get($item->analysis_loading_id);
                        $labor = $labors->get($item->analysis_labor_id);
                    
                        if ($request->basis == 'AR') {
                            // Direct assignment of the parameter values
                            $item->unloading = $unloading->{$parameter->unit} ?? null;
                            $item->loading = $loading->{$parameter->unit} ?? null;
                            $item->labor = $labor->{$parameter->unit} ?? null;
                        } else {
                            // Perform moisture adjustment calculations
                            $item->unloading = isset($unloading) ? (100 - $unloading->moisture_total) / (100 - $unloading->air_dried_moisture) * $unloading->{$parameter->unit} : null;
                            $item->loading = isset($loading) ? (100 - $loading->moisture_total) / (100 - $loading->air_dried_moisture) * $loading->{$parameter->unit} : null;
                            $item->labor = isset($labor) ? (100 - $labor->moisture_total) / (100 - $labor->air_dried_moisture) * $labor->{$parameter->unit} : null;
                        }
                    
                        return $item;
                    });
                    
                    // Step 5: Assign the final results to the data array
                    $data['coals'] = $coals;
                    $data['contract'] = CoalContract::where('id',$request->contract_id)->first();
                    break;

                case 'tahunan':
                    $coals = CoalUnloading::with('ship','supplier','contract')->where('supplier_id',$request->supplier_id)
                    ->whereYear('receipt_date','>=', $request->start_year)
                    ->whereYear('receipt_date','<=', $request->end_year)
                    // ->whereNotNull('analysis_loading_id')
                    // ->whereNotNull('analysis_unloading_id')
                    // ->whereNotNull('analysis_labor_id')
                    ->orderBy('end_date','asc')->get();
                
                    // Step 2: Collect all relevant analysis IDs to batch query related data
                    $unloadingIds = $coals->pluck('analysis_unloading_id')->unique();
                    $loadingIds = $coals->pluck('analysis_loading_id')->unique();
                    $laborIds = $coals->pluck('analysis_labor_id')->unique();
                    
                    // Step 3: Batch fetch all necessary analysis data in one go
                    $unloadings = Unloading::whereIn('id', $unloadingIds)->get()->keyBy('id');
                    $loadings = Loading::whereIn('id', $loadingIds)->get()->keyBy('id');
                    $labors = Labor::whereIn('id', $laborIds)->get()->keyBy('id');
                    
                    // Step 4: Iterate over each item and map the necessary calculations
                    $coals = $coals->map(function($item) use ($parameter, $request, $unloadings, $loadings, $labors) {
                        // Get the corresponding analysis data
                        $unloading = $unloadings->get($item->analysis_unloading_id);
                        $loading = $loadings->get($item->analysis_loading_id);
                        $labor = $labors->get($item->analysis_labor_id);
                    
                        if ($request->basis == 'AR') {
                            // Direct assignment of the parameter values
                            $item->unloading = $unloading->{$parameter->unit} ?? null;
                            $item->loading = $loading->{$parameter->unit} ?? null;
                            $item->labor = $labor->{$parameter->unit} ?? null;
                        } else {
                            // Perform moisture adjustment calculations
                            $item->unloading = isset($unloading) ? (100 - $unloading->moisture_total) / (100 - $unloading->air_dried_moisture) * $unloading->{$parameter->unit} : null;
                            $item->loading = isset($loading) ? (100 - $loading->moisture_total) / (100 - $loading->air_dried_moisture) * $loading->{$parameter->unit} : null;
                            $item->labor = isset($labor) ? (100 - $labor->moisture_total) / (100 - $labor->air_dried_moisture) * $labor->{$parameter->unit} : null;
                        }
                    
                        return $item;
                    });
                    
                    // Step 5: Assign the final results to the data array
                    $data['coals'] = $coals;
                    
                    break;


                case 'periodik':

                    $monthStart = explode('-', $request->month_start);
                    $monthEnd = explode('-', $request->month_end);
                    $startDate = "{$monthStart[0]}-{$monthStart[1]}-01";
                    $endDate = "{$monthEnd[0]}-{$monthEnd[1]}-".date('t', strtotime($request->month_end));
                    $coals = CoalUnloading::with('ship','supplier','contract')->where('supplier_id',$request->supplier_id)
                    ->whereBetween('receipt_date', [$startDate, $endDate])
                    // ->whereNotNull('analysis_loading_id')
                    // ->whereNotNull('analysis_unloading_id')
                    // ->whereNotNull('analysis_labor_id')
                    ->orderBy('end_date','asc')->get();
                
                    // Step 2: Collect all relevant analysis IDs to batch query related data
                    $unloadingIds = $coals->pluck('analysis_unloading_id')->unique();
                    $loadingIds = $coals->pluck('analysis_loading_id')->unique();
                    $laborIds = $coals->pluck('analysis_labor_id')->unique();
                    
                    // Step 3: Batch fetch all necessary analysis data in one go
                    $unloadings = Unloading::whereIn('id', $unloadingIds)->get()->keyBy('id');
                    $loadings = Loading::whereIn('id', $loadingIds)->get()->keyBy('id');
                    $labors = Labor::whereIn('id', $laborIds)->get()->keyBy('id');
                    
                    // Step 4: Iterate over each item and map the necessary calculations
                    $coals = $coals->map(function($item) use ($parameter, $request, $unloadings, $loadings, $labors) {
                        // Get the corresponding analysis data
                        $unloading = $unloadings->get($item->analysis_unloading_id);
                        $loading = $loadings->get($item->analysis_loading_id);
                        $labor = $labors->get($item->analysis_labor_id);
                    
                        if ($request->basis == 'AR') {
                            // Direct assignment of the parameter values
                            $item->unloading = $unloading->{$parameter->unit} ?? null;
                            $item->loading = $loading->{$parameter->unit} ?? null;
                            $item->labor = $labor->{$parameter->unit} ?? null;
                        } else {
                            // Perform moisture adjustment calculations
                            $item->unloading = isset($unloading) ? (100 - $unloading->moisture_total) / (100 - $unloading->air_dried_moisture) * $unloading->{$parameter->unit} : null;
                            $item->loading = isset($loading) ? (100 - $loading->moisture_total) / (100 - $loading->air_dried_moisture) * $loading->{$parameter->unit} : null;
                            $item->labor = isset($labor) ? (100 - $labor->moisture_total) / (100 - $labor->air_dried_moisture) * $labor->{$parameter->unit} : null;
                        }
                    
                        return $item;
                    });
                    
                    // Step 5: Assign the final results to the data array
                    $data['coals'] = $coals;
                    break;
            }
        }

        return view('reports.executive-summary.monitoring-coal-analytic',$data);
    }
}

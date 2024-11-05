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
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MonitoringSupplierController extends Controller
{
    public function index(Request $request)
    {

        $filterType = $request->filter_type ?? null;
        $data['suppliers'] = Supplier::all();
        $data['units'] = UnitPenalty::where('is_true',0)->get();
        $data['filter_type'] = $filterType;
        $bulanTahun = $request->input('bulan_tahun', date('Y-m')) ?? date('Y-m') ;
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
                    $coals = CoalUnloading::with('ship')
                        ->when($request->supplier_id != 0, function ($query) use ($request) {
                            $query->where('supplier_id', $request->supplier_id);
                        })
                        ->whereMonth('receipt_date', $bulan)
                        ->whereYear('receipt_date', $tahun)
                        // ->whereNotNull('analysis_loading_id')
                        // ->whereNotNull('analysis_unloading_id')
                        // ->whereNotNull('analysis_labor_id')
                        ->orderBy('receipt_date','asc')->get();

                    // Collect all related IDs to avoid repeated queries
                    $unloadingIds = $coals->pluck('analysis_unloading_id')->unique();
                    $loadingIds = $coals->pluck('analysis_loading_id')->unique();
                    $laborIds = $coals->pluck('analysis_labor_id')->unique();


                    // Fetch all related data in one go
                    $unloadings = Unloading::whereIn('id', $unloadingIds)->get()->keyBy('id');
                    $loadings = Loading::whereIn('id', $loadingIds)->get()->keyBy('id');
                    $labors = Labor::whereIn('id', $laborIds)->get()->keyBy('id');


                    // Now map the data
                    $coals = $coals->map(function ($item) use ($parameter, $request, $unloadings, $loadings, $labors) {
                        $unloading = $unloadings->get($item->analysis_unloading_id);
                        $loading = $loadings->get($item->analysis_loading_id);
                        $labor = $labors->get($item->analysis_labor_id);

                        if ($request->basis == 'AR') {
                            $item->unloading = $unloading->{$parameter->unit} ?? null;
                            $item->loading = $loading->{$parameter->unit} ?? null;
                            $item->labor = $labor->{$parameter->unit} ?? null;
                        } else {
                            $item->unloading = isset($unloading) ? (100 - $unloading->moisture_total) / (100 - $unloading->air_dried_moisture) * $unloading->{$parameter->unit} : null;
                            $item->loading = isset($loading) ? (100 - $loading->moisture_total) / (100 - $loading->air_dried_moisture) * $loading->{$parameter->unit} : null;
                            $item->labor = isset($labor) ? (100 - $labor->moisture_total) / (100 - $labor->air_dried_moisture) * $labor->{$parameter->unit} : null;
                        }

                        $item->origin = $loading->origin_of_goods ?? '';  // Use already fetched loading data
                        return $item;
                    });

                    $data['coals'] = $coals;
                
                    break;

                case 'month':
                    $coals = [];
                    // Load all the data for the entire year
                    $coalData = CoalUnloading::when($request->supplier_id != 0, function ($query) use ($request) {
                        $query->where('supplier_id', $request->supplier_id);
                    })
                        ->whereYear('receipt_date', $tahunInput)
                        // ->whereNotNull('analysis_loading_id')
                        // ->whereNotNull('analysis_unloading_id')
                        // ->whereNotNull('analysis_labor_id')
                        ->orderBy('receipt_date','asc')->get();
                    
                    // Collect all related IDs to avoid repeated queries
                    $unloadingIds = $coalData->pluck('analysis_unloading_id')->unique();
                    $loadingIds = $coalData->pluck('analysis_loading_id')->unique();
                    $laborIds = $coalData->pluck('analysis_labor_id')->unique();
                    
                    // Fetch all related data in one go
                    $unloadings = Unloading::whereIn('id', $unloadingIds)->get()->keyBy('id');
                    $loadings = Loading::whereIn('id', $loadingIds)->get()->keyBy('id');
                    $labors = Labor::whereIn('id', $laborIds)->get()->keyBy('id');
                    
                    // Iterate over each month
                    for ($i = 1; $i <= 12; $i++) {
                        // Filter data for the current month
                        $coalForMonth = $coalData->filter(function ($item) use ($i) {
                            // Convert receipt_date to Carbon instance if it's not already one
                            $unloadingDate = $item->receipt_date instanceof Carbon ? $item->receipt_date : Carbon::parse($item->receipt_date);
                            return $unloadingDate->month == $i;
                        });
                    
                        // Map data to include the needed values
                        $coalForMonth = $coalForMonth->map(function ($item) use ($parameter, $request, $unloadings, $loadings, $labors) {
                            $unloading = $unloadings->get($item->analysis_unloading_id);
                            $loading = $loadings->get($item->analysis_loading_id);
                            $labor = $labors->get($item->analysis_labor_id);
                    
                            if ($request->basis == 'AR') {
                                $item->unloading = $unloading->{$parameter->unit} ?? null;
                                $item->loading = $loading->{$parameter->unit} ?? null;
                                $item->labor = $labor->{$parameter->unit} ?? null;
                            } else {
                                $item->unloading = isset($unloading) ? (100 - $unloading->moisture_total) / (100 - $unloading->air_dried_moisture) * $unloading->{$parameter->unit} : null;
                                $item->loading = isset($loading) ? (100 - $loading->moisture_total) / (100 - $loading->air_dried_moisture) * $loading->{$parameter->unit} : null;
                                $item->labor = isset($labor) ? (100 - $labor->moisture_total) / (100 - $labor->air_dried_moisture) * $labor->{$parameter->unit} : null;
                            }
                            return $item;
                        });
                    
                        // Prepare the output for each month
                        if ($coalForMonth->isNotEmpty()) {
                            $coals[] = [
                                'month' => $monthNames[$i],
                                'tug_3_accept' => $coalForMonth->sum('tug_3_accept') ?? 0,
                                'unloading' => number_format($coalForMonth->pluck('unloading')->avg(),2) ?? null,
                                'loading' => number_format($coalForMonth->pluck('loading')->avg(),2) ?? null,
                                'labor' => number_format($coalForMonth->pluck('labor')->avg(),2) ?? null
                            ];
                        } else {
                            $coals[] = [
                                'month' => $monthNames[$i],
                                'tug_3_accept' => 0,
                                'unloading' => null,
                                'loading' => null,
                                'labor' => null,
                            ];
                        }
                    }
                    
                    // Set the final data output
                    $data['coals'] = $coals;
                    break;


                case 'year':
                    $coals = [];
                    // Load all coal data for the range of years
                    $coalData = CoalUnloading::when($request->supplier_id != 0, function ($query) use ($request) {
                        $query->where('supplier_id', $request->supplier_id);
                    })
                        ->whereBetween(DB::raw('YEAR(receipt_date)'), [$startYear, $endYear])
                        // ->whereNotNull('analysis_loading_id')
                        // ->whereNotNull('analysis_unloading_id')
                        // ->whereNotNull('analysis_labor_id')
                        ->orderBy('receipt_date','asc')->get();
                    
                    // Collect all related IDs to avoid repeated queries
                    $unloadingIds = $coalData->pluck('analysis_unloading_id')->unique();
                    $loadingIds = $coalData->pluck('analysis_loading_id')->unique();
                    $laborIds = $coalData->pluck('analysis_labor_id')->unique();
                    
                    // Fetch all related data in one go
                    $unloadings = Unloading::whereIn('id', $unloadingIds)->get()->keyBy('id');
                    $loadings = Loading::whereIn('id', $loadingIds)->get()->keyBy('id');
                    $labors = Labor::whereIn('id', $laborIds)->get()->keyBy('id');
                    
                    // Iterate over each year
                    for ($i = $startYear; $i <= $endYear; $i++) {
                        // Filter data for the current year
                        $coalForYear = $coalData->filter(function ($item) use ($i) {
                            return Carbon::parse($item->receipt_date)->year == $i;
                        });
                    
                        // Map data to include the needed values
                        $coalForYear = $coalForYear->map(function ($item) use ($parameter, $request, $unloadings, $loadings, $labors) {
                            $unloading = $unloadings->get($item->analysis_unloading_id);
                            $loading = $loadings->get($item->analysis_loading_id);
                            $labor = $labors->get($item->analysis_labor_id);
                    
                            if ($request->basis == 'AR') {
                                $item->unloading = $unloading->{$parameter->unit} ?? null;
                                $item->loading = $loading->{$parameter->unit} ?? null;
                                $item->labor = $labor->{$parameter->unit} ?? null;
                            } else {
                                $item->unloading = isset($unloading) ? (100 - $unloading->moisture_total) / (100 - $unloading->air_dried_moisture) * $unloading->{$parameter->unit} : null;
                                $item->loading = isset($loading) ? (100 - $loading->moisture_total) / (100 - $loading->air_dried_moisture) * $loading->{$parameter->unit} : null;
                                $item->labor = isset($labor) ? (100 - $labor->moisture_total) / (100 - $labor->air_dried_moisture) * $labor->{$parameter->unit} : null;
                            }
                            return $item;
                        });
                    
                        // Prepare the output for each year
                        if ($coalForYear->isNotEmpty()) {
                            $coals[] = [
                                'month' => $i,  // Changed from 'month' to 'year'
                                'tug_3_accept' => $coalForYear->sum('tug_3_accept') ?? 0,
                                'unloading' => number_format($coalForYear->pluck('unloading')->avg(),2) ?? null,
                                'loading' => number_format($coalForYear->pluck('loading')->avg(),2) ?? null,
                                'labor' => number_format($coalForYear->pluck('labor')->avg(),2) ?? null,
                            ];
                        } else {
                            $coals[] = [
                                'month' => $i,  // Changed from 'month' to 'year'
                                'tug_3_accept' => 0,
                                'unloading' => null,
                                'loading' => null,
                                'labor' => null,
                            ];
                        }
                    }
                    
                    // Set the final data output
                    $data['coals'] = $coals;
                
                    break;
            }
        }

        return view('reports.executive-summary.coal-calor-supplier',$data);
    }
}

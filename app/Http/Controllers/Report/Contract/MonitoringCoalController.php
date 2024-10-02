<?php

namespace App\Http\Controllers\Report\Contract;

use stdClass;
use App\Supplier;
use Carbon\Carbon;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Models\DeliveryClause;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MonitoringCoalController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        if($request->has('year')){

            $beforeYear = $year - 1;

            $contracts = CoalUnloading::join('coal_contracts', 'coal_contracts.id', '=', 'coal_unloadings.contract_id')
                ->join('suppliers', 'suppliers.id', '=', 'coal_contracts.supplier_id')
                ->select(
                    'suppliers.id as supplier_id', 
                    'suppliers.name', 
                    'coal_contracts.contract_number', 
                    'coal_contracts.total_volume'
                )
                ->whereYear('receipt_date', $year)
                ->when($request->type, function ($query) use ($request) {
                    $query->where('coal_contracts.type_contract', $request->type);
                })
                ->get()
                ->groupBy('supplier_id')
                ->map(function($items) use($year, $beforeYear) {
                    $supplierId = $items[0]->supplier_id;
            
                    // Fetching all necessary data in a single query
                    $monthlyData = CoalUnloading::where('supplier_id', $supplierId)
                        ->whereYear('receipt_date', $year)
                        ->selectRaw('MONTH(receipt_date) as month, SUM(tug_3_accept) as total')
                        ->groupBy('month')
                        ->pluck('total', 'month')
                        ->toArray();
            
                    // Calculate the total before the specified year
                    $counting = CoalUnloading::where('supplier_id', $supplierId)
                        ->whereYear('receipt_date', '<=', $beforeYear)
                        ->sum('tug_3_accept');
            
                    // Assign basic data
                    $result = new stdClass();
                    $result->name = $items[0]->name;
                    $result->contract_number = $items[0]->contract_number;
                    $result->total_volume = $items[0]->total_volume;
                    $result->counting = $counting;
                    $result->plan = 0;
            
                    // Prepare monthly data
                    $result->data = [
                        'k' => array_fill(1, 12, 0),
                        'r' => array_fill(1, 12, 0)
                    ];
            
                    // Populate monthly data
                    $realization = 0;
                    for ($i = 1; $i <= 12; $i++) {
                        $result->data['r'][$i] = $monthlyData[$i] ?? 0; // Get the monthly total or 0
                        $realization += $result->data['r'][$i];
                    }
            
                    // Assign realization and deviations
                    $result->realization = $realization;
                    $result->deviasi = $realization; // or your actual deviasi logic
                    $result->deviasi_contract = $counting + $realization;
            
                    return $result;
                });
            
            $data['beforeYear'] = $beforeYear;
            $data['contracts'] = $contracts;
        }
        $data['year'] = $year;
       
            
        return view('reports.contracts.coal-monitoring',$data);
    }
}

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

class CoalAllContractController extends Controller
{
    public function index(Request $request)
    {
        $start_year = $request->input('start_year', date('Y'));
        $end_year = $request->input('end_year', date('Y'));

        if($request->has('start_year')){

            $contracts = CoalUnloading::join('coal_contracts', 'coal_contracts.id', '=', 'coal_unloadings.contract_id')
                ->join('suppliers', 'suppliers.id', '=', 'coal_contracts.supplier_id')
                ->select(
                    'suppliers.name',
                    'coal_contracts.contract_number',
                    'coal_contracts.total_volume',
                    'coal_contracts.contract_end_date',
                    'coal_contracts.supplier_id',
                    'coal_unloadings.contract_id',
                    DB::raw('YEAR(coal_unloadings.receipt_date) as year'),
                    DB::raw('SUM(coal_unloadings.tug_3_accept) as total_data')
                )
                ->whereYear('coal_unloadings.receipt_date', '>=', $start_year)
                ->whereYear('coal_unloadings.receipt_date', '<=', $end_year)
                ->when($request->type, function ($query) use ($request) {
                    $query->where('coal_contracts.type_contract', $request->type);
                })
                ->groupBy('contract_id', 'year', 'suppliers.name', 'coal_contracts.contract_number', 'coal_contracts.total_volume', 'coal_contracts.contract_end_date', 'coal_contracts.supplier_id')
                ->get()
                ->groupBy('contract_id')
                ->map(function($items) use($start_year, $end_year) {
                    $result = new stdClass();
                    
                    // Assign basic data from the first item
                    $firstItem = $items->first();
                    $result->name = $firstItem->name;
                    $result->contract_number = $firstItem->contract_number;
                    $result->total_volume = $firstItem->total_volume;
                    $result->contract_end_date = $firstItem->contract_end_date;

                    // Initialize yearly data
                    $realization = 0;
                    $result->data = ['k' => [], 'r' => [], '%' => [], 'd' => []];
                    for ($i = $start_year; $i <= $end_year; $i++) {
                        $result->data['k'][$i] = 0;
                        $result->data['r'][$i] = 0;
                        $result->data['%'][$i] = 0;
                        $result->data['d'][$i] = 0;
                    }

                    // Aggregate data for each year
                    foreach ($items as $item) {
                        $year = $item->year;
                        $data = $item->total_data;
                        $realization += $data;
                        
                        // Update yearly data
                        $result->data['r'][$year] = $data;
                        $result->data['d'][$year] = $data;
                        $result->data['%'][$year] = $data == 0 ? 0 : 'infinity';  // Adjust logic if needed
                    }

                    // Calculate deviation
                    $deviasi_ton = $realization - $result->total_volume;
                    $result->realization = $realization;
                    $result->deviasi_ton = $deviasi_ton;
                    $result->deviasi_percentage = 0;  // Placeholder for further calculation logic

                    return $result;
                });

            $data['contracts'] = $contracts;
        }
        $data['start_year'] = $start_year;
        $data['end_year'] = $end_year;
       
            
        return view('reports.contracts.coal-all-contract',$data);
    }
}

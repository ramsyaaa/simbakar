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

class CoalReceiptRecapitulationController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y')) ?? date('Y');
        $data['year'] = $year;

        $contracts = CoalUnloading::join('coal_contracts','coal_contracts.id','coal_unloadings.contract_id')
        ->join('suppliers','suppliers.id','coal_contracts.supplier_id')
        ->whereYear('receipt_date', $year)
        ->get()
        ->groupBy('contract_id')
        ->map(function($items) use($year){
            
            $result = new stdClass();

            // Assign basic data
            $result->name = $items[0]->name;
            $result->contract_number = $items[0]->contract_number;
            $result->total_volume = $items[0]->total_volume;
    
            // Assign monthly data
            $result->data = [];
            for ($i = 1; $i <= 12; $i++) {
                $data = CoalUnloading::where('supplier_id', $items[0]->supplier_id)
                    ->whereYear('receipt_date', $year)
                    ->whereMonth('receipt_date', $i)
                    ->sum('tug_3_accept');
                $result->data[$i] = $data;
            }
    
            // Calculate the total sum of the monthly data
            $result->total = array_sum($result->data);
    
            return $result;
        });
        $data['contracts'] = $contracts;
            
        return view('reports.contracts.coal-receipt',$data);
    }
}

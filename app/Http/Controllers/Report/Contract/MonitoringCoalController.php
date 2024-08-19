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

            $beforeYear = $year - 1 ;
            $contracts = CoalUnloading::join('coal_contracts','coal_contracts.id','coal_unloadings.contract_id')
            ->join('suppliers','suppliers.id','coal_contracts.supplier_id')
            ->whereYear('receipt_date', $year)
            ->when($request->type, function ($query) use ($request) {
                $query->where('coal_contracts.type_contract', $request->type);
            })
            ->get()
            ->groupBy('supplier_id')->map(function($items) use($year,$beforeYear){
                $realization = 0;
                $result = new stdClass();
                $counting = CoalUnloading::where('supplier_id', $items[0]->supplier_id)
                ->whereYear('receipt_date','<=', $beforeYear)
                ->sum('tug_3_accept');
                // Assign basic data
                $result->name = $items[0]->name;
                $result->contract_number = $items[0]->contract_number;
                $result->total_volume = $items[0]->total_volume;
                $result->counting = $counting;
                $result->plan = 0;
                
                // Assign monthly data
                $result->data = [];
                for ($i = 1; $i <= 12; $i++) {
                    $result->data['k'][$i] = 0;
                }
                for ($i = 1; $i <= 12; $i++) {
                    $data = CoalUnloading::where('supplier_id', $items[0]->supplier_id)
                    ->whereYear('receipt_date', $year)
                    ->whereMonth('receipt_date', $i)
                    ->sum('tug_3_accept');
                    
                    $realization = $data + $realization;   
                    $result->data['r'][$i] = $data;
                }
                
                // Calculate the total sum of the monthly data
                $result->realization = $realization;         
                $result->deviasi = $realization;   
                $result->deviasi_contract = $counting + $realization ;      
                return $result;
            });
            $data['beforeYear'] = $beforeYear;
            $data['contracts'] = $contracts;
        }
        $data['year'] = $year;
       
            
        return view('reports.contracts.coal-monitoring',$data);
    }
}

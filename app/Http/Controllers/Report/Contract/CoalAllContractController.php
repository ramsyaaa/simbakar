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

            $contracts = CoalUnloading::join('coal_contracts','coal_contracts.id','coal_unloadings.contract_id')
            ->join('suppliers','suppliers.id','coal_contracts.supplier_id')
            ->whereYear('receipt_date','>=', $start_year)
            ->whereYear('receipt_date','<=', $end_year)
            ->when($request->type, function ($query) use ($request) {
                $query->where('coal_contracts.type_contract', $request->type);
            })
            ->get()
            ->groupBy('contract_id')->map(function($items) use($start_year,$end_year){

                $realization = 0;
                $result = new stdClass();
                // Assign basic data
                $result->name = $items[0]->name;
                $result->contract_number = $items[0]->contract_number;
                $result->total_volume = $items[0]->total_volume;                
                $result->contract_end_date = $items[0]->contract_end_date;                
                // Assign monthly data
                $result->data = [];
                for ($i = $start_year; $i <= $end_year; $i++) {
                    $result->data['k'][$i] = 0;
                }
                for ($i = $start_year; $i <= $end_year; $i++) {

                    $data = CoalUnloading::where('supplier_id', $items[0]->supplier_id)
                    ->whereYear('receipt_date', $i)
                    ->sum('tug_3_accept');    
                    $percentage =  $data == 0 ? 0 : 'infinity';
                    $realization = $data + $realization;   
                    $result->data['r'][$i] = $data;
                    $result->data['%'][$i] = $percentage;
                    $result->data['d'][$i] = $data;

                }
                $deviasi_ton = $realization - $items[0]->total_volume;
                // Calculate the total sum of the monthly data
                $deviasi_percentage = 0;
                $result->realization = $realization;         
                $result->deviasi_ton = $deviasi_ton;   
                $result->deviasi_percentage = $deviasi_percentage ;      
                return $result;
            });
            $data['contracts'] = $contracts;
        }
        $data['start_year'] = $start_year;
        $data['end_year'] = $end_year;
       
            
        return view('reports.contracts.coal-all-contract',$data);
    }
}

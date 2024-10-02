<?php

namespace App\Http\Controllers\Report\Contract;

use Carbon\Carbon;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Models\DeliveryClause;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Supplier;

class SpotMonthlyController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        if($request->has('year')){
            $data['year'] = $year;

            $value = [];
            $monthNames = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];

            // Ambil data dari query
            $contracts = CoalUnloading::join('suppliers', 'suppliers.id', '=', 'coal_unloadings.supplier_id')
            ->join('coal_contracts', 'coal_contracts.supplier_id', '=', 'suppliers.id')
            ->when($request->supplier != 0, function ($query) use ($request) {
                $query->where('suppliers.id', $request->supplier);
            })
            ->whereYear('coal_unloadings.receipt_date', $year)
            ->select(DB::raw('MONTH(coal_unloadings.receipt_date) as month'), 'coal_unloadings.*', 'suppliers.name as supplier_name', 'coal_contracts.contract_number');

            for ($i = 1; $i <= 12; $i++) {
                // Clone the original query to avoid modifying it in each loop
                $monthly = (clone $contracts)->whereMonth('coal_unloadings.receipt_date', $i)->get();
            
                $dataValue = [
                    'month' => $monthNames[$i],
                    'plan_kontrak' => '', // Assuming these values are to be filled later
                    'adendum_kontrak' => '',
                    'ton' => $monthly->sum('tug_3_accept'),
                    '%' => '-', // Assuming a calculation is to be done later
                    'plan_realisasi' => $monthly->sum('tug_3_accept'),
                    'adendum_realisasi' => $monthly->sum('tug_3_accept')
                ];
            
                $value[] = $dataValue;
            }
            $data['name'] = Supplier::where('id',$request->supplier)->first();
            $data['contracts'] = $value;
        }
        
        $data['suppliers'] = Supplier::all();
            
        return view('reports.contracts.coal-monthly-spot',$data);
    }
}

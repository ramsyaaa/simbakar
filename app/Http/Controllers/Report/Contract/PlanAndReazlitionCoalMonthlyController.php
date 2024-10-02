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

class PlanAndReazlitionCoalMonthlyController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $data['year'] = $year;
        if($request->has('year')) {
            

            $contractPlan = DeliveryClause::join('coal_contracts','coal_contracts.id','delivery_clauses.contract_id')
            ->join('suppliers','suppliers.id','coal_contracts.supplier_id')
            ->when($request->type, function ($query) use ($request) {
                $query->where('coal_contracts.type_contract', $request->type);
            })
            ->where('delivery_clauses.year', $year)
            ->get()
            ->groupBy('contract_id')->map(function($items){
                // Define an array for all 12 months with names as keys and default value of 0
                $months = collect(range(1, 12))->mapWithKeys(function ($month) {
                    $monthName = Carbon::createFromFormat('m', $month)->format('F'); // Get full month name
                    return [$monthName => 0]; // Initialize with 0
                });
                // Group items by month name and sum the amounts
                $groupedByMonth = $items->groupBy(function ($item) {
                    return Carbon::parse(Carbon::create()->month($item->month))->format('F'); // Group by full month name
                })->map(function ($monthItems) {
                    $valuePlan =[
                        'kontrak' => 0,
                        'rakor' => $monthItems->sum('rakor')
                    ];
                    return $valuePlan;
                });

                // Merge existing months with the grouped items
                $mergedData = $months->merge($groupedByMonth);

                return $mergedData->map(function ($value) {
                    return $value === 0 ? [
                        'kontrak' => 0,
                        'rakor' => 0
                    ] : $value;
                });
            });
            $contractsReal = CoalUnloading::join('suppliers','suppliers.id','coal_unloadings.supplier_id')
            ->join('coal_contracts','coal_contracts.supplier_id','suppliers.id')
            ->when($request->type, function ($query) use ($request) {
                $query->where('coal_contracts.type_contract', $request->type);
            })
            ->whereYear('receipt_date', $year)
            ->get()
            ->groupBy('contract_id')->map(function($items){
                // Define an array for all 12 months with names as keys and default value of 0
                $months = collect(range(1, 12))->mapWithKeys(function ($month) {
                    $monthName = Carbon::createFromFormat('m', $month)->format('F'); // Get full month name
                    return [$monthName => 0]; // Initialize with 0
                });

                // Group items by month name and sum the amounts
                $groupedByMonth = $items->groupBy(function ($item) {
                    return Carbon::parse($item->receipt_date)->format('F'); // Group by full month name
                })->map(function ($monthItems) {

                    $valueReal =[
                        'ton' => $monthItems->sum('tug_3_accept'),
                        '%' => 'infinity'
                    ];
                    return $valueReal;
                });
                // Merge existing months with the summed data, overwriting the 0s with actual sums
                // Merge existing months with the grouped items
                $mergedData = $months->merge($groupedByMonth);

                return $mergedData->map(function ($value) {
                    return $value === 0 ? [
                        'ton' => 0,
                        '%' => 'infinity'
                    ] : $value;
                });
            });
            $combinedData = $contractPlan->union($contractsReal)->map(function ($planData, $supplierId) use ($contractsReal) {

            $realData = $contractsReal->get($supplierId, collect());

            // Combine both plan and real data, ensuring all months are included
            $allMonths = $planData->keys()->union($realData->keys());

            return $allMonths->mapWithKeys(function ($month) use ($planData, $realData) {
                // Ensure default values are used if keys are missing
                $planMonthData = $planData->get($month, [
                    'kontrak' => 0,
                    'rakor' => 0
                ]);

                $realMonthData = $realData->get($month, [
                    'ton' => 0,
                    '%' => 'infinity'
                ]);

                return [$month => [
                    'kontrak' => $planMonthData['kontrak'] ?? 0,
                    'rakor' => $planMonthData['rakor'] ?? 0,
                    'ton' => $realMonthData['ton'] ?? 0,
                    '%' => $realMonthData['%'] ?? 'infinity',
                    ]];
                });
            });


            // Get the necessary details for formatting keys
            $supplierContractDetails = Supplier::join('coal_contracts', 'suppliers.id', 'coal_contracts.supplier_id')
                ->select('suppliers.id as supplier_id as id ','coal_contracts.id as contract_id', 'suppliers.name as supplier_name', 'coal_contracts.contract_number', 'coal_contracts.contract_start_date','coal_contracts.contract_end_date')
                ->whereIn('coal_contracts.id', $combinedData->keys()->toArray())
                ->get()
                ->mapWithKeys(function ($item) {
                    $key = "{$item->supplier_name} {$item->contract_number} {$item->contract_start_date} s/d {$item->contract_end_date}";
                    return [$item->contract_id => $key];
                });

            // Replace contract_id keys with formatted names
            $combinedData = $combinedData->mapWithKeys(function ($data, $contractId) use ($supplierContractDetails) {
                $formattedKey = $supplierContractDetails->get($contractId, 'Unknown Contract');
                return [$formattedKey => $data];
            });
            // Output the combined result

            $data['contracts'] = $combinedData;
        }
        return view('reports.contracts.coal-monthly',$data);
    }
}

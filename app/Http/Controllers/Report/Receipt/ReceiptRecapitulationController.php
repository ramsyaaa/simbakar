<?php

namespace App\Http\Controllers\Report\Receipt;

use stdClass;
use App\BbmReceipt;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Http\Controllers\Controller;

class ReceiptRecapitulationController extends Controller
{

    public function index(Request $request)
    {
        $filterType = $request->filter_type;
        $data['filter_type'] = $filterType;
        $validFilterTypes = ['day', 'month', 'year'];
        if($request->has('filter_type')){

            switch ($filterType) {
                case 'day':

                    $bulanTahun = $request->input('bulan_tahun', date('Y-m'));
                    list($tahun, $bulan) = explode('-', $bulanTahun);
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                    
                    $contracts = CoalUnloading::join('coal_contracts','coal_contracts.id','coal_unloadings.contract_id')
                    ->join('suppliers','suppliers.id','coal_contracts.supplier_id')
                    ->whereMonth('receipt_date', $bulan)
                    ->whereYear('receipt_date', $tahun)
                    ->get()
                    ->groupBy('contract_id')
                    ->map(function($items) use($tahun,$bulan,$daysInMonth){
                        
                        $result = new stdClass();
            
                        // Assign basic data
                        $result->name = $items[0]->name;
                        $result->contract_number = $items[0]->contract_number;
                        $result->total_volume = $items[0]->total_volume;
                
                        // Assign monthly data
                        $result->data = [];
                        for ($day = 1; $day <= $daysInMonth; $day++) {

                            $date = sprintf('%04d-%02d-%02d', $tahun, $bulan, $day);
                            $data = CoalUnloading::where('supplier_id', $items[0]->supplier_id)
                                ->where('receipt_date', $date)
                                ->sum('tug_3_accept');

                            $result->data[$day] = $data;
                        }
                
                        // Calculate the total sum of the monthly data
                        $result->total = array_sum($result->data);
                
                        return $result;
                    });
                                    // Initialize an empty array to hold the sum of each index
                    $sumData = array_fill(1, $daysInMonth, 0); // Assuming we have 31 indices
                    $totalSum = 0;
                    // Loop through each supplier's data and sum the values at each index
                    foreach ($contracts as $contract) {
                        $totalSum += $contract->total;
                        foreach ($contract->data as $index => $value) {
                            $sumData[$index] += (int)$value; // Ensure value is cast to int for summation
                        }
                    }
                    $data['contracts'] = $contracts;
                    $data['sumDatas'] = $sumData;
                    $data['totalSum'] = $totalSum;
                    $data['days'] = $daysInMonth;
                    break;

                case 'month':
                    $tahunInput = $request->input('tahun', date('Y'));
                
                    $contracts = CoalUnloading::join('coal_contracts','coal_contracts.id','coal_unloadings.contract_id')
                        ->join('suppliers','suppliers.id','coal_contracts.supplier_id')
                        ->whereYear('receipt_date', $tahunInput)
                        ->get()
                        ->groupBy('contract_id')
                        ->map(function($items) use($tahunInput){
                            
                            $result = new stdClass();

                            // Assign basic data
                            $result->name = $items[0]->name;
                            $result->contract_number = $items[0]->contract_number;
                            $result->total_volume = $items[0]->total_volume;
                    
                            // Assign monthly data
                            $result->data = [];
                            for ($i = 1; $i <= 12; $i++) {
                                $data = CoalUnloading::where('supplier_id', $items[0]->supplier_id)
                                    ->whereYear('receipt_date', $tahunInput)
                                    ->whereMonth('receipt_date', $i)
                                    ->sum('tug_3_accept');
                                $result->data[$i] = $data;
                            }
                    
                            // Calculate the total sum of the monthly data
                            $result->total = array_sum($result->data);
                    
                            return $result;
                        });
                        $sumData = array_fill(1, 12, 0); // Assuming we have 31 indices

                        $totalSum = 0;
                        // Loop through each supplier's data and sum the values at each index
                        foreach ($contracts as $contract) {
                            $totalSum += $contract->total;
                            foreach ($contract->data as $index => $value) {
                                $sumData[$index] += (int)$value; // Ensure value is cast to int for summation
                            }
                        }
                        $data['contracts'] = $contracts;
                        $data['sumDatas'] = $sumData;
                        $data['totalSum'] = $totalSum;
                    break;


                case 'year':

                    $startYear = $request->input('start_year', date('Y'));
                    $endYear = $request->input('end_year', date('Y'));

                    $contracts = CoalUnloading::join('coal_contracts','coal_contracts.id','coal_unloadings.contract_id')
                        ->join('suppliers','suppliers.id','coal_contracts.supplier_id')
                        ->whereYear('receipt_date','>=', $startYear)
                        ->whereYear('receipt_date','<=', $endYear)
                        ->get()
                        ->groupBy('contract_id')
                        ->map(function($items) use($startYear, $endYear) {
                            
                            $result = new stdClass();

                            // Assign basic data
                            $result->name = $items[0]->name;
                            $result->contract_number = $items[0]->contract_number;
                            $result->total_volume = $items[0]->total_volume;
                    
                            // Assign monthly data
                            $result->data = [];
                            for ($year = $startYear; $year <= $endYear; $year++) {
                                $data = CoalUnloading::where('supplier_id', $items[0]->supplier_id)
                                    ->whereYear('receipt_date', $year)
                                    ->sum('tug_3_accept');
                                $result->data[$year] = $data;
                            }
                    
                            // Calculate the total sum of the monthly data
                            $result->total = array_sum($result->data);
                    
                            return $result;
                        });
                        $minYear = $endYear - $startYear + 1;
                        $sumData = array_fill($startYear, $minYear, 0); // Assuming we have 31 indices

                        $totalSum = 0;
                        // Loop through each supplier's data and sum the values at each index
                        foreach ($contracts as $contract) {
                            $totalSum += $contract->total;
                            foreach ($contract->data as $index => $value) {
                                $sumData[$index] += (int)$value; // Ensure value is cast to int for summation
                            }
                        }

                        $data['contracts'] = $contracts;
                        $data['sumDatas'] = $sumData;
                        $data['totalSum'] = $totalSum;
                        $data['minYear'] = $minYear;

                    break;
                
            }
            // dd($data);
        }        

        return view('reports.receipt.coal-recapitulation', $data);
    }
}

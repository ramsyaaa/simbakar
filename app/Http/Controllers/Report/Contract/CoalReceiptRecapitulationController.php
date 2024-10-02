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
        if($request->has('year')){

            // Mengambil semua data dalam satu query untuk mengurangi beban query berulang
            $contracts = CoalUnloading::select(
                'coal_contracts.id as contract_id',
                'coal_contracts.contract_number',
                'suppliers.name',
                'coal_contracts.total_volume',
                DB::raw('MONTH(receipt_date) as bulan'),
                DB::raw('SUM(tug_3_accept) as total_per_bulan')
            )
            ->join('coal_contracts', 'coal_contracts.id', '=', 'coal_unloadings.contract_id')
            ->join('suppliers', 'suppliers.id', '=', 'coal_contracts.supplier_id')
            ->whereYear('receipt_date', '=', $year)
            ->groupBy('coal_contracts.id', 'coal_contracts.contract_number', 'suppliers.name', 'coal_contracts.total_volume', 'bulan') // Tambahkan semua kolom non-agregat di sini
            ->get()
            ->groupBy('contract_id');

            // Memproses data hasil query untuk mengelompokkan per kontrak
            $processedContracts = $contracts->map(function($items) {
                $result = new stdClass();

                // Assign basic data
                $firstItem = $items->first();
                $result->name = $firstItem->name;
                $result->contract_number = $firstItem->contract_number;
                $result->total_volume = $firstItem->total_volume;

                // Assign monthly data (Jan = 1, Dec = 12)
                $result->data = array_fill(1, 12, 0); // Inisialisasi data per bulan
                foreach ($items as $item) {
                    $result->data[$item->bulan] = (int)$item->total_per_bulan;
                }

                // Calculate the total sum of the monthly data
                $result->total = array_sum($result->data);

                return $result;
            });

            // Inisialisasi sumData untuk setiap bulan (Jan = 1, Dec = 12)
            $sumData = array_fill(1, 12, 0);
            $totalSum = 0;

            // Loop melalui setiap kontrak untuk menghitung total bulanan dan total keseluruhan
            foreach ($processedContracts as $contract) {
                $totalSum += $contract->total;
                foreach ($contract->data as $index => $value) {
                    $sumData[$index] += $value; // Pastikan value sudah berupa integer
                }
            }

            // Return atau gunakan $processedContracts, $sumData, dan $totalSum sesuai kebutuhan
            $data['contracts'] = $processedContracts;
            $data['sumDatas'] = $sumData;
            $data['totalSum'] = $totalSum;
        }

            
        return view('reports.contracts.coal-receipt',$data);
    }
}

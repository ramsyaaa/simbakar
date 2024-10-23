<?php

namespace App\Http\Controllers\Report\Receipt;

use stdClass;
use App\BbmReceipt;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use Illuminate\Support\Facades\DB;
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

                    // Ambil semua data yang diperlukan dalam satu query
                    $contracts = CoalUnloading::select(
                        'coal_contracts.id as contract_id',
                        'coal_contracts.contract_number',
                        'suppliers.name',
                        'coal_contracts.total_volume',
                        DB::raw('DAY(receipt_date) as hari'),
                        DB::raw('SUM(tug_3_accept) as total_per_hari')
                    )
                    ->join('coal_contracts', 'coal_contracts.id', '=', 'coal_unloadings.contract_id')
                    ->join('suppliers', 'suppliers.id', '=', 'coal_contracts.supplier_id')
                    ->whereMonth('receipt_date', '=', $bulan) // Jika bulan dinamis, bisa gunakan $bulan
                    ->whereYear('receipt_date', '=', $tahun) // Jika tahun dinamis, bisa gunakan $tahun
                    ->groupBy('coal_contracts.id', 'coal_contracts.contract_number', 'suppliers.name', 'coal_contracts.total_volume', 'hari') // Tambahkan semua kolom non-agregat di sini
                    ->get()
                    ->groupBy('contract_id');

                    // Memproses data hasil query untuk mengelompokkan per kontrak
                    $processedContracts = $contracts->map(function($items) use ($daysInMonth) {
                        $result = new stdClass();

                        // Assign basic data
                        $firstItem = $items->first();
                        $result->name = $firstItem->name;
                        $result->contract_number = $firstItem->contract_number;
                        $result->total_volume = $firstItem->total_volume;

                        // Inisialisasi data harian
                        $result->data = array_fill(1, $daysInMonth, 0);
                        foreach ($items as $item) {
                            $result->data[$item->hari] = (int)$item->total_per_hari;
                        }

                        // Hitung total untuk semua hari dalam bulan ini
                        $result->total = array_sum($result->data) / 1000;

                        return $result;
                    });

                    // Inisialisasi sumData untuk setiap hari
                    $sumData = array_fill(1, $daysInMonth, 0);
                    $totalSum = 0;

                    // Loop melalui setiap kontrak untuk menghitung total harian dan total keseluruhan
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
                    $data['days'] = $daysInMonth;
                    break;

                case 'month':
                    $tahunInput = $request->input('tahun', date('Y'));

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
                    ->whereYear('receipt_date', '=', $tahunInput)
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
                    break;


                case 'year':

                    $startYear = $request->input('start_year', date('Y'));
                    $endYear = $request->input('end_year', date('Y'));

                    // Mengambil semua data dalam satu query
                    $contracts = CoalUnloading::select(
                        'coal_contracts.id as contract_id',
                        'coal_contracts.contract_number',
                        'suppliers.name',
                        'coal_contracts.total_volume',
                        DB::raw('YEAR(receipt_date) as tahun'),
                        DB::raw('SUM(tug_3_accept) as total_per_tahun')
                    )
                    ->join('coal_contracts', 'coal_contracts.id', '=', 'coal_unloadings.contract_id')
                    ->join('suppliers', 'suppliers.id', '=', 'coal_contracts.supplier_id')
                    ->whereYear('receipt_date', '>=', $startYear)
                    ->whereYear('receipt_date', '<=', $endYear)
                    ->groupBy('coal_contracts.id', 'coal_contracts.contract_number', 'suppliers.name', 'coal_contracts.total_volume', 'tahun') // Tambahkan semua kolom non-agregat di sini
                    ->get()
                    ->groupBy('contract_id');

                    // Memproses data hasil query untuk mengelompokkan per kontrak dan per tahun
                    $processedContracts = $contracts->map(function($items) use($startYear, $endYear) {
                        $result = new stdClass();

                        // Assign basic data
                        $firstItem = $items->first();
                        $result->name = $firstItem->name;
                        $result->contract_number = $firstItem->contract_number;
                        $result->total_volume = $firstItem->total_volume;

                        // Inisialisasi data tahunan
                        $result->data = array_fill($startYear, $endYear - $startYear + 1, 0);
                        foreach ($items as $item) {
                            $result->data[$item->tahun] = (int)$item->total_per_tahun;
                        }

                        // Hitung total untuk seluruh tahun dalam periode yang ditentukan
                        $result->total = array_sum($result->data) ;

                        return $result;
                    });

                    // Inisialisasi sumData untuk setiap tahun
                    $minYear = $endYear - $startYear + 1;
                    $sumData = array_fill($startYear, $minYear, 0);
                    $totalSum = 0;

                    // Loop melalui setiap kontrak untuk menghitung total tahunan dan total keseluruhan
                    foreach ($processedContracts as $contract) {
                        $totalSum += $contract->total;
                        foreach ($contract->data as $year => $value) {
                            $sumData[$year] += $value; // Pastikan value sudah berupa integer
                        }
                    }

                    // Return atau gunakan $processedContracts, $sumData, dan $totalSum sesuai kebutuhan
                    $data['contracts'] = $processedContracts;
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

   


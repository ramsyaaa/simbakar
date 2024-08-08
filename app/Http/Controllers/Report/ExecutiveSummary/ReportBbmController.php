<?php

namespace App\Http\Controllers\Report\ExecutiveSummary;

use App\BbmReceipt;
use App\BbmUsage;
use App\HeavyEquipment;
use App\Http\Controllers\Controller;
use App\Unit;
use Illuminate\Http\Request;

class ReportBbmController extends Controller
{
    // public function index(Request $request){
    //     $data['loadings'] = [];
    //     $validFilterTypes = ['day', 'month', 'year'];
    //     $data['filter_type'] = 'day';

    //     // Periksa apakah ada filter_type dalam request dan apakah valid
    //     if ($request->has('filter_type') && in_array($request->filter_type, $validFilterTypes)) {
    //         $data['filter_type'] = $request->filter_type;
    //     }
    //     $data['bbm_receipt'] = BbmReceipt::whereDate('date_receipt', '2024-07-28')
    //                         ->where('bbm_type', 'solar')
    //                         ->get();
    //     $data['bbm_usage'] = BbmUsage::whereDate('use_date', '2024-07-28')
    //                         ->where('bbm_type', 'solar')
    //                         ->get();

    //     dd($data);
    //     return view('reports.executive-summary.bbm-receipt-usage-report', $data);
    // }


    public function index(Request $request, $type_bbm)
    {
        $filterType = 'day';
        $data['filter_type'] = $filterType;
        $validFilterTypes = ['day', 'month', 'year'];
        $validBbmTypes = ['HSD', 'MFO'];
        if ($request->has('filter_type') && in_array($request->filter_type, $validFilterTypes)) {
            $data['filter_type'] = $request->filter_type;
            $filterType = $request->filter_type;
        }
        if (in_array($type_bbm, $validBbmTypes)) {
            $data['type_bbm'] = $type_bbm;

            if($type_bbm == 'HSD'){
                $data['type_bbm'] = 'solar';
                $type_bbm = 'solar';
            }
            if($type_bbm == 'MFO'){
                $data['type_bbm'] = 'residu';
                $type_bbm = 'residu';
            }
        }else{
            $type_bbm = 'solar';
            $data['type_bbm'] = 'solar';
        }

        $bulanTahun = $request->input('bulan_tahun', date('Y-m'));
        list($tahun, $bulan) = explode('-', $bulanTahun);
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $tahunInput = $request->input('tahun', date('Y'));
        $data['tahunInput'] = $tahunInput;
        $startYear = $request->input('start_year', date('Y'));
        $data['start_year'] = $startYear;
        $endYear = $request->input('end_year', date('Y'));
        $data['end_year'] = $endYear;

        $queryBbmReceipt = BbmReceipt::query();
        $queryBbmUsage = BbmUsage::query();
        switch ($filterType) {
            case 'day':
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                $daysBbmReceiptArray = [];
                $daysBbmUsageArray = [];

                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $date = sprintf('%04d-%02d-%02d', $tahun, $bulan, $day);
                    $daysBbmReceiptArray[$date] = 0.0;
                    $daysBbmUsageArray[$date] = 0.0;
                }

                $queryBbmReceipt->selectRaw('DATE(date_receipt) as date, SUM(amount_receipt) as total_amount')
                                ->whereYear('date_receipt', $tahun)
                                ->whereMonth('date_receipt', $bulan)
                                ->where('bbm_type', $type_bbm)
                                ->groupBy('date');

                $queryBbmUsage->selectRaw('DATE(use_date) as date, SUM(amount) as total_amount')
                            ->whereYear('use_date', $tahun)
                            ->whereMonth('use_date', $bulan)
                            ->where('bbm_type', $type_bbm)
                            ->groupBy('date');

                $bbmReceiptResults = $queryBbmReceipt->get();
                $bbmUsageResults = $queryBbmUsage->get();

                foreach ($bbmReceiptResults as $result) {
                    $daysBbmReceiptArray[$result->date] = $result->total_amount;
                }

                foreach ($bbmUsageResults as $result) {
                    $daysBbmUsageArray[$result->date] = $result->total_amount;
                }

                $data['bbm_receipt'] = array_values($daysBbmReceiptArray);
                $data['bbm_usage'] = array_values($daysBbmUsageArray);
                break;

            case 'month':
                $queryBbmReceipt->selectRaw('YEAR(date_receipt) as year, MONTH(date_receipt) as month, SUM(amount_receipt) as total_amount')
                                ->whereYear('date_receipt', $tahunInput)
                                ->where('bbm_type', $type_bbm)
                                ->groupBy('year', 'month');

                $queryBbmUsage->selectRaw('YEAR(use_date) as year, MONTH(use_date) as month, SUM(amount) as total_amount')
                            ->whereYear('use_date', $tahunInput)
                            ->where('bbm_type', $type_bbm)
                            ->groupBy('year', 'month');

                $bbmReceiptResults = $queryBbmReceipt->get();
                $bbmUsageResults = $queryBbmUsage->get();

                // Initialize arrays for each month
                $monthlyReceipts = array_fill(1, 12, 0.0);
                $monthlyUsages = array_fill(1, 12, 0.0);

                // Populate receipt data
                foreach ($bbmReceiptResults as $result) {
                    $monthlyReceipts[$result->month] = $result->total_amount;
                }

                // Populate usage data
                foreach ($bbmUsageResults as $result) {
                    $monthlyUsages[$result->month] = $result->total_amount;
                }

                $data['bbm_receipt'] = array_values($monthlyReceipts);
                $data['bbm_usage'] = array_values($monthlyUsages);
                break;


            case 'year':
                // Set the start and end dates for the year range
                $startDate = $startYear . '-01-01';
                $endDate = $endYear . '-12-31 23:59:59'; // Ensure the end date includes the entire last day of the year

                // Query for receipts
                $queryBbmReceipt->selectRaw('YEAR(date_receipt) as year, SUM(amount_receipt) as total_amount')
                                ->whereBetween('date_receipt', [$startDate, $endDate])
                                ->where('bbm_type', $type_bbm)
                                ->groupBy('year');

                // Query for usage
                $queryBbmUsage->selectRaw('YEAR(use_date) as year, SUM(amount) as total_amount')
                            ->whereBetween('use_date', [$startDate, $endDate])
                            ->where('bbm_type', $type_bbm)
                            ->groupBy('year');

                // Execute the queries
                $bbmReceiptResults = $queryBbmReceipt->get();
                $bbmUsageResults = $queryBbmUsage->get();

                // Initialize arrays for each year
                $yearlyReceipts = [];
                $yearlyUsages = [];

                // Populate receipt data
                foreach ($bbmReceiptResults as $result) {
                    $yearlyReceipts[$result->year] = $result->total_amount;
                }

                // Populate usage data
                foreach ($bbmUsageResults as $result) {
                    $yearlyUsages[$result->year] = $result->total_amount;
                }

                // Fill in missing years
                for ($year = $startYear; $year <= $endYear; $year++) {
                    if (!isset($yearlyReceipts[$year])) {
                        $yearlyReceipts[$year] = 0.0;
                    }
                    if (!isset($yearlyUsages[$year])) {
                        $yearlyUsages[$year] = 0.0;
                    }
                }

                $data['bbm_receipt'] = $yearlyReceipts;
                $data['bbm_usage'] = $yearlyUsages;
                break;


        }

        return view('reports.executive-summary.bbm-receipt-usage-report', $data);
    }

    public function bbmUsageReport(Request $request, $type, $type_bbm){
        $tahunInput = $request->input('tahunInput', 2024);
        $data['tahunInput'] = $tahunInput;
        $validBbmTypes = ['HSD', 'MFO'];
        if (in_array($type_bbm, $validBbmTypes)) {
            $data['type_bbm'] = $type_bbm;

            if($type_bbm == 'HSD'){
                $data['type_bbm'] = 'solar';
                $type_bbm = 'solar';
            }
            if($type_bbm == 'MFO'){
                $data['type_bbm'] = 'residu';
                $type_bbm = 'residu';
            }
        }else{
            $type_bbm = 'solar';
            $data['type_bbm'] = 'solar';
        }


        $validType = ['all', 'albes', 'unit', 'other'];
        if (in_array($type, $validType)) {
            $data['type'] = $type;
        }else{
            $type = 'all';
            $data['type'] = 'all';
        }

        $data['bbm_usage'] = [];

        if($type == 'albes' || $type == 'all'){
            $bbm_usage = BbmUsage::selectRaw('heavy_equipment_uuid, MONTH(use_date) as month, SUM(amount) as total_amount')
                ->where([
                    'bbm_use_for' => 'heavy_equipment',
                    'bbm_type' => $type_bbm
                ])
                ->whereYear('use_date', $tahunInput)
                ->groupBy('heavy_equipment_uuid', 'month')
                ->get();

            // Mengelompokkan data berdasarkan heavy_equipment_uuid
            $groupedData = $bbm_usage->groupBy('heavy_equipment_uuid');

            // Membuat struktur data untuk setiap heavy_equipment_uuid
            $finalData = [];
            foreach ($groupedData as $uuid => $records) {
                $monthlyData = array_fill(1, 12, 0.0); // Mengisi nilai default 0.0 untuk setiap bulan
                foreach ($records as $record) {
                    $monthlyData[$record->month] = $record->total_amount;
                }
                $finalData[$uuid] = $monthlyData;
            }

            $getHeavyEquipment = HeavyEquipment::get();

            foreach ($getHeavyEquipment as $index => $item) {
                if(isset($finalData[$item->uuid])){
                    $data['bbm_usage'][$item->name] = $finalData[$item->uuid];
                }else{
                    $data['bbm_usage'][$item->name] = [0,0,0,0,0,0,0,0,0,0,0,0];
                }
            }
        }if($type == 'unit' || $type == 'all'){
            $bbm_usage = BbmUsage::selectRaw('unit_uuid, MONTH(use_date) as month, SUM(amount) as total_amount')
                ->where([
                    'bbm_use_for' => 'unit',
                    'bbm_type' => $type_bbm
                ])
                ->whereYear('use_date', $tahunInput)
                ->groupBy('unit_uuid', 'month')
                ->get();

            // Mengelompokkan data berdasarkan unit_uuid
            $groupedData = $bbm_usage->groupBy('unit_uuid');

            // Membuat struktur data untuk setiap unit_uuid
            $finalData = [];
            foreach ($groupedData as $uuid => $records) {
                $monthlyData = array_fill(1, 12, 0.0); // Mengisi nilai default 0.0 untuk setiap bulan
                foreach ($records as $record) {
                    $monthlyData[$record->month] = $record->total_amount;
                }
                $finalData[$uuid] = $monthlyData;
            }

            $getUnit = Unit::get();

            foreach ($getUnit as $index => $item) {
                if(isset($finalData[$item->uuid])){
                    $data['bbm_usage'][$item->name] = $finalData[$item->uuid];
                }else{
                    $data['bbm_usage'][$item->name] = [0,0,0,0,0,0,0,0,0,0,0,0];
                }
            }
        }if($type == 'other' || $type == 'all'){
            $bbm_usage = BbmUsage::selectRaw('MONTH(use_date) as month, SUM(amount) as total_amount')
                ->where([
                    'bbm_use_for' => 'other',
                    'bbm_type' => $type_bbm
                ])
                ->whereYear('use_date', $tahunInput)
                ->groupBy('month')
                ->get();

            // Membuat struktur data untuk setiap heavy_equipment_uuid
            $finalData = [];
            foreach ($bbm_usage as $uuid => $records) {
                $monthlyData = array_fill(1, 12, 0.0); // Mengisi nilai default 0.0 untuk setiap bulan
                $monthlyData[$records->month] = $records->total_amount;
                $finalData[] = $monthlyData;
            }
            $data['bbm_usage']['lainnya'] = $finalData[0];
        }

        return view('reports.executive-summary.bbm-usage', $data);
    }


}

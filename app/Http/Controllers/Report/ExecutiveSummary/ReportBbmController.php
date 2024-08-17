<?php

namespace App\Http\Controllers\Report\ExecutiveSummary;

use App\BbmReceipt;
use App\BbmUsage;
use App\HeavyEquipment;
use App\Http\Controllers\Controller;
use App\Models\CoalUnloading;
use App\Unit;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

    public function bbmUnloadingMonthComparison(Request $request) {
        $year = $request->get('year') ?? date('Y' , time());
        $bbm_unloading = CoalUnloading::whereRaw('receipt_date like ?',["%" .$year . "%"])->get();
        Carbon::setLocale('id');
        $processedData = [];
        for ($i = 1; $i <= 12; $i++) {
            $processedData[Carbon::create()->month($i)->translatedFormat('F')] = [];
        }
        // Group by month
        $grouped = $bbm_unloading->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item['receipt_date'])->translatedFormat('F'); // 'F' gives full month name
        });
        
        // Convert to an array with month as keys
        $groupedArray = $grouped->map(function ($items) {
            return $items->values()->all(); // Convert the grouped collection to an array of values
        })->toArray();

        function formatNumber ($val) {
            return number_format($val , 0);
        }

        foreach ($processedData as $month => $value) {
            foreach ($groupedArray as $key => $value) {
                if($month == $key){
                    
                    $bl = collect($value)->pluck('bl')->sum();
                    $ds = collect($value)->pluck('ds')->sum();
                    $bw = collect($value)->pluck('bw')->sum();
                    $tug = collect($value)->pluck('tug_3_accept')->sum();
                    $ds_bl = abs($ds - $bl);
                    $bw_ds = abs($bw - $ds);
                    $bl_bw = abs($bl - $bw);
                    
                    $ds_bl_percentage = $ds > 0  ? $ds_bl/$ds * 100 . "%" : '100%';
                    $bw_ds_percentage = $bw > 0  ? $bw_ds/$bw * 100 . "%" : '100%';
                    $bl_bw_percentage = $bl > 0  ? $bl_bw/$bl * 100 . "%" : '100%';
                    
                    $processedData[$month] = [
                        'bl' => formatNumber($bl),
                        'ds' => formatNumber($ds),
                        'bw' => formatNumber($bw),
                        'tug' => formatNumber($tug),
                        'ds_bl' => formatNumber($ds_bl),
                        'bw_ds' => formatNumber($bw_ds),
                        'bl_bw' => formatNumber($bl_bw),
                        
                        'ds_bl_percentage' => $ds_bl_percentage,
                        'bw_ds_percentage' => $bw_ds_percentage,
                        'bl_bw_percentage' => $bl_bw_percentage,
                    ];
                }
            }
        }
        $data['bbm_unloading'] = $processedData;
        $data['year'] = $year;
        return view('reports.executive-summary.bbm-unloading-month-comparison', $data);
    }

    public function bbmUnloadingMonthRealitation (Request $request) {
        function getTimeDifference($startTime, $endTime) {
            // Convert to DateTime objects
            $start = new DateTime($startTime);
            $end = new DateTime($endTime);

            // Calculate the difference
            $difference = $start->diff($end);

            // Format the difference as a string
            return [
                'years' => $difference->y,
                'months' => $difference->m,
                'days' => $difference->d,
                'hours' => $difference->h,
                'minutes' => $difference->i,
                'seconds' => $difference->s,
            ];
        }

        function formatNumber ($val) {
            return number_format($val , 2);
        }
        $year_month = $request->get('year_month') ?? date('Y-m' , time());
        $data['year_month'] = $year_month;
        


        $bbm_unloading = CoalUnloading::with(['ship' , 'dock' , 'company'])->whereRaw('receipt_date like ?',["%" . $year_month . "%"])->get();

        $processedData = [];
        foreach ($bbm_unloading as $key => $value) {
            $processedData[$key] = [];
            $processedData[$key]['ship_name'] = $value->ship->name;
            $processedData[$key]['dock_name'] = $value->dock->name;
            $processedData[$key]['company_name'] = $value->company->name;
            $processedData[$key]['receipt_date'] = date('d M Y' , strtotime($value->receipt_date));

            $processedData[$key]['unloading_duration'] = getTimeDifference($value->end_date , $value->receipt_date)['hours'] ."H " . getTimeDifference($value->end_date , $value->receipt_date)['minutes']."M";

            $processedData[$key]['standard_duration'] = getTimeDifference($value->dock_ship_date , $value->departure_date)['hours'] ."H " . getTimeDifference($value->dock_ship_date , $value->departure_date)['minutes']."M";

            $processedData[$key]['ship_duration'] = getTimeDifference($value->dock_ship_date , $value->departure_date)['hours'] ."H " . getTimeDifference($value->dock_ship_date , $value->departure_date)['minutes']."M";

            $processedData[$key]['waiting_time'] = getTimeDifference($value->arrived_date , $value->unloading_date)['hours'] ."H " . getTimeDifference($value->arrived_date , $value->unloading_date)['minutes']."M";

            $processedData[$key]['bl'] = formatNumber($value->bl / 1000);
            $processedData[$key]['ds'] = formatNumber($value->ds / 1000);
            $processedData[$key]['bl'] = formatNumber($value->bw / 1000);
            $processedData[$key]['tug'] = formatNumber($value->tug_3_accept / 1000);

        }

        $data['bbm_unloading'] = $processedData;

        return view('reports.executive-summary.bbm-unloading-month-realitation', $data);
    }

}

<?php

namespace App\Http\Controllers\Report\ExecutiveSummary;

use App\BbmReceipt;
use App\BbmUsage;
use App\HeavyEquipment;
use App\Http\Controllers\Controller;
use App\Models\CoalContract;
use App\Models\CoalReceiptPlan;
use App\Models\CoalUnloading;
use App\Models\CoalUsage;
use App\Models\DeliveryClause;
use App\Models\YearStartData;
use App\Supplier;
use App\Unit;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
        $data['filter_type'] = null;
        $validFilterTypes = ['day', 'month', 'year'];
        $validBbmTypes = ['HSD', 'MFO'];
        if ($request->has('filter_type') && in_array($request->filter_type, $validFilterTypes)) {
            $data['filter_type'] = $request->filter_type;
            $filterType = $request->filter_type;
        }
        if (in_array($type_bbm, $validBbmTypes)) {
            $data['type_bbm'] = $type_bbm;

            if ($type_bbm == 'HSD') {
                $data['type_bbm'] = 'solar';
                $type_bbm = 'solar';
            }
            if ($type_bbm == 'MFO') {
                $data['type_bbm'] = 'residu';
                $type_bbm = 'residu';
            }
        } else {
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
                ksort($data['bbm_usage']);
                ksort($data['bbm_receipt']);
                break;
        }
        return view('reports.executive-summary.bbm-receipt-usage-report', $data);
    }

    public function bbmUsageReport(Request $request, $type, $type_bbm)
    {
        $tahunInput = $request->input('tahunInput', null);
        $data['tahunInput'] = $tahunInput;
        $validBbmTypes = ['HSD', 'MFO'];
        if (in_array($type_bbm, $validBbmTypes)) {
            $data['type_bbm'] = $type_bbm;

            if ($type_bbm == 'HSD') {
                $data['type_bbm'] = 'solar';
                $type_bbm = 'solar';
            }
            if ($type_bbm == 'MFO') {
                $data['type_bbm'] = 'residu';
                $type_bbm = 'residu';
            }
        } else {
            $type_bbm = 'solar';
            $data['type_bbm'] = 'solar';
        }


        $validType = ['all', 'albes', 'unit', 'other'];
        if (in_array($type, $validType)) {
            $data['type'] = $type;
        } else {
            $type = 'all';
            $data['type'] = 'all';
        }

        $data['bbm_usage'] = [];

        if ($tahunInput != null) {
            if ($type == 'albes' || $type == 'all') {
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
                    if (isset($finalData[$item->uuid])) {
                        $data['bbm_usage'][$item->name] = $finalData[$item->uuid];
                    } else {
                        $data['bbm_usage'][$item->name] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    }
                }
            }
            if ($type == 'unit' || $type == 'all') {
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
                    if (isset($finalData[$item->uuid])) {
                        $data['bbm_usage'][$item->name] = $finalData[$item->uuid];
                    } else {
                        $data['bbm_usage'][$item->name] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    }
                }
            }
            if ($type == 'other' || $type == 'all') {
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
        }

        return view('reports.executive-summary.bbm-usage', $data);
    }

    public function bbmUnloadingMonthComparison(Request $request)
    {
        $year = $request->get('year') ?? '';

        $processedData = [];
        if ($year) {
            $bbm_unloading = CoalUnloading::whereRaw('receipt_date like ?', ["%" . $year . "%"])->get();
            Carbon::setLocale('id');
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


            foreach ($processedData as $month => $value) {
                foreach ($groupedArray as $key => $value) {
                    if ($month == $key) {

                        $bl = collect($value)->pluck('bl')->sum();
                        $ds = collect($value)->pluck('ds')->sum();
                        $bw = collect($value)->pluck('bw')->sum();
                        $tug = collect($value)->pluck('tug_3_accept')->sum();
                        $ds_bl = abs($ds - $bl);
                        $bw_ds = abs($bw - $ds);
                        $bl_bw = abs($bl - $bw);

                        $ds_bl_percentage = $ds > 0  ? $ds_bl / $ds * 100 . "%" : '100%';
                        $bw_ds_percentage = $bw > 0  ? $bw_ds / $bw * 100 . "%" : '100%';
                        $bl_bw_percentage = $bl > 0  ? $bl_bw / $bl * 100 . "%" : '100%';

                        $processedData[$month] = [
                            'bl' => $bl,
                            'ds' => $ds,
                            'bw' => $bw,
                            'tug' => $tug,
                            'ds_bl' => $ds_bl,
                            'bw_ds' => $bw_ds,
                            'bl_bw' => $bl_bw,

                            'ds_bl_percentage' => $ds_bl_percentage,
                            'bw_ds_percentage' => $bw_ds_percentage,
                            'bl_bw_percentage' => $bl_bw_percentage,
                        ];
                    }
                }
            }
        }

        $data['bbm_unloading'] = $processedData;
        $data['year'] = $year;
        return view('reports.executive-summary.bbm-unloading-month-comparison', $data);
    }

    public function bbmUnloadingMonthRealitation(Request $request)
    {
        function getTimeDifference($startTime, $endTime)
        {
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

        function formatNumber($val)
        {
            return number_format($val, 2);
        }

        $year_month = $request->get('year_month') ?? '';
        $processedData = [];
        $data['year_month'] = $year_month;
        if ($year_month) {



            $bbm_unloading = CoalUnloading::with(['ship', 'dock', 'company'])->whereRaw('receipt_date like ?', ["%" . $year_month . "%"])->get();

            foreach ($bbm_unloading as $key => $value) {
                $processedData[$key] = [];
                $processedData[$key]['ship_name'] = $value->ship->name;
                $processedData[$key]['dock_name'] = $value->dock->name;
                $processedData[$key]['company_name'] = $value->company->name;
                $processedData[$key]['receipt_date'] = date('d M Y', strtotime($value->receipt_date));

                $processedData[$key]['unloading_duration'] = getTimeDifference($value->end_date, $value->receipt_date)['hours'] . "H " . getTimeDifference($value->end_date, $value->receipt_date)['minutes'] . "M";

                $processedData[$key]['standard_duration'] = getTimeDifference($value->dock_ship_date, $value->departure_date)['hours'] . "H " . getTimeDifference($value->dock_ship_date, $value->departure_date)['minutes'] . "M";

                $processedData[$key]['ship_duration'] = getTimeDifference($value->dock_ship_date, $value->departure_date)['hours'] . "H " . getTimeDifference($value->dock_ship_date, $value->departure_date)['minutes'] . "M";

                $processedData[$key]['waiting_time'] = getTimeDifference($value->arrived_date, $value->unloading_date)['hours'] . "H " . getTimeDifference($value->arrived_date, $value->unloading_date)['minutes'] . "M";

                $processedData[$key]['bl'] = formatNumber($value->bl / 1000);
                $processedData[$key]['ds'] = formatNumber($value->ds / 1000);
                $processedData[$key]['bl'] = formatNumber($value->bw / 1000);
                $processedData[$key]['tug'] = formatNumber($value->tug_3_accept / 1000);
            }
        }

        $data['bbm_unloading'] = $processedData;

        return view('reports.executive-summary.bbm-unloading-month-realitation', $data);
    }

    public function bbmLoadingUnloadingEfectiveStock(Request $request)
    {

        $type = isset($_GET['type']) ? $_GET['type'] : 'day';
        $start_year = $request->get('start_year') ?? '';
        $end_year = $request->get('end_year') ?? '';
        $data['start_year'] = $start_year;
        $data['end_year'] = $end_year;

        $years = [];
        if ($start_year && $end_year) {
            for ($i = $start_year; $i <= $end_year; $i++) {
                array_push($years, $i);
            }
        }

        $type = $request->get('type') ?? '';
        $data['type'] = $type;

        $month = $request->get('month') ?? '';
        $data['month'] = $month;

        $year = $request->get('year') ?? '';
        $data['year'] = $year;


        function getDataByDay($month)
        {
            $processedData = [];

            function getStock($coal_plans, $monthIndex)
            {
                if ($coal_plans) {
                    switch ($monthIndex) {
                        case 0:
                            return $coal_plans->planning_january;
                        case 1:
                            return $coal_plans->planning_february;
                        case 2:
                            return $coal_plans->planning_march;
                        case 3:
                            return $coal_plans->planning_april;
                        case 4:
                            return $coal_plans->planning_may;
                        case 5:
                            return $coal_plans->planning_june;
                        case 6:
                            return $coal_plans->planning_july;
                        case 7:
                            return $coal_plans->planning_august;
                        case 8:
                            return $coal_plans->planning_september;
                        case 9:
                            return $coal_plans->planning_october;
                        case 10:
                            return $coal_plans->planning_november;
                        case 11:
                            return $coal_plans->planning_december;
                        default:
                            break;
                    }
                }
                return 0;
            }
            if ($month) {
                $dayArray = explode('-', $month);
                $year = $dayArray[0];
                $month = $dayArray[1];

                $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
                $daysArray = [];

                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $daysArray[] = Carbon::createFromDate($year, $month, $i)->format('Y-m-d');
                }


                $units = Unit::select('id')->get();
                $coal_plans = CoalReceiptPlan::where('year', $year)->first();
                $coal_plans = $coal_plans ? intval(getStock($coal_plans, intval($month) - 1)) : 0;

                foreach ($daysArray as $day) {
                    $processedData[$day] = [];
                    $bbm_unloading = CoalUnloading::select('receipt_date', 'tug_3_accept')->whereRaw('receipt_date like ?', ["%" . $day . "%"])->get();
                    if (count($bbm_unloading) > 0) {
                        foreach ($bbm_unloading as $key => $item) {
                            $receipt_date = date('Y-m-d', strtotime($item->receipt_date));
                            if ($receipt_date == $day) {
                                // Get BBM Usage with receipt date
                                $bbm_usage = CoalUsage::select('unit_id', 'amount_use')->whereRaw('usage_date like ?', ['%' . $receipt_date . '%'])->get();

                                // get All Unit Value
                                foreach ($units as $unit_key => $unit) {
                                    $index = "unit_" . ($unit_key + 1);
                                    $processedData[$day][$index] = 0;
                                    foreach ($bbm_usage as $usage) {
                                        if ($unit->id == $usage->unit_id) $processedData[$day][$index] = $processedData[$day][$index] + $usage->amount_use;
                                    }
                                    $processedData[$day][$index] = $processedData[$day][$index] ?? 0;
                                }


                                $processedData[$day]['receipt_date'] = $receipt_date;
                                $processedData[$day]['tug'] = $item->tug_3_accept;
                                $processedData[$day]['unit_5_7'] = array_sum([
                                    $processedData[$day]['unit_5'],
                                    $processedData[$day]['unit_6'],
                                    $processedData[$day]['unit_7']
                                ]);
                                $processedData[$day]['unit_1_7'] = array_sum([
                                    $processedData[$day]['unit_1'],
                                    $processedData[$day]['unit_2'],
                                    $processedData[$day]['unit_3'],
                                    $processedData[$day]['unit_4'],
                                    $processedData[$day]['unit_5'],
                                    $processedData[$day]['unit_6'],
                                    $processedData[$day]['unit_7']
                                ]);
                                $processedData[$day]['stock'] = $coal_plans + ($item->tug_3_accept - $processedData[$day]['unit_1_7']);
                            }
                        }
                    }
                }
            }

            return $processedData;
        }

        function getDataByMonth($year)
        {
            $processedData = [];
            $months = [];
            if ($year) {
                for ($i = 1; $i <= 12; $i++) {
                    array_push($months, Carbon::create()->month($i)->translatedFormat('m'));
                    $processedData[Carbon::create()->month($i)->translatedFormat('F')] = [];
                }

                $coal_plans = CoalReceiptPlan::where('year', $year)->first();
                $units = Unit::select('id')->get();
                $i = 0;

                function getStock($coal_plans, $monthIndex)
                {
                    if ($coal_plans) {
                        switch ($monthIndex) {
                            case 0:
                                return $coal_plans->planning_january;
                            case 1:
                                return $coal_plans->planning_february;
                            case 2:
                                return $coal_plans->planning_march;
                            case 3:
                                return $coal_plans->planning_april;
                            case 4:
                                return $coal_plans->planning_may;
                            case 5:
                                return $coal_plans->planning_june;
                            case 6:
                                return $coal_plans->planning_july;
                            case 7:
                                return $coal_plans->planning_august;
                            case 8:
                                return $coal_plans->planning_september;
                            case 9:
                                return $coal_plans->planning_october;
                            case 10:
                                return $coal_plans->planning_november;
                            case 11:
                                return $coal_plans->planning_december;
                            default:
                                break;
                        }
                    }
                    return 0;
                }
                foreach ($processedData as $month => $value) {
                    $receipt_date = "$year-$months[$i]";

                    $bbm_unloading = CoalUnloading::select('receipt_date', 'tug_3_accept')->whereRaw('receipt_date like ?', ["%" . ("$receipt_date") . "%"])->get();
                    $processedData[$month]['stock'] = $coal_plans ? getStock($coal_plans, $i) : 0;
                    $bbm_usage = CoalUsage::select('unit_id', 'amount_use')->whereRaw('usage_date like ?', ['%' . $receipt_date . '%'])->get();
                    if (count($bbm_unloading) > 0) {
                        // Get BBM Usage with receipt date
                        foreach ($bbm_unloading as $key => $item) {
                            if ($receipt_date == ("$year-$months[$i]")) {
                                // get All Unit Value
                                foreach ($units as $unit_key => $unit) {
                                    $index = "unit_" . ($unit_key + 1);
                                    $processedData[$month][$index] = 0;
                                    foreach ($bbm_usage as $usage) {
                                        if ($unit->id == $usage->unit_id) $processedData[$month][$index] = $processedData[$month][$index] + $usage->amount_use;
                                    }
                                    $processedData[$month][$index] = $processedData[$month][$index] ?? 0;
                                }


                                $processedData[$month]['receipt_date'] = date('d M Y', strtotime($item->receipt_date));
                                $processedData[$month]['tug'] = $bbm_unloading->pluck('tug_3_accept')->sum();
                                $processedData[$month]['unit_5_7'] = array_sum([
                                    $processedData[$month]['unit_5'],
                                    $processedData[$month]['unit_6'],
                                    $processedData[$month]['unit_7']
                                ]);
                                $processedData[$month]['unit_1_7'] = array_sum([
                                    $processedData[$month]['unit_1'],
                                    $processedData[$month]['unit_2'],
                                    $processedData[$month]['unit_3'],
                                    $processedData[$month]['unit_4'],
                                    $processedData[$month]['unit_5'],
                                    $processedData[$month]['unit_6'],
                                    $processedData[$month]['unit_7']
                                ]);
                            }
                        }
                    }
                    $i++;
                }
            }

            return $processedData;
        }

        function getDataByYear($years)
        {
            set_time_limit(100);
            $currentYear = Carbon::now()->year;
            $processedData = [];
            $units = Unit::select('id')->get();

            for ($i = 0; $i <= count($years); $i++) {
                if (isset($years[$i])) $processedData[$years[$i]] = [];
            }
            function getStock($coal_plans)
            {
                if ($coal_plans) {
                    return $coal_plans->planning_january + $coal_plans->planning_february + $coal_plans->planning_march + $coal_plans->planning_april + $coal_plans->planning_may + $coal_plans->planning_june + $coal_plans->planning_july + $coal_plans->planning_august + $coal_plans->planning_september + $coal_plans->planning_october + $coal_plans->planning_november + $coal_plans->planning_december;
                }
                return 0;
            }
            $bbm_usage = CoalUsage::select('unit_id', 'amount_use', 'usage_date')->get();
            $bbm_unloading = CoalUnloading::select('receipt_date', 'tug_3_accept')->get();
            foreach ($processedData as $year => $value) {
                $coal_plans = CoalReceiptPlan::where('year', $year)->first();
                $processedData[$year]['stock'] = $coal_plans ? getStock($coal_plans) : 0;
                if (count($bbm_unloading) > 0) {
                    $bbmUsage = collect($bbm_usage)->filter(function ($bbm) use ($year) {
                        return Str::contains($bbm->usage_date, $year);
                    });
                    $bbmUnloading = collect($bbm_unloading)->filter(function ($bbm) use ($year) {
                        return Str::contains($bbm->receipt_date, $year);
                    });
                    // foreach ($bbmUnloading as $key => $item) {
                    //     $receipt_date = date('Y', strtotime($item->receipt_date));
                    //     if ($receipt_date == ("$year")) {
                    // Get BBM Usage with receipt date
                    // get All Unit Value
                    foreach ($units as $unit_key => $unit) {
                        $index = "unit_" . ($unit_key + 1);
                        $processedData[$year][$index] = 0;
                        $processedData[$year][$index] = collect($bbmUsage)->where('unit_id', $unit->id)->pluck('amount_use')->sum();
                        // dd($test);
                        // foreach ($bbm_usage as $usage) {
                        //     dd($usage);
                        //     if ($unit->id == $usage->unit_id) {
                        //         $processedData[$year][$index] = $processedData[$year][$index] + $usage->amount_use;
                        //     }
                        // }
                        $processedData[$year][$index] = $processedData[$year][$index] ?? 0;
                    }


                    $processedData[$year]['receipt_date'] = $year;
                    $processedData[$year]['tug'] = $bbmUnloading->pluck('tug_3_accept')->sum();
                    $processedData[$year]['unit_5_7'] = array_sum([
                        $processedData[$year]['unit_5'],
                        $processedData[$year]['unit_6'],
                        $processedData[$year]['unit_7']
                    ]);
                    $processedData[$year]['unit_1_7'] = array_sum([
                        $processedData[$year]['unit_1'],
                        $processedData[$year]['unit_2'],
                        $processedData[$year]['unit_3'],
                        $processedData[$year]['unit_4'],
                        $processedData[$year]['unit_5'],
                        $processedData[$year]['unit_6'],
                        $processedData[$year]['unit_7']
                    ]);
                    //     }
                    // }
                }
                $i++;
            }
            return $processedData;
        }

        $processedData = [];

        if ($year || $month || $type) {
            switch ($type) {
                case 'month':
                    $processedData = getDataByMonth($year);
                    break;

                case 'year':
                    if ($start_year && $end_year) {
                        $processedData = getDataByYear($years);
                    }
                    break;

                default:
                    // day
                    $processedData = getDataByDay($month);
                    break;
            }
        }


        $data['bbm_unloading'] = $processedData;

        return view('reports.executive-summary.bbm-loading-unloading-efective-stock', $data);
    }

    public function bbmMonthlyRealitationContractPlan(Request $request)
    {
        $year = $request->get('year') ?? '';
        $data['year'] = $year;

        $supplier = $request->get('supplier') ?? [];
        $data['supplier'] = $supplier;

        $data['suppliers'] = Supplier::all();

        $contract = $request->get('contract') ?? [];
        $data['contract'] = $contract;

        $data['contracts'] = [
            [
                "id" => 'Jangka Panjang',
                "type_contract" => "Jangka Panjang"
            ],
            [
                "id" => 'Jangka Menengah',
                "type_contract" => "Jangka Menengah"
            ],
            [
                "id" => 'Spot',
                "type_contract" => "Spot"
            ],
        ];

        $processedData = [];
        $months = [];

        if ($year) {
            for ($i = 1; $i <= 12; $i++) {
                array_push($months, Carbon::create()->month($i)->translatedFormat('m'));

                $processedData[Carbon::create()->month($i)->translatedFormat('F')] = [];
                // $rakor = DeliveryClause::where(['month' => $i, 'year' => $year]);
                // if ($contract) {
                //     $rakor = $rakor->where('contract_id', $contract);
                // }
                // $rakor = $rakor->get();
                // $rakor = $rakor->pluck('rakor')->sum();
                // $processedData[Carbon::create()->month($i)->translatedFormat('F')]['rakor'] = $rakor;
            }
            $coal_plans = CoalReceiptPlan::where('year', $year)->first();
            // $units = Unit::all();
            $i = 0;

            foreach ($processedData as $month => $value) {
                $filterData = "$year-$months[$i]";
                // $filterData = "2024-08";
                $bbm_unloading = CoalUnloading::select('id', 'contract_id')->with(['contract:id', 'contract.delivery_clauses:id,contract_id,rakor'])->whereRaw('receipt_date like ?', ["%" . ("$filterData") . "%"]);

                if ($contract) {
                    $bbm_unloading = $bbm_unloading->whereHas('contract', function ($query) use ($contract) {
                        $query->where('type_contract', $contract);
                    });
                }
                if ($supplier) {
                    $bbm_unloading = $bbm_unloading->whereRaw('supplier_id = ?', [$supplier]);
                }
                $bbm_unloading = $bbm_unloading->get();

                $rakor = collect($bbm_unloading)->pluck('contract.delivery_clauses.rakor')->sum();
                $processedData[$month]['rakor'] = collect($bbm_unloading)->pluck('contract.delivery_clauses')->flatMap(function ($item) {
                    return $item->pluck('rakor');
                })->sum();

                $processedData[$month]['stock'] =  0;

                // if (count($bbm_unloading) > 0) {


                //     foreach ($bbm_unloading as $key => $item) {


                //         $receipt_date = date('Y-m', strtotime($item->receipt_date));
                //         if ($receipt_date == ("$year-$months[$i]")) {
                //             // Get BBM Usage with receipt date
                //             $bbm_usage = CoalUsage::with(['unit'])->whereRaw('usage_date like ?', ['%' . $receipt_date . '%'])->get();
                //             // get All Unit Value

                //         }
                //     }
                // }
                $i++;
            }
        }
        $data['bbm_unloading'] = $processedData;
        return view('reports.executive-summary.bbm-monthly-realitation-contract-plan', $data);
    }

    public function bbmMonthlyUsageRealitation(Request $request)
    {

        $year = $request->get('year') ?? '';
        $data['year'] = $year;


        $processedData = [];
        $months = [];
        $initialStock = YearStartData::where(['year' => $year, 'type' => 'batubara'])->first();
        if (
            $initialStock &&
            $year
        ) {

            for ($i = 1; $i <= 12; $i++) {
                array_push($months, Carbon::create()->month($i)->translatedFormat('m'));
                $processedData[]['month'] = Carbon::create()->month($i)->translatedFormat('F');
            }

            $coal_plans = CoalReceiptPlan::where('year', $year)->first();
            $i = 0;
            $initial_stock_realitation = $initialStock->planning;

            function getStock($coal_plans, $monthIndex)
            {
                if ($coal_plans) {
                    switch ($monthIndex) {
                        case 0:
                            return $coal_plans->planning_january;
                        case 1:
                            return $coal_plans->planning_february;
                        case 2:
                            return $coal_plans->planning_march;
                        case 3:
                            return $coal_plans->planning_april;
                        case 4:
                            return $coal_plans->planning_may;
                        case 5:
                            return $coal_plans->planning_june;
                        case 6:
                            return $coal_plans->planning_july;
                        case 7:
                            return $coal_plans->planning_august;
                        case 8:
                            return $coal_plans->planning_september;
                        case 9:
                            return $coal_plans->planning_october;
                        case 10:
                            return $coal_plans->planning_november;
                        case 11:
                            return $coal_plans->planning_december;
                        default:
                            break;
                    }
                }
                return 0;
            }

            foreach ($processedData as $monthKey => $value) {
                $bbm_unloading = CoalUnloading::select('receipt_date', 'tug_3_accept')->whereRaw('receipt_date like ?', ["%" . ("$year-$months[$i]") . "%"]);
                $bbm_unloading = $bbm_unloading->get();


                $processedData[$monthKey]['initial_stock_plan'] = $initialStock->planning;
                $processedData[$monthKey]['cumulative_stock_plan'] = $initialStock->planning;
                $processedData[$monthKey]['efective_stock_plan'] = $initialStock->planning - 158000;
                $processedData[0]['initial_stock_realitation'] = $initialStock->planning;

                if (count($bbm_unloading) > 0) {
                    $bbm_usage = CoalUsage::select('amount_use')->whereRaw('usage_date like ?', ['%' . "$year-$months[$i]" . '%'])->get();
                    foreach ($bbm_unloading as $key => $item) {
                        $receipt_date = date('Y-m', strtotime($item->receipt_date));
                        if ($receipt_date == ("$year-$months[$i]")) {
                            // Get BBM Usage with receipt date
                            // get All Unit Value

                            $processedData[$monthKey]['accept_plan'] = 0;
                            $processedData[$monthKey]['accept_realitation'] = intval($bbm_unloading->pluck('tug_3_accept')->sum());

                            $processedData[$monthKey]['usage_plan'] = getStock($coal_plans, $i);
                            $processedData[$monthKey]['usage_realitation'] = $bbm_usage->pluck('amount_use')->sum();
                        }
                    }
                }
                $initial_stock_realitation = $initial_stock_realitation + ($processedData[$monthKey]['accept_realitation'] ?? 0);
                if (isset($processedData[$monthKey + 1])) {
                    $processedData[$monthKey + 1]['initial_stock_realitation'] = $initial_stock_realitation;
                }

                $processedData[$monthKey]['cumulative_stock_realitation'] = $initial_stock_realitation;

                $processedData[$monthKey]['efective_stock_realitation'] = $initial_stock_realitation - 150000;

                $i++;
            }
        }
        $data['bbm_unloading'] = $processedData;

        return view('reports.executive-summary.bbm-monthly-usage-realitation', $data);
    }

    public function bbmRealitationCumulativeStock(Request $request)
    {
        $type = isset($_GET['type']) ? $_GET['type'] : 'day';
        $start_year = $request->get('start_year') ?? '';
        $end_year = $request->get('end_year') ?? '';
        $data['start_year'] = $start_year;
        $data['end_year'] = $end_year;

        $years = [];
        if ($start_year && $end_year) {
            for ($i = $start_year; $i <= $end_year; $i++) {
                array_push($years, $i);
            }
        }

        $type = $request->get('type') ?? '';
        $data['type'] = $type;

        $month = $request->get('month') ?? '';
        $data['month'] = $month;

        $year = $request->get('year') ?? '';
        $data['year'] = $year;


        function getDataByDay($month)
        {
            $processedData = [];

            function getStock($coal_plans, $monthIndex)
            {
                if ($coal_plans) {
                    switch ($monthIndex) {
                        case 0:
                            return $coal_plans->planning_january;
                        case 1:
                            return $coal_plans->planning_february;
                        case 2:
                            return $coal_plans->planning_march;
                        case 3:
                            return $coal_plans->planning_april;
                        case 4:
                            return $coal_plans->planning_may;
                        case 5:
                            return $coal_plans->planning_june;
                        case 6:
                            return $coal_plans->planning_july;
                        case 7:
                            return $coal_plans->planning_august;
                        case 8:
                            return $coal_plans->planning_september;
                        case 9:
                            return $coal_plans->planning_october;
                        case 10:
                            return $coal_plans->planning_november;
                        case 11:
                            return $coal_plans->planning_december;
                        default:
                            break;
                    }
                }
                return 0;
            }
            if ($month) {
                $dayArray = explode('-', $month);
                $year = $dayArray[0];
                $month = $dayArray[1];

                $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
                $daysArray = [];

                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $daysArray[] = Carbon::createFromDate($year, $month, $i)->format('Y-m-d');
                }


                $units = Unit::select('id')->get();
                $coal_plans = CoalReceiptPlan::where('year', $year)->first();
                $coal_plans = $coal_plans ? intval(getStock($coal_plans, intval($month) - 1)) : 0;

                foreach ($daysArray as $day) {
                    $processedData[$day] = [];
                    $bbm_unloading = CoalUnloading::select('receipt_date', 'tug_3_accept')->whereRaw('receipt_date like ?', ["%" . $day . "%"])->get();
                    if (count($bbm_unloading) > 0) {
                        foreach ($bbm_unloading as $key => $item) {
                            $receipt_date = date('Y-m-d', strtotime($item->receipt_date));
                            if ($receipt_date == $day) {
                                // Get BBM Usage with receipt date
                                $bbm_usage = CoalUsage::select('unit_id', 'amount_use')->whereRaw('usage_date like ?', ['%' . $receipt_date . '%'])->get();

                                // get All Unit Value
                                foreach ($units as $unit_key => $unit) {
                                    $index = "unit_" . ($unit_key + 1);
                                    $processedData[$day][$index] = 0;
                                    foreach ($bbm_usage as $usage) {
                                        if ($unit->id == $usage->unit_id) $processedData[$day][$index] = $processedData[$day][$index] + $usage->amount_use;
                                    }
                                    $processedData[$day][$index] = $processedData[$day][$index] ?? 0;
                                }


                                $processedData[$day]['receipt_date'] = $receipt_date;
                                $processedData[$day]['tug'] = $item->tug_3_accept;
                                $processedData[$day]['unit_5_7'] = array_sum([
                                    $processedData[$day]['unit_5'],
                                    $processedData[$day]['unit_6'],
                                    $processedData[$day]['unit_7']
                                ]);
                                $processedData[$day]['unit_1_7'] = array_sum([
                                    $processedData[$day]['unit_1'],
                                    $processedData[$day]['unit_2'],
                                    $processedData[$day]['unit_3'],
                                    $processedData[$day]['unit_4'],
                                    $processedData[$day]['unit_5'],
                                    $processedData[$day]['unit_6'],
                                    $processedData[$day]['unit_7']
                                ]);
                                $processedData[$day]['stock'] = $coal_plans + ($item->tug_3_accept - $processedData[$day]['unit_1_7']);
                            }
                        }
                    }
                }
            }

            return $processedData;
        }

        function getDataByMonth($year)
        {
            $processedData = [];
            $months = [];
            if ($year) {
                for ($i = 1; $i <= 12; $i++) {
                    array_push($months, Carbon::create()->month($i)->translatedFormat('m'));
                    $processedData[Carbon::create()->month($i)->translatedFormat('F')] = [];
                }

                $coal_plans = CoalReceiptPlan::where('year', $year)->first();
                $units = Unit::select('id')->get();
                $i = 0;

                function getStock($coal_plans, $monthIndex)
                {
                    if ($coal_plans) {
                        switch ($monthIndex) {
                            case 0:
                                return $coal_plans->planning_january;
                            case 1:
                                return $coal_plans->planning_february;
                            case 2:
                                return $coal_plans->planning_march;
                            case 3:
                                return $coal_plans->planning_april;
                            case 4:
                                return $coal_plans->planning_may;
                            case 5:
                                return $coal_plans->planning_june;
                            case 6:
                                return $coal_plans->planning_july;
                            case 7:
                                return $coal_plans->planning_august;
                            case 8:
                                return $coal_plans->planning_september;
                            case 9:
                                return $coal_plans->planning_october;
                            case 10:
                                return $coal_plans->planning_november;
                            case 11:
                                return $coal_plans->planning_december;
                            default:
                                break;
                        }
                    }
                    return 0;
                }
                foreach ($processedData as $month => $value) {
                    $receipt_date = "$year-$months[$i]";

                    $bbm_unloading = CoalUnloading::select('receipt_date', 'tug_3_accept')->whereRaw('receipt_date like ?', ["%" . ("$receipt_date") . "%"])->get();
                    $processedData[$month]['stock'] = $coal_plans ? getStock($coal_plans, $i) : 0;
                    $bbm_usage = CoalUsage::select('unit_id', 'amount_use')->whereRaw('usage_date like ?', ['%' . $receipt_date . '%'])->get();
                    if (count($bbm_unloading) > 0) {
                        // Get BBM Usage with receipt date
                        foreach ($bbm_unloading as $key => $item) {
                            if ($receipt_date == ("$year-$months[$i]")) {
                                // get All Unit Value
                                foreach ($units as $unit_key => $unit) {
                                    $index = "unit_" . ($unit_key + 1);
                                    $processedData[$month][$index] = 0;
                                    foreach ($bbm_usage as $usage) {
                                        if ($unit->id == $usage->unit_id) $processedData[$month][$index] = $processedData[$month][$index] + $usage->amount_use;
                                    }
                                    $processedData[$month][$index] = $processedData[$month][$index] ?? 0;
                                }


                                $processedData[$month]['receipt_date'] = date('d M Y', strtotime($item->receipt_date));
                                $processedData[$month]['tug'] = $bbm_unloading->pluck('tug_3_accept')->sum();
                                $processedData[$month]['unit_5_7'] = array_sum([
                                    $processedData[$month]['unit_5'],
                                    $processedData[$month]['unit_6'],
                                    $processedData[$month]['unit_7']
                                ]);
                                $processedData[$month]['unit_1_7'] = array_sum([
                                    $processedData[$month]['unit_1'],
                                    $processedData[$month]['unit_2'],
                                    $processedData[$month]['unit_3'],
                                    $processedData[$month]['unit_4'],
                                    $processedData[$month]['unit_5'],
                                    $processedData[$month]['unit_6'],
                                    $processedData[$month]['unit_7']
                                ]);
                            }
                        }
                    }
                    $i++;
                }
            }

            return $processedData;
        }

        function getDataByYear($years)
        {
            set_time_limit(100);
            $currentYear = Carbon::now()->year;
            $processedData = [];
            $units = Unit::select('id')->get();

            for ($i = 0; $i <= count($years); $i++) {
                if (isset($years[$i])) $processedData[$years[$i]] = [];
            }
            function getStock($coal_plans)
            {
                if ($coal_plans) {
                    return $coal_plans->planning_january + $coal_plans->planning_february + $coal_plans->planning_march + $coal_plans->planning_april + $coal_plans->planning_may + $coal_plans->planning_june + $coal_plans->planning_july + $coal_plans->planning_august + $coal_plans->planning_september + $coal_plans->planning_october + $coal_plans->planning_november + $coal_plans->planning_december;
                }
                return 0;
            }
            $bbm_usage = CoalUsage::select('unit_id', 'amount_use', 'usage_date')->get();
            $bbm_unloading = CoalUnloading::select('receipt_date', 'tug_3_accept')->get();
            foreach ($processedData as $year => $value) {
                $coal_plans = CoalReceiptPlan::where('year', $year)->first();
                $processedData[$year]['stock'] = $coal_plans ? getStock($coal_plans) : 0;
                if (count($bbm_unloading) > 0) {
                    $bbmUsage = collect($bbm_usage)->filter(function ($bbm) use ($year) {
                        return Str::contains($bbm->usage_date, $year);
                    });
                    $bbmUnloading = collect($bbm_unloading)->filter(function ($bbm) use ($year) {
                        return Str::contains($bbm->receipt_date, $year);
                    });
                    // foreach ($bbmUnloading as $key => $item) {
                    //     $receipt_date = date('Y', strtotime($item->receipt_date));
                    //     if ($receipt_date == ("$year")) {
                    // Get BBM Usage with receipt date
                    // get All Unit Value
                    foreach ($units as $unit_key => $unit) {
                        $index = "unit_" . ($unit_key + 1);
                        $processedData[$year][$index] = 0;
                        $processedData[$year][$index] = collect($bbmUsage)->where('unit_id', $unit->id)->pluck('amount_use')->sum();
                        // dd($test);
                        // foreach ($bbm_usage as $usage) {
                        //     dd($usage);
                        //     if ($unit->id == $usage->unit_id) {
                        //         $processedData[$year][$index] = $processedData[$year][$index] + $usage->amount_use;
                        //     }
                        // }
                        $processedData[$year][$index] = $processedData[$year][$index] ?? 0;
                    }


                    $processedData[$year]['receipt_date'] = $year;
                    $processedData[$year]['tug'] = $bbmUnloading->pluck('tug_3_accept')->sum();
                    $processedData[$year]['unit_5_7'] = array_sum([
                        $processedData[$year]['unit_5'],
                        $processedData[$year]['unit_6'],
                        $processedData[$year]['unit_7']
                    ]);
                    $processedData[$year]['unit_1_7'] = array_sum([
                        $processedData[$year]['unit_1'],
                        $processedData[$year]['unit_2'],
                        $processedData[$year]['unit_3'],
                        $processedData[$year]['unit_4'],
                        $processedData[$year]['unit_5'],
                        $processedData[$year]['unit_6'],
                        $processedData[$year]['unit_7']
                    ]);
                    //     }
                    // }
                }
                $i++;
            }
            return $processedData;
        }

        $processedData = [];

        if ($year || $month || $type) {
            switch ($type) {
                case 'month':
                    $processedData = getDataByMonth($year);
                    break;

                case 'year':
                    if ($start_year && $end_year) {
                        $processedData = getDataByYear($years);
                    }
                    break;

                default:
                    // day
                    $processedData = getDataByDay($month);
                    break;
            }
        }


        $data['bbm_unloading'] = $processedData;
        return view('reports.executive-summary.bbm-realitation-cumulative-stock', $data);
    }
}

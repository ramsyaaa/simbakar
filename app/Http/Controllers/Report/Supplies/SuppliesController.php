<?php

namespace App\Http\Controllers\Report\Supplies;

use App\BbmReceipt;
use App\BbmUsage;
use App\Http\Controllers\Controller;
use App\Models\YearStartData;
use App\Unit;
use DB;
use Illuminate\Http\Request;

class SuppliesController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.supplies.index');
    }

    public function bbmReceipt(Request $request, $type_bbm)
    {
        $filterType = null;
        $data['filter_type'] = $filterType;
        $validFilterTypes = ['day', 'month', 'year'];
        $validBbmTypes = ['HSD', 'MFO'];
        $validTypes = ['albes', 'unit', 'other'];
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
        $data['bbm_usage'] = [];

        $units = Unit::get();

        if($filterType != null){
            switch ($filterType) {
                case 'day':
                    $data = array_merge_recursive($data, $this->getKumulatif($tahun, $type_bbm));
                    $bulanIndex = ltrim($bulan, '0') - 1;
                    $data['bbm_receipt'] = $data['bbm_receipt'][ltrim($bulan, '0')];
                    $data['bbm_usage'] = $data['bbm_usage'][$bulanIndex];
                    if (ltrim($bulan, '0') > 1) {
                        $data['start_year_data_actual'] = end($data['cumulative'][ltrim($bulan, '0') - 1]);
                    }
                    $data['cumulative'] = $data['cumulative'][ltrim($bulan, '0')];  
                    $data['efective'] = $data['efective'][ltrim($bulan, '0')];
                    break;

                case 'month':
                    $data = array_merge_recursive($data, $this->getKumulatif($tahunInput, $type_bbm));
                    $bbm_usages = [];
                    $bbm_receipt = [];
                    $cumulative = [];
                    $efective = [];
                    foreach ($data['bbm_receipt'] as $key => $bbm) {
                        $bbm_receipt[] = array_sum($bbm);
                        $cumulative[] = end($data['cumulative'][$key]);
                        $efective[] = end($data['efective'][$key]);
                    }
                    $data['bbm_receipt'] = $bbm_receipt;
                    $data['cumulative'] = $cumulative;
                    $data['efective'] = $efective;

                    foreach ($data['bbm_usage'] as $index => $bbm_usage_month) {
                        $bbm_usage_in_one_month = [
                            "heavy_equipment" => 0,
                            "other" => 0,
                            "total" => 0,
                            "unit" => [
                                "unit_1" => 0,
                                "unit_2" => 0,
                                "unit_3" => 0,
                                "unit_4" => 0,
                                "unit1_4" => 0,
                                "unit_5" => 0,
                                "unit_6" => 0,
                                "unit_7" => 0,
                                "unit5_7" => 0,
                            ],
                        ];
                        foreach ($bbm_usage_month as $index2 => $bbm_usage) {
                            $bbm_usage_in_one_month["heavy_equipment"] += $bbm_usage['heavy_equipment'];
                            $bbm_usage_in_one_month["other"] += $bbm_usage['other'];
                            $bbm_usage_in_one_month["total"] += $bbm_usage['total'];

                            foreach ($bbm_usage['unit'] as $index3 => $unit) {
                                if($unit['unit_name'] == 1){
                                    $bbm_usage_in_one_month["unit"]['unit_1'] += $unit['total_amount'];
                                    $bbm_usage_in_one_month["unit"]['unit1_4'] += $unit['total_amount'];
                                }elseif($unit['unit_name'] == 2){
                                    $bbm_usage_in_one_month["unit"]['unit_2'] += $unit['total_amount'];
                                    $bbm_usage_in_one_month["unit"]['unit1_4'] += $unit['total_amount'];
                                }elseif($unit['unit_name'] == 3){
                                    $bbm_usage_in_one_month["unit"]['unit_3'] += $unit['total_amount'];
                                    $bbm_usage_in_one_month["unit"]['unit1_4'] += $unit['total_amount'];
                                }elseif($unit['unit_name'] == 4){
                                    $bbm_usage_in_one_month["unit"]['unit_4'] += $unit['total_amount'];
                                    $bbm_usage_in_one_month["unit"]['unit1_4'] += $unit['total_amount'];
                                }elseif($unit['unit_name'] == 5){
                                    $bbm_usage_in_one_month["unit"]['unit_5'] += $unit['total_amount'];
                                    $bbm_usage_in_one_month["unit"]['unit5_7'] += $unit['total_amount'];
                                }elseif($unit['unit_name'] == 6){
                                    $bbm_usage_in_one_month["unit"]['unit_6'] += $unit['total_amount'];
                                    $bbm_usage_in_one_month["unit"]['unit5_7'] += $unit['total_amount'];
                                }elseif($unit['unit_name'] == 7){
                                    $bbm_usage_in_one_month["unit"]['unit_7'] += $unit['total_amount'];
                                    $bbm_usage_in_one_month["unit"]['unit5_7'] += $unit['total_amount'];
                                }
                            }
                        }
                        $bbm_usages[] = $bbm_usage_in_one_month;
                    }

                    $data['bbm_usage'] = $bbm_usages;
                    break;


                case 'year':
                    $perYear = [];
                    $bbm_receipt = [];
                    for ($i = $startYear; $i <= $endYear; $i++) {
                        $dataPerYear = $this->getKumulatif($i, $type_bbm);
                        $perYear[$i]['start_year_data_actual'] = $dataPerYear['start_year_data_actual'];

                        $bbm_receipt_this_year = 0;

                        foreach ($dataPerYear['bbm_receipt'] as $receipt) {
                            if (is_array($receipt)) {
                                $bbm_receipt_this_year += array_sum($receipt);
                            }
                        }

                        $bbm_receipt[$i] = $bbm_receipt_this_year;

                        foreach ($dataPerYear['bbm_usage'] as $index => $bbm_usage_month) {
                            $bbm_usage_in_one_month = [
                                "heavy_equipment" => 0,
                                "other" => 0,
                                "total" => 0,
                                "unit" => [
                                    "unit_1" => 0,
                                    "unit_2" => 0,
                                    "unit_3" => 0,
                                    "unit_4" => 0,
                                    "unit1_4" => 0,
                                    "unit_5" => 0,
                                    "unit_6" => 0,
                                    "unit_7" => 0,
                                    "unit5_7" => 0,
                                ],
                            ];
                            foreach ($bbm_usage_month as $index2 => $bbm_usage) {
                                $bbm_usage_in_one_month["heavy_equipment"] += $bbm_usage['heavy_equipment'];
                                $bbm_usage_in_one_month["other"] += $bbm_usage['other'];
                                $bbm_usage_in_one_month["total"] += $bbm_usage['total'];

                                foreach ($bbm_usage['unit'] as $index3 => $unit) {
                                    if($unit['unit_name'] == 1){
                                        $bbm_usage_in_one_month["unit"]['unit_1'] += $unit['total_amount'];
                                        $bbm_usage_in_one_month["unit"]['unit1_4'] += $unit['total_amount'];
                                    }elseif($unit['unit_name'] == 2){
                                        $bbm_usage_in_one_month["unit"]['unit_2'] += $unit['total_amount'];
                                        $bbm_usage_in_one_month["unit"]['unit1_4'] += $unit['total_amount'];
                                    }elseif($unit['unit_name'] == 3){
                                        $bbm_usage_in_one_month["unit"]['unit_3'] += $unit['total_amount'];
                                        $bbm_usage_in_one_month["unit"]['unit1_4'] += $unit['total_amount'];
                                    }elseif($unit['unit_name'] == 4){
                                        $bbm_usage_in_one_month["unit"]['unit_4'] += $unit['total_amount'];
                                        $bbm_usage_in_one_month["unit"]['unit1_4'] += $unit['total_amount'];
                                    }elseif($unit['unit_name'] == 5){
                                        $bbm_usage_in_one_month["unit"]['unit_5'] += $unit['total_amount'];
                                        $bbm_usage_in_one_month["unit"]['unit5_7'] += $unit['total_amount'];
                                    }elseif($unit['unit_name'] == 6){
                                        $bbm_usage_in_one_month["unit"]['unit_6'] += $unit['total_amount'];
                                        $bbm_usage_in_one_month["unit"]['unit5_7'] += $unit['total_amount'];
                                    }elseif($unit['unit_name'] == 7){
                                        $bbm_usage_in_one_month["unit"]['unit_7'] += $unit['total_amount'];
                                        $bbm_usage_in_one_month["unit"]['unit5_7'] += $unit['total_amount'];
                                    }
                                }
                            }
                            $bbm_usages[] = $bbm_usage_in_one_month;
                        }
                        
                        $final_bbm_usage=[];
                        $bbm_usage_in_one_month = [
                            "heavy_equipment" => 0,
                            "other" => 0,
                            "total" => 0,
                            "unit" => [
                                "unit_1" => 0,
                                "unit_2" => 0,
                                "unit_3" => 0,
                                "unit_4" => 0,
                                "unit1_4" => 0,
                                "unit_5" => 0,
                                "unit_6" => 0,
                                "unit_7" => 0,
                                "unit5_7" => 0,
                            ],
                        ];
                        foreach ($bbm_usages as $index2 => $bbm_usage) {
                            $bbm_usage_in_one_month["heavy_equipment"] += $bbm_usage['heavy_equipment'];
                            $bbm_usage_in_one_month["other"] += $bbm_usage['other'];
                            $bbm_usage_in_one_month["total"] += $bbm_usage['total'];

                            $bbm_usage_in_one_month["unit"]['unit_1'] += $bbm_usage['unit']['unit_1'];
                            $bbm_usage_in_one_month["unit"]['unit_2'] += $bbm_usage['unit']['unit_2'];
                            $bbm_usage_in_one_month["unit"]['unit_3'] += $bbm_usage['unit']['unit_3'];
                            $bbm_usage_in_one_month["unit"]['unit_4'] += $bbm_usage['unit']['unit_4'];
                            $bbm_usage_in_one_month["unit"]['unit1_4'] += $bbm_usage['unit']['unit1_4'];
                            $bbm_usage_in_one_month["unit"]['unit_5'] += $bbm_usage['unit']['unit_5'];
                            $bbm_usage_in_one_month["unit"]['unit_6'] += $bbm_usage['unit']['unit_6'];
                            $bbm_usage_in_one_month["unit"]['unit_7'] += $bbm_usage['unit']['unit_7'];
                            $bbm_usage_in_one_month["unit"]['unit5_7'] += $bbm_usage['unit']['unit5_7'];
                        }

                        $perYear[$i]['bbm_usage'] = $bbm_usage_in_one_month;
                        $perYear[$i]['cumulative'] = end($dataPerYear['cumulative']);
                        $perYear[$i]['cumulative'] = end($perYear[$i]['cumulative']);

                        $perYear[$i]['efective'] = end($dataPerYear['efective']);
                        $perYear[$i]['efective'] = end($perYear[$i]['efective']);
                    }
                    $bbm_usages = [];
                    $cumulative = [];
                    $efective = [];

                    foreach ($perYear as $index => $item) {
                        $bbm_usages[$index] = $item['bbm_usage'];
                        $cumulative[$index] = $item['cumulative'];
                        $efective[$index] = $item['efective'];
                    }

                    $data['bbm_usage'] = $bbm_usages;
                    $data['bbm_receipt'] = $bbm_receipt;
                    $data['cumulative'] = $cumulative;
                    $data['efective'] = $efective;
                    
                    break;
            }
        }
        return view('reports.supplies.bbm_usage', $data);
    }

    public function getKumulatif($tahun = 2024, $type = 'solar')
    {
        $data = [];

        $getStartYearData = YearStartData::where([
            'type' => $type,
            'year' => $tahun,
        ])->first();

        $start_data_planning = isset($getStartYearData->planning) ? $getStartYearData->planning : 0;
        $start_data_actual = isset($getStartYearData->actual) ? $getStartYearData->actual : 0;

        $data['start_year_data_planning'] = $start_data_planning;
        $data['start_year_data_actual'] = $start_data_actual;

        // Loop untuk setiap bulan dari Januari hingga Desember
        for ($bulan = 1; $bulan <= 12; $bulan++) {

            $queryBbmReceipt = BbmReceipt::query();
            $queryBbmUsage = BbmUsage::query();
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            $daysBbmReceiptArray = [];
            $daysBbmUsageArray = [];

            // Inisialisasi array untuk setiap hari dalam bulan
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = sprintf('%04d-%02d-%02d', $tahun, $bulan, $day);
                $daysBbmReceiptArray[$date] = 0.0;
                $daysBbmUsageArray[$date] = 0.0;
            }

            // Query untuk penerimaan BBM
            $queryBbmReceipt->selectRaw('DATE(date_receipt) as date, SUM(amount_receipt) as total_amount')
                ->whereYear('date_receipt', $tahun)
                ->whereMonth('date_receipt', $bulan)
                ->where('bbm_type', $type)
                ->groupBy('date');

            // Query untuk heavy_equipment dan other
            $queryBbmUsage = DB::table('bbm_usages')
            ->selectRaw('
                DATE(use_date) as date,
                SUM(CASE WHEN bbm_use_for = "heavy_equipment" THEN amount ELSE 0 END) as heavy_equipment,
                SUM(CASE WHEN bbm_use_for = "other" THEN amount ELSE 0 END) as other
            ')
            ->whereYear('use_date', $tahun)
            ->whereMonth('use_date', $bulan)
            ->where('bbm_type', $type)
            ->groupBy('date');

            // Query untuk unit dengan join ke tabel units untuk mendapatkan nama unit
            $unitQuery = DB::table('bbm_usages')
            ->selectRaw('
                DATE(use_date) as date,
                units.name,
                bbm_usages.unit_uuid,
                SUM(amount) as total_amount_unit
            ')
            ->join('units', 'bbm_usages.unit_uuid', '=', 'units.uuid')
            ->whereYear('use_date', $tahun)
            ->whereMonth('use_date', $bulan)
            ->where('bbm_type', $type)
            ->where('bbm_use_for', 'unit')
            ->groupBy('date', 'bbm_usages.unit_uuid', 'units.name');

            $bbmReceiptResults = $queryBbmReceipt->get();
            $bbmUsageResults = $queryBbmUsage->get();
            $unitUsageResults = $unitQuery->get();

            foreach ($bbmReceiptResults as $result) {
                $daysBbmReceiptArray[$result->date] = $result->total_amount;
            }

            // Menggabungkan hasil dari kedua query untuk format yang diinginkan
            $results = [];
            foreach ($bbmUsageResults as $usage) {
                // Filter unit usage berdasarkan tanggal
                $unitList = $unitUsageResults->where('date', $usage->date)
                    ->map(function ($unit) {
                        return [
                            'unit_name' => $unit->name,
                            'total_amount' => $unit->total_amount_unit,
                        ];
                    })->values()->toArray();

                // Menghitung total amount untuk unit pada tanggal tersebut
                $totalUnitAmount = $unitList ? array_sum(array_column($unitList, 'total_amount')) : 0;

                // Menghitung total keseluruhan
                $total = $totalUnitAmount + $usage->heavy_equipment + $usage->other;

                // Menyusun data ke dalam array hasil dengan date sebagai key
                $results[$usage->date] = [
                    'heavy_equipment' => $usage->heavy_equipment,
                    'other' => $usage->other,
                    'unit' => $unitList,
                    'total' => $total, // Total keseluruhan
                ];
            }
            
            // Memasukkan data ke dalam array hasil untuk bulan saat ini
            $data['bbm_receipt'][$bulan] = array_values($daysBbmReceiptArray);
            $data['bbm_usage'][$bulan] = array_values($results);

            $efective_actual = [];
            $cumulative_actual = [];
            foreach ($data['bbm_receipt'][$bulan] as $date => $receipt) {
                $total = $data['bbm_usage'][$bulan][$date]['total'] ?? 0;
                $efective_actual[$date] = $start_data_actual + $receipt - $total;
                $cumulative_actual[$date] = $efective_actual[$date];
                $start_data_actual = $efective_actual[$date];
            }
            $data['efective'][$bulan] = array_values($efective_actual);
            $data['cumulative'][$bulan] = array_values($cumulative_actual);
        }
        return $data;
    }
}

<?php

namespace App\Http\Controllers\Report\Supplies;

use App\BbmReceipt;
use App\BbmUsage;
use App\Http\Controllers\Controller;
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

        $queryBbmUsage = BbmUsage::query();
        $queryBbmReceipt = BbmReceipt::query();
        $data['bbm_usage'] = [];

        $units = Unit::get();

        if($filterType != null){
            switch ($filterType) {
                case 'day':
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                    $groupedDay = array_fill(0, $daysInMonth, 0.0);

                    foreach ($groupedDay as $key => $item) {
                        $i = $key + 1;
                        $queryBbmUsage->whereDate('use_date', '=', "$tahun-$bulan-$i");

                        // Mengambil data yang dikelompokkan berdasarkan bbm_use_for
                        $bbmUsageResults = $queryBbmUsage->select('bbm_use_for', 'heavy_equipment_uuid', 'unit_uuid', DB::raw('SUM(amount) as total_amount'))
                            ->where(['bbm_type' => $type_bbm])
                            ->groupBy('bbm_use_for', 'heavy_equipment_uuid', 'unit_uuid')
                            ->get();

                        // Menginisialisasi array hasil akhir
                        $groupedData = [
                            'heavy_equipment' => 0.0,
                            'unit' => [],
                            'other' => 0.0,
                        ];

                        // Mengelompokkan data
                        foreach ($bbmUsageResults as $result) {
                            switch ($result->bbm_use_for) {
                                case 'heavy_equipment':
                                    // Untuk heavy_equipment, jumlahkan semua amount
                                    $groupedData['heavy_equipment'] += $result->total_amount;
                                    break;

                                case 'unit':
                                    // Untuk unit, kelompokkan berdasarkan unit_uuid dan jumlahkan amount
                                    $uuid = $result->unit_uuid;
                                    if (!isset($groupedData['unit'][$uuid])) {
                                        $groupedData['unit'][$uuid] = 0.0;
                                    }
                                    $groupedData['unit'][$uuid] += $result->total_amount;
                                    break;

                                case 'other':
                                    // Untuk other, jumlahkan semua amount
                                    $groupedData['other'] += $result->total_amount;
                                    break;
                            }
                        }

                        // Output hasil
                        $listUnits = [];
                        foreach ($units as $index => $unit) {
                            if(isset($groupedData['unit'][$unit->uuid])){
                                $listUnits[$unit->name] = $groupedData['unit'][$unit->uuid];
                            }else{
                                $listUnits[$unit->name] = 0.0;
                            }
                        }
                        $groupedData['unit'] = $listUnits;
                        $data['bbm_usage'][] = $groupedData;
                    }

                    $bbmReceiptResults = $queryBbmReceipt->select(DB::raw('DAY(date_receipt) as day'), DB::raw('SUM(amount_receipt) as total_amount'))
                            ->where(['bbm_type' => $type_bbm])
                            ->whereYear('date_receipt', $tahun)
                            ->whereMonth('date_receipt', $bulan)
                            ->groupBy('day')
                            ->orderBy('day')
                            ->get();

                        // Menginisialisasi array hasil akhir
                        $groupedData = [];

                        // Menginisialisasi array dengan semua hari pada bulan tersebut
                        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                        $groupedData = array_fill(1, $daysInMonth, 0.0);

                        // Mengisi data berdasarkan hasil query
                        foreach ($bbmReceiptResults as $result) {
                            $day = $result->day; // Ambil hari dari hasil query
                            $groupedData[$day] = $result->total_amount; // Isi nilai pada hari tersebut
                        }
                    $data['bbm_receipt'] = array_values($groupedData);
                    break;

                case 'month':
                    $groupedBbmUsage = [];
                    $groupedBbmReceipt = [];

                    for ($bulanInput = 1; $bulanInput <= 12; $bulanInput++) {
                        $bbmUsageResults = BbmUsage::select('bbm_use_for', 'heavy_equipment_uuid', 'unit_uuid', DB::raw('SUM(amount) as total_amount'))
                            ->where(['bbm_type' => $type_bbm])
                            ->whereYear('use_date', $tahunInput)
                            ->whereMonth('use_date', $bulanInput)
                            ->groupBy('bbm_use_for', 'heavy_equipment_uuid', 'unit_uuid')
                            ->get();

                        // Menginisialisasi array hasil akhir untuk bbm_usage
                        $groupedData = [
                            'heavy_equipment' => 0.0,
                            'unit' => [],
                            'other' => 0.0,
                        ];

                        // Mengelompokkan dan menjumlahkan data bbm_usage
                        foreach ($bbmUsageResults as $result) {
                            switch ($result->bbm_use_for) {
                                case 'heavy_equipment':
                                    // Untuk heavy_equipment, jumlahkan semua amount
                                    $groupedData['heavy_equipment'] += $result->total_amount;
                                    break;

                                case 'unit':
                                    // Untuk unit, kelompokkan berdasarkan unit_uuid dan jumlahkan amount
                                    $uuid = $result->unit_uuid;
                                    if (!isset($groupedData['unit'][$uuid])) {
                                        $groupedData['unit'][$uuid] = 0.0;
                                    }
                                    $groupedData['unit'][$uuid] += $result->total_amount;
                                    break;

                                case 'other':
                                    // Untuk other, jumlahkan semua amount
                                    $groupedData['other'] += $result->total_amount;
                                    break;
                            }
                        }

                        // Output hasil untuk bbm_usage
                        $listUnits = [];
                        foreach ($units as $unit) {
                            if (isset($groupedData['unit'][$unit->uuid])) {
                                $listUnits[$unit->name] = $groupedData['unit'][$unit->uuid];
                            } else {
                                $listUnits[$unit->name] = 0.0;
                            }
                        }
                        $groupedData['unit'] = $listUnits;
                        $groupedBbmUsage[$bulanInput] = $groupedData;

                        // Mengambil data bbm_receipt yang dikelompokkan berdasarkan bulan
                        $totalAmountReceipt = BbmReceipt::whereYear('date_receipt', $tahunInput)
                            ->where(['bbm_type' => $type_bbm])
                            ->whereMonth('date_receipt', $bulanInput)
                            ->sum('amount_receipt');

                        // Menyimpan jumlah total amount_receipt untuk bulan tersebut
                        $groupedBbmReceipt[$bulanInput] = $totalAmountReceipt;
                    }

                    // Assign the final data to the output array
                    $data['bbm_usage'] = array_values($groupedBbmUsage);
                    $data['bbm_receipt'] = array_values($groupedBbmReceipt);

                    break;


                case 'year':
                    $startDate = $startYear . '-01-01';
                    $endDate = $endYear . '-12-31 23:59:59';

                    // Inisialisasi array untuk menampung hasil akhir
                    $groupedBbmUsage = [];
                    $groupedBbmReceipt = [];

                    // Iterasi berdasarkan tahun dalam rentang yang diberikan
                    for ($tahunInput = $startYear; $tahunInput <= $endYear; $tahunInput++) {
                        // Query untuk penggunaan BBM (bbm_usage) yang dikelompokkan berdasarkan tahun
                        $bbmUsageResults = BbmUsage::select('bbm_use_for', 'heavy_equipment_uuid', 'unit_uuid', DB::raw('SUM(amount) as total_amount'))
                            ->where(['bbm_type' => $type_bbm])
                            ->whereYear('use_date', $tahunInput)
                            ->whereBetween('use_date', [$startDate, $endDate])
                            ->groupBy('bbm_use_for', 'heavy_equipment_uuid', 'unit_uuid')
                            ->get();

                        // Menginisialisasi array hasil akhir untuk bbm_usage
                        $groupedData = [
                            'heavy_equipment' => 0.0,
                            'unit' => [],
                            'other' => 0.0,
                        ];

                        // Mengelompokkan dan menjumlahkan data bbm_usage
                        foreach ($bbmUsageResults as $result) {
                            switch ($result->bbm_use_for) {
                                case 'heavy_equipment':
                                    // Untuk heavy_equipment, jumlahkan semua amount
                                    $groupedData['heavy_equipment'] += $result->total_amount;
                                    break;

                                case 'unit':
                                    // Untuk unit, kelompokkan berdasarkan unit_uuid dan jumlahkan amount
                                    $uuid = $result->unit_uuid;
                                    if (!isset($groupedData['unit'][$uuid])) {
                                        $groupedData['unit'][$uuid] = 0.0;
                                    }
                                    $groupedData['unit'][$uuid] += $result->total_amount;
                                    break;

                                case 'other':
                                    // Untuk other, jumlahkan semua amount
                                    $groupedData['other'] += $result->total_amount;
                                    break;
                            }
                        }

                        // Output hasil untuk bbm_usage
                        $listUnits = [];
                        foreach ($units as $unit) {
                            if (isset($groupedData['unit'][$unit->uuid])) {
                                $listUnits[$unit->name] = $groupedData['unit'][$unit->uuid];
                            } else {
                                $listUnits[$unit->name] = 0.0;
                            }
                        }
                        $groupedData['unit'] = $listUnits;
                        $groupedBbmUsage[$tahunInput] = $groupedData;

                        // Mengambil data bbm_receipt yang dikelompokkan berdasarkan tahun
                        $totalAmountReceipt = BbmReceipt::whereYear('date_receipt', $tahunInput)
                            ->where(['bbm_type' => $type_bbm])
                            ->whereBetween('date_receipt', [$startDate, $endDate])
                            ->sum('amount_receipt');

                        // Menyimpan jumlah total amount_receipt untuk tahun tersebut
                        $groupedBbmReceipt[$tahunInput] = $totalAmountReceipt;
                    }

                    // Assign the final data to the output array
                    $data['bbm_usage'] = array_values($groupedBbmUsage);
                    $data['bbm_receipt'] = array_values($groupedBbmReceipt);

                    break;
            }
        }
        return view('reports.supplies.bbm_usage', $data);
    }
}

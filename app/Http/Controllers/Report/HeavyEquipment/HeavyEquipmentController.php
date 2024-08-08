<?php

namespace App\Http\Controllers\Report\HeavyEquipment;

use App\BbmUsage;
use App\HeavyEquipment;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class HeavyEquipmentController extends Controller
{
    // public function index(Request $request)
    // {
    //     return view('reports.heavy-equipment.index');
    // }

    public function index(Request $request, $type, $type_bbm)
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

        $queryBbmUsage = BbmUsage::query();
        $data['bbm_usage'] = [];
        switch ($filterType) {
            case 'day':
                $bbmUsageResults = $queryBbmUsage->select('heavy_equipment_uuid', DB::raw('DATE(use_date) as date'), DB::raw('SUM(amount) as total_amount'))
                    ->where('bbm_use_for', 'heavy_equipment')
                    ->whereYear('use_date', $tahun)
                    ->whereMonth('use_date', $bulan)
                    ->groupBy('heavy_equipment_uuid', 'date')
                    ->get();

                // Menghitung jumlah hari dalam bulan tersebut
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

                // Menginisialisasi array hasil akhir
                $groupedData = [];

                // Menginisialisasi array dengan semua tanggal pada bulan tersebut
                foreach ($bbmUsageResults as $result) {
                    $uuid = $result->heavy_equipment_uuid;

                    if (!isset($groupedData[$uuid])) {
                        // Buat array untuk setiap heavy_equipment_uuid dengan semua tanggal diisi dengan 0.0
                        $groupedData[$uuid] = array_fill(1, $daysInMonth, 0.0);
                    }

                    // Ambil hari dari tanggal (format YYYY-MM-DD)
                    $day = (int)date('j', strtotime($result->date));
                    $groupedData[$uuid][$day] = $result->total_amount;
                }

                $getHeavyEquipment = HeavyEquipment::get();

                foreach ($getHeavyEquipment as $key => $value) {
                    if(isset($groupedData[$value->uuid])){
                        $data['bbm_usage'][$value->name] = array_values($groupedData[$value->uuid]);
                    }else{
                        $data['bbm_usage'][$value->name] = array_fill(1, $daysInMonth, 0.0);
                    }
                }

                break;

            case 'month':
                $bbmUsageResults = $queryBbmUsage->select('heavy_equipment_uuid', DB::raw('YEAR(use_date) as year'), DB::raw('MONTH(use_date) as month'), DB::raw('SUM(amount) as total_amount'))
                    ->where('bbm_use_for', 'heavy_equipment')
                    ->whereYear('use_date', $tahunInput)
                    ->groupBy('heavy_equipment_uuid', 'year', 'month')
                    ->get();

                // Menginisialisasi array hasil akhir
                $groupedData = [];

                // Menginisialisasi array dengan semua bulan pada tahun tersebut
                foreach ($bbmUsageResults as $result) {
                    $uuid = $result->heavy_equipment_uuid;

                    if (!isset($groupedData[$uuid])) {
                        // Buat array untuk setiap heavy_equipment_uuid dengan semua bulan diisi dengan 0.0
                        $groupedData[$uuid] = array_fill(1, 12, 0.0);
                    }

                    // Ambil bulan dari hasil query
                    $month = $result->month;
                    $groupedData[$uuid][$month] = $result->total_amount;

                    $getHeavyEquipment = HeavyEquipment::get();

                    foreach ($getHeavyEquipment as $key => $value) {
                        if(isset($groupedData[$value->uuid])){
                            $data['bbm_usage'][$value->name] = $groupedData[$value->uuid];
                        }else{
                            $data['bbm_usage'][$value->name] = array_fill(1, 12, 0.0);
                        }
                    }
                }

                $getHeavyEquipment = HeavyEquipment::get();

                foreach ($getHeavyEquipment as $key => $value) {
                    if (isset($groupedData[$value->uuid])) {
                        $data['bbm_usage'][$value->name] = array_values($groupedData[$value->uuid]);
                    } else {
                        $data['bbm_usage'][$value->name] = array_fill(1, 12, 0.0);
                    }
                }
                break;


            case 'year':
                $startDate = $startYear . '-01-01';
                $endDate = $endYear . '-12-31 23:59:59';

                // Query untuk usage berdasarkan range tahun
                $bbmUsageResults = $queryBbmUsage->select('heavy_equipment_uuid', DB::raw('YEAR(use_date) as year'), DB::raw('SUM(amount) as total_amount'))
                    ->whereBetween('use_date', [$startDate, $endDate])
                    ->where('bbm_use_for', 'heavy_equipment')
                    ->groupBy('heavy_equipment_uuid', 'year')
                    ->get();

                // Menginisialisasi array hasil akhir
                $groupedData = [];

                // Inisialisasi array dengan semua tahun dalam range yang diberikan
                foreach ($bbmUsageResults as $result) {
                    $uuid = $result->heavy_equipment_uuid;

                    if (!isset($groupedData[$uuid])) {
                        // Buat array untuk setiap heavy_equipment_uuid dengan semua tahun diisi dengan 0.0
                        $groupedData[$uuid] = array_fill($startYear, ($endYear - $startYear + 1), 0.0);
                    }

                    // Ambil tahun dari hasil query
                    $year = $result->year;
                    $groupedData[$uuid][$year] = $result->total_amount;
                }

                $getHeavyEquipment = HeavyEquipment::get();

                foreach ($getHeavyEquipment as $key => $value) {
                    if (isset($groupedData[$value->uuid])) {
                        $data['bbm_usage'][$value->name] = array_values($groupedData[$value->uuid]);
                    } else {
                        // Jika tidak ada data untuk equipment tertentu, isi dengan 0.0 untuk setiap tahun dalam range
                        $data['bbm_usage'][$value->name] = array_fill(1, ($endYear - $startYear + 1), 0.0);
                    }
                }
                break;
        }
        return view('reports.heavy-equipment.index', $data);
    }
}

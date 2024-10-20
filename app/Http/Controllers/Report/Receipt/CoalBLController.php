<?php

namespace App\Http\Controllers\Report\Receipt;

use App\Dock;
use App\Ship;
use stdClass;
use App\BbmReceipt;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CoalBLController extends Controller
{

    public function index(Request $request)
    {
        $data['docks'] = Dock::all();
        $data['ships'] = Ship::all();
        $filterType = $request->filter_type;
        $data['filter_type'] = $filterType;
        $validFilterTypes = ['day', 'month', 'year'];
        if($request->has('filter_type')){

            switch ($filterType) {
                case 'day':
                    $bulan = $request->bulan_tahun ?? date('Y-m');
                    $date = explode('-', $bulan);
                    $coals = CoalUnloading::with('ship','supplier')
                    ->when($request->dock_id, function ($query) use ($request) {
                        $query->where('dock_id', $request->dock_id);
                    })
                    ->when($request->ship_id, function ($query) use ($request) {
                        $query->where('ship_id', $request->ship_id);
                    })
                    ->whereMonth('receipt_date',$date[1])
                    ->whereYear('receipt_date',$date[0])
                    ->get()
                    ->map(function($item){

                        $selisih = $item->bl - $item->ds;
                        $item->selisih_bl = $selisih ;
                        $item->selisih_bl_percentage = ($selisih/$item->bl) * 100 ;

                        $selisihBW = $item->ds - $item->bw;
                        $item->selisih_bw = $item->ds;
                        $item->selisih_bw_percentage = 100 ;

                        return $item;
                    });
                    $data['coals'] = $coals;
                    break;

                case 'month':
                    $year = $request->input('tahun', date('Y'));

                    $usage = CoalUnloading::select(
                        DB::raw('MONTH(receipt_date) as bulan'),
                        DB::raw('SUM(tug_3_accept) as total_per_bulan'),
                        DB::raw('SUM(bl) as total_bl'),
                        DB::raw('SUM(ds) as total_ds')
                    )
                    ->when($request->dock_id, function ($query) use ($request) {
                        $query->where('dock_id', $request->dock_id);
                    })
                    ->when($request->ship_id, function ($query) use ($request) {
                        $query->where('ship_id', $request->ship_id);
                    })
                    ->whereYear('receipt_date', '=', $year)
                    ->groupBy('bulan')
                    ->get();

                    $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                    // Inisialisasi array kosong dengan 12 bulan
                    $processedCoals = array_fill(1, 12, null);

                    // Proses data usage menjadi array per bulan
                    foreach ($usage as $item) {
                        $result = new stdClass();
                        $result->label = $labels[$item->bulan - 1];  // Ambil label berdasarkan bulan
                        $selisihBl = $item->total_bl - $item->total_ds;
                        $selisihBlPercen = ($selisihBl / $item->total_bl) * 100;
                        $result->bl = (int)$item->total_bl;
                        $result->selisih_bl = $selisihBl;
                        $result->selisih_bl_percentage = $selisihBlPercen;
                        $result->ds = (int)$item->total_ds;
                        $result->selisih_bw = (int)$item->total_ds;
                        $result->selisih_bw_percentage = 100;

                        $result->tug_3_accept = (int)$item->total_per_bulan;

                        // Masukkan hasil ke array $processedCoals berdasarkan bulan
                        $processedCoals[(int)$item->bulan] = $result;
                    }

                    // Mengisi bulan yang tidak ada datanya dengan nilai default
                    foreach ($processedCoals as $bulan => $item) {
                        if ($item === null) {
                            $result = new stdClass();
                            $result->label = $labels[$bulan - 1]; // Ambil label sesuai dengan bulan
                            $result->bl = 0;
                            $result->selisih_bl =0;
                            $result->selisih_bl_percentage = 0;
                            $result->ds = 0;
                            $result->selisih_bw = 0;
                            $result->selisih_bw_percentage = 0;
                            $result->tug_3_accept = 0;

                            $processedCoals[$bulan] = $result;
                        }
                    }

                    // Output array $processedCoals
                    $data['coals'] = $processedCoals;
                    // Buat struktur data untuk Chart.js
                   
                    break;


                case 'year':

                    $startYear = $request->input('start_year', date('Y'));
                    $endYear = $request->input('end_year', date('Y'));

                    $year = $request->input('tahun', date('Y'));

                    // Ambil usage berdasarkan tahun
                    $usage = CoalUnloading::select(
                        DB::raw('YEAR(receipt_date) as tahun'),  // Kelompokkan berdasarkan tahun
                        DB::raw('SUM(tug_3_accept) as total_per_tahun'),
                        DB::raw('SUM(bl) as total_bl'),
                        DB::raw('SUM(ds) as total_ds')
                    )
                    ->when($request->dock_id, function ($query) use ($request) {
                        $query->where('dock_id', $request->dock_id);
                    })
                    ->when($request->ship_id, function ($query) use ($request) {
                        $query->where('ship_id', $request->ship_id);
                    })
                    ->whereYear('receipt_date', '>=', $startYear)
                    ->whereYear('receipt_date', '<=', $endYear)
                    ->groupBy('tahun')  // Group berdasarkan tahun
                    ->get();

                    // Inisialisasi array kosong dengan rentang tahun dari startYear ke endYear
                    $processedCoals = array_fill($startYear, $endYear - $startYear + 1, null);

                    // Proses data usage menjadi array per tahun
                    foreach ($usage as $item) {
                        $result = new stdClass();
                        $result->label = $item->tahun;  // Gunakan tahun sebagai label
                        $selisihBl = $item->total_bl - $item->total_ds;
                        $selisihBlPercen = ($selisihBl / $item->total_bl) * 100;
                        $result->bl = (int)$item->total_bl;
                        $result->selisih_bl = $selisihBl;
                        $result->selisih_bl_percentage = $selisihBlPercen;
                        $result->ds = (int)$item->total_ds;
                        $result->selisih_bw = (int)$item->total_ds;
                        $result->selisih_bw_percentage = 100;

                        $result->tug_3_accept = (int)$item->total_per_tahun;

                        // Masukkan hasil ke array $processedCoals berdasarkan tahun
                        $processedCoals[(int)$item->tahun] = $result;
                    }
                    // Mengisi tahun yang tidak ada datanya dengan nilai default
                    for ($year = $startYear; $year <= $endYear; $year++) {
                        if ($processedCoals[$year] === null) {
                            $result = new stdClass();
                            $result->label = $year;  // Gunakan tahun sesuai dengan rentang
                            $result->bl = 0;
                            $result->selisih_bl = 0;
                            $result->selisih_bl_percentage = 0;
                            $result->ds = 0;
                            $result->selisih_bw = 0;
                            $result->selisih_bw_percentage = 0;
                            $result->tug_3_accept = 0;

                            $processedCoals[$year] = $result;
                        }
                    }

                    // Output array $processedCoals
                    $data['coals'] = $processedCoals;

                    break;
                
            }
            $data['dermaga'] = Dock::where('id',$request->dock_id)->first();
            $data['kapal'] = Ship::where('id',$request->ship_id)->first();

            // dd($data);
        }        

        return view('reports.receipt.coal-bl', $data);
    }
}

   


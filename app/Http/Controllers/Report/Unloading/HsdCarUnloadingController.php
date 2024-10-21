<?php

namespace App\Http\Controllers\Report\Unloading;

use App\BbmReceipt;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HsdCarUnloadingController extends Controller
{
    public function index(Request $request){
        $month = $request->month ?? Carbon::now()->format('Y-m'); // Mengambil nilai bulan dari request atau default ke bulan saat ini
        $data['month'] = $month;
        // Ekstrak tahun dan bulan dari input dengan format YYYY-MM
        list($year, $month) = explode('-', $month);

        $data['bbm_receipts'] = BbmReceipt::where([
                'shipment_type' => 'car',
                'bbm_type' => 'solar',
            ])
            ->whereYear('date_receipt', $year) // Filter berdasarkan tahun
            ->whereMonth('date_receipt', $month) // Filter berdasarkan bulan
            ->get();
        return view('reports.unloading.hsd-car-unloading', $data);
    }
}

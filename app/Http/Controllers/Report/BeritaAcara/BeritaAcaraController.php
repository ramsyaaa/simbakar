<?php

namespace App\Http\Controllers\Report\BeritaAcara;

use App\BbmReceipt;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BeritaAcaraController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.berita-acara.index');
    }

    public function bbm(Request $request){
        $month = $request->month ?? Carbon::now()->format('Y-m'); // Mengambil nilai bulan dari request atau default ke bulan saat ini
        $bbm_type = $request->bbm_type ?? 'solar';

        if($bbm_type != 'solar' && $bbm_type != 'residu'){
            $bbm_type = 'solar';
        }
        $data['bbm_type'] = $bbm_type;
        $data['month'] = $month;
        // Ekstrak tahun dan bulan dari input dengan format YYYY-MM
        list($year, $month) = explode('-', $month);

        $data['bbm_receipts'] = BbmReceipt::where([
                'shipment_type' => 'ship',
                'bbm_type' => $bbm_type,
            ])
            ->whereYear('date_receipt', $year) // Filter berdasarkan tahun
            ->whereMonth('date_receipt', $month) // Filter berdasarkan bulan
            ->get();
        return view('reports.berita-acara.bbm', $data);
    }
}

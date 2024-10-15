<?php

namespace App\Http\Controllers\Report\Receipt;

use App\BbmReceipt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.receipt.index');
    }

    public function bbmReceipt(Request $request, $type_bbm)
    {
        $filterType = null;
        $data['filter_type'] = $filterType;
        $validFilterTypes = ['day', 'year'];
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

        $queryBbmReceipt = BbmReceipt::query();
        if($filterType != null){
            switch ($filterType) {
                case 'day':
                    $queryBbmReceipt->whereYear('date_receipt', $tahun)
                                    ->whereMonth('date_receipt', $bulan)
                                    ->where('bbm_type', $type_bbm)
                                    ->orderBy('date_receipt', 'asc');

                    $data['bbm_receipt'] = $queryBbmReceipt->get();
                    break;


                case 'month':
                    dd($tahunInput);
                    $queryBbmReceipt = BbmReceipt::query()
                                    ->selectRaw('
                                        YEAR(date_receipt) as year,
                                        MONTH(date_receipt) as month,
                                        SUM(faktur_obs) as total_faktur_obs,
                                        SUM(CASE
                                            WHEN amount_receipt = "Selisih Volume Level" THEN CAST(uad_obs AS UNSIGNED)
                                            WHEN amount_receipt = "Selisih Volume Level (Liter 15)" THEN CAST(uad_ltr15 AS UNSIGNED)
                                            WHEN amount_receipt = "Selisih Hasil Sounding" THEN CAST(hasil_sond_akhir AS UNSIGNED) - CAST(hasil_sond_awal AS UNSIGNED)
                                            WHEN amount_receipt = "Selisih Flow Meter" THEN CAST(flow_meter_akhir AS UNSIGNED) - CAST(flow_meter_awal AS UNSIGNED)
                                            WHEN amount_receipt = "Faktur" THEN CAST(faktur_obs AS UNSIGNED)
                                            WHEN amount_receipt = "Faktur Liter 15" THEN CAST(faktur_ltr15 AS UNSIGNED)
                                            ELSE 0
                                        END) as total_amount_receipt,
                                        SUM(faktur_ltr15) as total_faktur_ltr15,
                                        SUM(liter_15_tug3) as total_liter_15_tug3
                                    ')
                                    ->whereYear('date_receipt', $tahunInput)
                                    ->where('bbm_type', $type_bbm)
                                    ->groupBy('year', 'month')
                                    ->orderBy('month', 'asc')
                                    ->get();
                    $monthlyData = [];

                    for ($i = 1; $i <= 12; $i++) {
                        $monthlyData[$i] = [
                            'month' => $i,
                            'total_faktur_obs' => 0,
                            'total_amount_receipt' => 0,
                            'total_faktur_ltr15' => 0,
                            'total_liter_15_tug3' => 0
                        ];
                    }

                    foreach ($queryBbmReceipt as $receipt) {
                        $monthlyData[$receipt->month] = [
                            'month' => $receipt->month,
                            'total_faktur_obs' => $receipt->total_faktur_obs,
                            'total_amount_receipt' => $receipt->total_amount_receipt,
                            'total_faktur_ltr15' => $receipt->total_faktur_ltr15,
                            'total_liter_15_tug3' => $receipt->total_liter_15_tug3
                        ];
                    }

                    $data['bbm_receipt'] = $monthlyData;
                    break;

            }
        }

        return view('reports.receipt.bbm-receipt-report', $data);
    }
}

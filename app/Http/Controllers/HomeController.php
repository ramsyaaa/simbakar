<?php

namespace App\Http\Controllers;

use App\BbmReceipt;
use App\Models\Tug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->route('administration.dashboard');
    }
    public function query(){

        set_time_limit(100000);
                $duplicates = BbmReceipt::select('NO_TUG3', 'ID_PENGIRIMAN')
                    ->groupBy('NO_TUG3', 'ID_PENGIRIMAN')
                    ->havingRaw('COUNT(*) > 1')
                    ->get();
        
                foreach ($duplicates as $duplicate) {
                    // Ambil semua data yang duplikat
                    $duplicatesData = BbmReceipt::where('NO_TUG3', $duplicate->NO_TUG3)
                        ->where('ID_PENGIRIMAN', $duplicate->ID_PENGIRIMAN)
                        ->orderBy('id') // Atur berdasarkan ID agar yang pertama adalah yang tertua
                        ->get();
        
                    // Lewati record pertama, hapus sisanya
                    $duplicatesData->skip(1)->each(function ($item) {
                        // Hapus data dari tabel tugs berdasarkan bbm_receipt_id
                        Tug::where('bbm_receipt_id', $item->id)->delete();
        
                        // Hapus record dari bbm_receipt
                        $item->delete();
                    });
                }
    }
}

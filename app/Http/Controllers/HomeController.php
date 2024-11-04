<?php

namespace App\Http\Controllers;

use App\Labor;
use App\BbmReceipt;
use App\Models\Tug;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
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

    public function labor(){
        DB::beginTransaction();
        try {
            $json = file_get_contents(public_path('coal.json'));
       
            $json_data =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true );
    
            foreach ($json_data as $item){

                $labor = Labor::where('ID_ANALISA',$item['ID_ANALISA_LABOR'])->first();
                if($labor){
                    $unloading = CoalUnloading::where('ID_PENGIRIMAN', $item['ID_PENGIRIMAN'])->first();
                    $unloading->analysis_labor_id = $labor->id;
                    $unloading->save();
                 }               
            }
            DB::commit();
            return 'ok';
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
    public function labor1(){
        DB::beginTransaction();
        try {
            $json = file_get_contents(public_path('coal-1.json'));
       
            $json_data =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true );
    
            foreach ($json_data as $item){

                $labor = Labor::where('ID_ANALISA',$item['ID_ANALISA_LABOR'])->first();
                if($labor){
                    $unloading = CoalUnloading::where('ID_PENGIRIMAN', $item['ID_PENGIRIMAN'])->first();
                    $unloading->analysis_labor_id = $labor->id;
                    $unloading->save();
                 }               
            }
            DB::commit();
            return 'ok';
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
    public function labor2(){
        DB::beginTransaction();
        try {
            $json = file_get_contents(public_path('coal2.json'));
       
            $json_data =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true );
    
            foreach ($json_data as $item){

                $labor = Labor::where('ID_ANALISA',$item['ID_ANALISA_LABOR'])->first();
                if($labor){
                    $unloading = CoalUnloading::where('ID_PENGIRIMAN', $item['ID_PENGIRIMAN'])->first();
                    $unloading->analysis_labor_id = $labor->id;
                    $unloading->save();
                 }               
            }
            DB::commit();
            return 'ok';
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
    public function labor21(){
        DB::beginTransaction();
        try {
            $json = file_get_contents(public_path('coal21.json'));
       
            $json_data =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true );
    
            foreach ($json_data as $item){

                $labor = Labor::where('ID_ANALISA',$item['ID_ANALISA_LABOR'])->first();
                if($labor){
                    $unloading = CoalUnloading::where('ID_PENGIRIMAN', $item['ID_PENGIRIMAN'])->first();
                    $unloading->analysis_labor_id = $labor->id;
                    $unloading->save();
                 }               
            }
            DB::commit();
            return 'ok';
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
    public function labor3(){
        DB::beginTransaction();
        try {
            $json = file_get_contents(public_path('coal3.json'));
       
            $json_data =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true );
    
            foreach ($json_data as $item){

                $labor = Labor::where('ID_ANALISA',$item['ID_ANALISA_LABOR'])->first();
                if($labor){
                    $unloading = CoalUnloading::where('ID_PENGIRIMAN', $item['ID_PENGIRIMAN'])->first();
                    $unloading->analysis_labor_id = $labor->id;
                    $unloading->save();
                 }               
            }
            DB::commit();
            return 'ok';
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
    public function labor31(){
        DB::beginTransaction();
        try {
            $json = file_get_contents(public_path('coal3-1.json'));
       
            $json_data =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true );
    
            foreach ($json_data as $item){

                $labor = Labor::where('ID_ANALISA',$item['ID_ANALISA_LABOR'])->first();
                if($labor){
                    $unloading = CoalUnloading::where('ID_PENGIRIMAN', $item['ID_PENGIRIMAN'])->first();
                    $unloading->analysis_labor_id = $labor->id;
                    $unloading->save();
                 }               
            }
            DB::commit();
            return 'ok';
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
    public function labor4(){
        DB::beginTransaction();
        try {
            $json = file_get_contents(public_path('coal4.json'));
       
            $json_data =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $json), true );
    
            foreach ($json_data as $item){

                $labor = Labor::where('ID_ANALISA',$item['ID_ANALISA_LABOR'])->first();
                if($labor){
                    $unloading = CoalUnloading::where('ID_PENGIRIMAN', $item['ID_PENGIRIMAN'])->first();
                    $unloading->analysis_labor_id = $labor->id;
                    $unloading->save();
                 }               
            }
            DB::commit();
            return 'ok';
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
    

    public function tug()
    {
        // Ambil data Tug dalam batch kecil menggunakan chunk
        Tug::where('tug', 3)
            ->with(['coal', 'bbm'])
            ->chunk(1000, function ($tugs) {
                foreach ($tugs as $tug) {
                    if ($tug->type_tug === 'coal-unloading' && $tug->coal) {
                        $tug->receipt_date = $tug->coal->receipt_date;
                    } elseif ($tug->type_tug === 'bbm-receipt' && $tug->bbm) {
                        $tug->receipt_date = $tug->bbm->date_receipt;
                    }
                    $tug->save();
                }
            });
    }
    
    
    
}

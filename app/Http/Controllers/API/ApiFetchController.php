<?php

namespace App\Http\Controllers\API;

use App\Ship;
use stdClass;
use App\Labor;
use App\Loading;
use App\Supplier;
use App\Unloading;
use App\Preloadinng;
use App\LoadingCompany;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Models\HeadWarehouse;
use App\Models\GeneralManager;
use App\Models\KindDisruption;
use App\Models\UserInspection;
use Illuminate\Support\Facades\DB;
use App\Models\BiomassaSubSupplier;
use App\Http\Controllers\Controller;


class ApiFetchController extends Controller
{
   public function saveInspection(Request $request){
    if($request->name == null){return false;}

        $user = UserInspection::where('name', $request->name)->first();

        if($user){
            return true;
        }else{
            UserInspection::create([
                'name' => $request->name
            ]);
            return true;
        }
   }

   public function saveWarehouse(Request $request){

    if($request->name == null){return false;}

        $user = HeadWarehouse::where('name', $request->name)->first();

        if($user){
            return true;
        }else{
            HeadWarehouse::create([
                'name' => $request->name
            ]);
            return true;
        }
   }

   public function saveManager(Request $request){

    if($request->name == null){return false;}

        $user = GeneralManager::where('name', $request->name)->first();

        if($user){
            return true;
        }else{
            GeneralManager::create([
                'name' => $request->name
            ]);
            return true;
        }
   }

   public function saveDisruption(Request $request){

    if($request->name == null){return false;}

        $user = KindDisruption::where('name', $request->name)->first();

        if($user){
            return true;
        }else{
            KindDisruption::create([
                'name' => $request->name
            ]);
            return true;
        }
   }

   public function getContract(Request $request){

    return $contract = CoalContract::where('supplier_id', $request->id)->get();

   }

   public function getNumber(Request $request){

    return $number = CoalContract::where('id', $request->id)->first();

   }

   public function getCertificate(Request $request){

    if ($request->type == 1) {

        $contract = CoalContract::where('id', $request->id)->first();

        return $certificate = Loading::select('id','analysis_number')->where('contract_uuid',$contract->uuid)->get();

    }
    if ($request->type == 2) {

        $contract = CoalUnloading::select('analysis_unloading_id')->where('contract_id', $request->id)->get()->toArray();

        return $certificate = Unloading::select('id','analysis_number')->whereIn('id',$contract)->get();

    }
    if ($request->type == 3) {

        $contract = CoalContract::where('id', $request->id)->first();
        return $certificate = Preloadinng::select('id','analysis_number')->where('contract_uuid',$contract->uuid)->get();

    }

   }

   public function getContractShip(Request $request){

    return CoalUnloading::where('supplier_id', $request->supplier_id)
    ->where('ship_id',$request->ship_id)
    ->whereNotNull('analysis_loading_id')
    ->whereNotNull('analysis_unloading_id')
    ->whereNotNull('analysis_labor_id')
    ->get();

   }

   public function getSubSupplier(Request $request){

   return BiomassaSubSupplier::where('contract_id', $request->id)
    ->join('suppliers', 'suppliers.id','biomassa_sub_suppliers.supplier_id')
    ->get();

   }

   public function getLoadingCompany(Request $request){

        try {
            return LoadingCompany::where('name', 'like', '%' . $request->key . '%')
        ->get();

        } catch (\Throwable $th) {
            return $th;
        }

   }

   public function getAnalyticLoading(Request $request){

        try {
            return Loading::where('analysis_number', 'like', '%' . $request->key . '%')
            ->limit(100)->get();

        } catch (\Throwable $th) {
            return $th;
        }

   }
   public function getAnalyticUnloading(Request $request){

        try {
            return Unloading::where('analysis_number', 'like', '%' . $request->key . '%')
            ->limit(100)->get();

        } catch (\Throwable $th) {
            return $th;
        }

   }

   public function getAnalyticLabor(Request $request){

        try {
            return Labor::where('analysis_number', 'like', '%' . $request->key . '%')
            ->limit(100)->get();

        } catch (\Throwable $th) {
            return $th;
        }

   }

   public function getShip(Request $request){

        try {
            return Ship::where('name', 'like', '%' . $request->key . '%')
            ->limit(100)->get();

        } catch (\Throwable $th) {
            return $th;
        }

   }

   public function getShipComparison(Request $request){

        try {
            $coal = CoalUnloading::select('ship_id')->distinct()->where('supplier_id', '=', $request->supplier_id)->get()->toArray();
            $ship = Ship::whereIn('id',$coal)->get();
            return $ship;

        } catch (\Throwable $th) {
            return $th;
        }

   }

   public function getSupplierContract($id)
    {
        try {
            // Ambil data kontrak berdasarkan supplier_id
            $coalContracts = CoalContract::where('supplier_id', $id)->get();

            // Jika tidak ada kontrak ditemukan
            if ($coalContracts->isEmpty()) {
                return response()->json([
                    'message' => 'No contracts found for this supplier.'
                ], 404); // Not Found
            }

            // Mengembalikan data kontrak dalam format JSON
            return response()->json($coalContracts, 200); // OK

        } catch (\Exception $e) {
            // Tangani jika ada error atau exception
            return response()->json([
                'message' => 'Error occurred while fetching contracts.',
                'error' => $e->getMessage()
            ], 500); // Internal Server Error
        }
    }

    public function chartDataReceipt(Request $request){

        $filterType = $request->type;
        $supplier = Supplier::where('id', $request->supplier_id)->first();
        switch ($filterType) {
            case 'month':

                // Mengambil semua data dalam satu query untuk mengurangi beban query berulang
                $contracts = CoalUnloading::select(
                    DB::raw('MONTH(receipt_date) as bulan'),
                    DB::raw('SUM(tug_3_accept) as total_per_bulan')
                )
                ->join('coal_contracts', 'coal_contracts.id', '=', 'coal_unloadings.contract_id')
                ->join('suppliers', 'suppliers.id', '=', 'coal_contracts.supplier_id')
                ->where('coal_unloadings.supplier_id', '=',$request->supplier_id)
                ->whereYear('receipt_date', '=', $request->year)
                ->groupBy('coal_contracts.id', 'coal_contracts.contract_number', 'suppliers.name', 'coal_contracts.total_volume', 'bulan') // Tambahkan semua kolom non-agregat di sini
                ->get()
                ->groupBy('contract_id');

                $processedContracts = $contracts->map(function($items) {
                    $chart = new stdClass();


                    // Assign monthly data (Jan = 1, Dec = 12)
                    $chart->data = array_fill(1, 12, 0); // Inisialisasi data per bulan
                    foreach ($items as $item) {
                        $chart->data[$item->bulan] = (int)$item->total_per_bulan;
                    }

                    return $chart;
                });

                // Memproses data hasil query untuk mengelompokkan per kontrak
                $result = new stdClass();

                // Assign basic data
                $result->labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'September', 'Oktober', 'November', 'Desember'];
                $result->datasets = []; // Pastikan datasets adalah array
                $result->datasets[] = [
                    'label' => 'Penerimaan Batubara '. $supplier->name.' tahun ' .$request->year,
                    'data' => $processedContracts->pluck('data')->flatten(),
                    'backgroundColor' => 'rgba(3, 91, 113, 1)',
                    'borderColor' => 'rgba(3, 91, 113, 1)',
                    'borderWidth' => 1
                ];




                return response()->json($result);
                
                break;


            case 'year':

                $startYear = $request->startYear;
                $endYear = $request->endYear;

                // Mengambil semua data dalam satu query
                $contracts = CoalUnloading::select(
                    DB::raw('YEAR(receipt_date) as tahun'),
                    DB::raw('SUM(tug_3_accept) as total_per_tahun')
                )
                ->join('coal_contracts', 'coal_contracts.id', '=', 'coal_unloadings.contract_id')
                ->join('suppliers', 'suppliers.id', '=', 'coal_contracts.supplier_id')
                ->whereYear('receipt_date', '>=', $startYear)
                ->whereYear('receipt_date', '<=', $endYear)
                ->groupBy('coal_contracts.id', 'coal_contracts.contract_number', 'suppliers.name', 'coal_contracts.total_volume', 'tahun') // Tambahkan semua kolom non-agregat di sini
                ->get()
                ->groupBy('contract_id');

                // Memproses data hasil query untuk mengelompokkan per kontrak dan per tahun
                $processedContracts = $contracts->map(function($items) use($startYear, $endYear) {
                    $chart = new stdClass();

                    $chart->data = array_fill($startYear, $endYear - $startYear + 1, 0);
                    foreach ($items as $item) {
                        $chart->data[$item->tahun] = (int)$item->total_per_tahun;
                    }
                    return $chart;
                });

                $years = array_values(range($startYear, $endYear));
                $result = new stdClass();

                $result->labels = $years;
                $result->datasets = []; // Pastikan datasets adalah array
                $result->datasets[] = [
                    'label' => 'Penerimaan Batubara '. $supplier->name.' dari tahun  ' .$startYear. ' sampai '.$endYear,
                    'data' => $processedContracts->pluck('data')->flatten(),
                    'backgroundColor' => 'rgba(3, 91, 113, 1)',
                    'borderColor' => 'rgba(3, 91, 113, 1)',
                    'borderWidth' => 1
                ];
                return response()->json($result);
                break;
            
        }
    }


}

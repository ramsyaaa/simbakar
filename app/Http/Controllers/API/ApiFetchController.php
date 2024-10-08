<?php

namespace App\Http\Controllers\API;

use App\Ship;
use App\Labor;
use App\Loading;
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


}

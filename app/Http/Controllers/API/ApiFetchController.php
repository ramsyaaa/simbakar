<?php

namespace App\Http\Controllers\API;

use App\Labor;
use App\Loading;
use App\Unloading;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Models\HeadWarehouse;
use App\Models\GeneralManager;
use App\Models\KindDisruption;
use App\Models\UserInspection;
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

        $contract = CoalUnloading::select('analysis_loading_id')->where('contract_id', $request->id)->get()->toArray();
        return $certificate = Loading::select('id','analysis_number')->whereIn('id',$contract)->get();
        
    }
    if ($request->type == 2) {

        $contract = CoalUnloading::select('analysis_unloading_id')->where('contract_id', $request->id)->get()->toArray();
        return $certificate = Unloading::select('id','analysis_number')->whereIn('id',$contract)->get();
        
    }
    if ($request->type == 3) {

        $contract = CoalUnloading::select('analysis_labor_id')->where('contract_id', $request->id)->get()->toArray();
        return $certificate = Labor::select('id','analysis_number')->whereIn('id',$contract)->get();
        
    }
    if ($request->type == 4) {

        $contract = CoalUnloading::select('analysis_loading_id')->where('contract_id', $request->id)->get()->toArray();
        return $certificate = Loading::select('id','analysis_number')->whereIn('id',$contract)->get();
        
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

}

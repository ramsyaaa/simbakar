<?php

namespace App\Http\Controllers\API;

use App\Models\CoalContract;
use Illuminate\Http\Request;
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
    
    return $contract = CoalContract::where('id', $request->id)->get();

   }
   public function getNumber(Request $request){

    return $number = CoalContract::where('id', $request->id)->first();

   }

}

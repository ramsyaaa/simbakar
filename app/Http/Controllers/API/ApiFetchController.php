<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\HeadWarehouse;
use App\Models\GeneralManager;
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

}

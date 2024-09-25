<?php

namespace App\Http\Controllers\Report\CoalQuality;

use App\Ship;
use App\Labor;
use App\Loading;
use App\Supplier;
use App\Unloading;
use Carbon\Carbon;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Http\Controllers\Controller;

class CoalComparisonController extends Controller
{
    public function index(Request $request)
    {
        $data['suppliers'] = Supplier::all();

        if($request->has('contract_id')){
          $data['loading'] = $this->analytic($request,1);
          $data['unloading'] = $this->analytic($request,2);
          $data['labor'] = $this->analytic($request,3);
          $data['pemasok'] = Supplier::where('id',$request->get('supplier_id'))->first();
          $data['kapal'] = Ship::where('id',$request->get('ship_id'))->first();
          $coal = CoalUnloading::select('ship_id')->distinct()->where('supplier_id', '=', $request->supplier_id)->get()->toArray();
          $data['getShips'] = Ship::whereIn('id',$coal)->get();
          $data['contract'] = CoalUnloading::where('id',$request->contract_id)->first();
          $data['numbers'] = CoalUnloading::where('supplier_id', $request->supplier_id)->where('ship_id',$request->ship_id)->get();
        }
        return view('reports.coal-quality.coal-comparison',$data);
    }

    private function analytic($request, $type){

        $receipt = CoalUnloading::where('id',$request->contract_id)->first();

        if ($type == 1) {
                
            $certificate = Loading::where('id',$receipt->analysis_loading_id)->first();
        }
        if ($type == 2) {
            
            $certificate = Unloading::where('id',$receipt->analysis_unloading_id)->first();
        }
        if ($type == 3) {
            
            $certificate = Labor::where('id',$receipt->analysis_labor_id)->first();

        }

        if($certificate){
            $sulfur_db = ($certificate->total_sulfur * 100) / (100 - $certificate->moisture_total);
            
            $total_base = $certificate->cao + $certificate->mgo + $certificate->fe2o3 + $certificate->na2o + $certificate->k2o ;
            
            $total_acid = $certificate->sio2 + $certificate->al2o3 + $certificate->tlo2;
            if($total_acid == 0){
                $total_slagging = 0;
                $total_fouling = 0;
            }else{
                $total_slagging = ($total_base / $total_acid ) * $sulfur_db;
                $total_fouling = ($total_base / $total_acid ) * $certificate->na2o;
            }
        
            $check = $certificate->cao + $certificate->mgo;
            
            $slagging_index = $certificate->fe2o3 > $check ?  $total_slagging: '' ;
            $fouling_index = $certificate->fe2o3 > $check ?  $total_fouling: '' ;

            $total_1 = $certificate->fe2o3 + $certificate->cao + $certificate->mgo;

            $total_2 = $certificate->na2o + $certificate->k2o + $total_1;

            $total_3 = $certificate->sio2 + $certificate->al2o3 + $certificate->tlo2 ;

            if ($slagging_index == "") {
                $potensial_slagging = "";
            } elseif ($slagging_index > 2.6) {
                $potensial_slagging = "SEVERE";
            } elseif ($slagging_index > 2) {
                $potensial_slagging = "HIGH";
            } elseif ($slagging_index > 0.6) {
                $potensial_slagging = "MEDIUM";
            } else {
                $potensial_slagging = "LOW";
            }
            
            if ($fouling_index == "") {
                $potensial_fouling = "";
            } elseif ($fouling_index > 2.6) {
                $potensial_fouling = "SEVERE";
            } elseif ($fouling_index > 2) {
                $potensial_fouling = "HIGH";
            } elseif ($fouling_index > 0.6) {
                $potensial_fouling = "MEDIUM";
            } else {
                $potensial_fouling = "LOW";
            }
            
            $certificate['total_1'] = round($total_1,2);
            $certificate['total_2'] = round($total_2,2);
            $certificate['total_3'] = round($total_3,2);
            $certificate['sulfur_db'] = round($sulfur_db,2);
            $certificate['slagging_index'] = round($slagging_index,2);
            $certificate['fouling_index'] = round($fouling_index,2);
            $certificate['potensial_slagging'] = $potensial_slagging;
            $certificate['potensial_fouling'] = $potensial_fouling;
        }
        return $certificate;
    }
}

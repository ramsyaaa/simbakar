<?php

namespace App\Http\Controllers\Report\Contract;

use stdClass;
use App\Labor;
use App\Loading;
use App\Supplier;
use App\Unloading;
use Carbon\Carbon;
use App\Preloadinng;
use App\Models\CoalContract;
use Illuminate\Http\Request;
use App\Models\CoalUnloading;
use App\Models\PenaltyClause;
use App\Models\DeliveryClause;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SpesificationContractCoal;

class EvaluationCoalController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('supplier_id')){

            if ($request->type == 1) {
                
                $certificate = Loading::where('id',$request->analysis_id)->first();
                $data['analysis_status'] = 'Loading';

                $contract = CoalContract::where('id', $request->contract_id)->first();
                
                $data['analysists'] = Loading::select('id','analysis_number')->where('contract_uuid',$contract->uuid)->get();
            }
            if ($request->type == 2) {
                
                $certificate = Unloading::where('id',$request->analysis_id)->first();
                $data['analysis_status'] = 'Unloading';

                $contracts = CoalUnloading::select('analysis_unloading_id')->where('supplier_id',$request->supplier_id)->where('contract_id',$request->contract_id)->get()->toArray();
                $data['analysists'] = Unloading::select('id','analysis_number')->whereIn('id',$contracts)->where([['analysis_number', '!=', null]])->get();
            }
            if ($request->type == 3) {
                
                $certificate = Preloadinng::where('id',$request->analysis_id)->first();
                $data['analysis_status'] = 'Preloading';

                $contract = CoalContract::where('id', $request->contract_id)->first();
                $data['analysists'] = Preloadinng::select('id','analysis_number')->where('contract_uuid',$contract->uuid)->get();
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
                    $slagging_potensial = "";
                } elseif ($slagging_index > 2.6) {
                    $slagging_potensial = "SEVERE";
                } elseif ($slagging_index > 2) {
                    $slagging_potensial = "HIGH";
                } elseif ($slagging_index > 0.6) {
                    $slagging_potensial = "MEDIUM";
                } else {
                    $slagging_potensial = "LOW";
                }
                
                if ($fouling_index == "") {
                    $fouling_potensial = "";
                } elseif ($fouling_index > 2.6) {
                    $fouling_potensial = "SEVERE";
                } elseif ($fouling_index > 2) {
                    $fouling_potensial = "HIGH";
                } elseif ($fouling_index > 0.6) {
                    $fouling_potensial = "MEDIUM";
                } else {
                    $fouling_potensial = "LOW";
                }

                if ($certificate->fe2o3 > ($check)) {
                    $result = "BITUMINOUS";
                } elseif ($certificate->fe2o3 === "") {
                    $result = "";
                } elseif ($certificate->cao === "") {
                    $result = "";
                } elseif ($certificate->mgo === "") {
                    $result = "";
                } else {
                    $result = "LIGNITIC";
                }
                
                $certificate['total_1'] = round($total_1,2);
                $certificate['total_2'] = round($total_2,2);
                $certificate['total_3'] = round($total_3,2);
                $certificate['sulfur_db'] = round($sulfur_db,2);
                $certificate['slagging_index'] = round($slagging_index,2);
                $certificate['fouling_index'] = round($fouling_index,2);
                $certificate['slagging_potensial'] = $slagging_potensial;
                $certificate['fouling_potensial'] = $fouling_potensial;
                $certificate['result'] = $result;
            }
            $data['certificate'] = $certificate;
        }
            $data['pemasok'] = Supplier::join('coal_contracts', 'coal_contracts.supplier_id','suppliers.id')
            ->where('coal_contracts.id',$request->contract_id)
            ->where('suppliers.id',$request->supplier_id)->first();
            $data['numbers'] = CoalContract::where('supplier_id',$request->supplier_id)->get();
            $data['suppliers'] = Supplier::all();
            $data['spesification'] = SpesificationContractCoal::where('contract_id',$request->contract_id)->first();
            $data['penalties'] = PenaltyClause::join('unit_penalties','unit_penalties.id','refusal_penalty_clauses.unit_penalty_id')->where('contract_id',$request->contract_id)->get();
            
            return view('reports.contracts.coal-evaluation',$data);
        }
    }
    
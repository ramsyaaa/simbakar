@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div id="my-pdf">
                @isset($certificate)
                <div class="body bg-white rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <img src="{{asset('logo.png')}}" alt="" width="200">
                            <p class="text-right mt-3">UBP SURALAYA</p>
                        </div>
                        <div class="text-center text-[20px] font-bold">
                            <p>EVALUASI KUALITAS BATU BARA</p>
                            <p></p>
                            {{-- <p>No: {{$tug->bpb_number}}/IBPB/UBPSLA/PBB/{{date('Y')}}</p> --}}
                        </div>
                        <div></div>
                    </div>
                    <div>
                        <div>
                            <div class="mb-3 border border-slate-900 p-1">
                                <div class="grid grid-cols-2">
                                    <table>
                                        <tr>
                                            <th class="text-left">Status Analisa</th>
                                            <td>: Loading</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">No. Kontrak</th>
                                            <td>: {{$coal->contract->contract_number}} </td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Nama Surveyor</th>
                                            <td>: {{$certificate->surveyor->name ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Pemasok</th>
                                            <td>: {{$coal->supplier->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Nama Kapal</th>
                                            <td>: {{$coal->ship->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">No. Sertifikat</th>
                                            <td>: {{$certificate->analysis_number}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Jumlah B/L</th>
                                            <td>: {{number_format($certificate->bill_of_ladding)}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Tanggal Analisa</th>
                                            <td>: {{$certificate->analysis_date}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Asal Barang</th>
                                            <td>: {{$certificate->origin_of_goods}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="mb-3">
                                <table class="w-full border-collapse">
                                    <tbody>
                                        <tr>
                                            <th class="border border-slate-900">Fe<sub>2</sub>O<sub>3</sub></th>
                                            <td class="border border-slate-900 text-right">{{$certificate->fe2o3}}</td>
                                            <th class="border border-slate-900" rowspan="3">Ash Classification</th>
                                            <th class="border border-slate-900">CaO</th>
                                            <td class="border border-slate-900 text-right">{{$certificate->cao}}</td>
                                            <th class="border border-slate-900">SiO<sub>2</sub></th>
                                            <td class="border border-slate-900 text-right">{{$certificate->sio2}}</td>
                                        </tr>
                                        <tr>
                                            <th class="border border-slate-900">CaO</th>
                                            <td class="border border-slate-900 text-right">{{$certificate->cao}}</td>
                                            <th class="border border-slate-900">MgO</th>
                                            <td class="border border-slate-900 text-right">{{$certificate->mgo}}</td>
                                            <th class="border border-slate-900">AI<sub>2</sub>O<sub>3</sub></th>
                                            <td class="border border-slate-900 text-right">{{$certificate->al2o3}}</td>
                                        </tr>
                                        <tr>
                                            <th class="border border-slate-900">MgO</th>
                                            <td class="border border-slate-900 text-right">{{$certificate->mgo}}</td>
                                            <th class="border border-slate-900">Fe<sub>2</sub>O<sub>3</sub></th>
                                            <td class="border border-slate-900 text-right">{{$certificate->fe2o3}}</td>
                                            <th class="border border-slate-900">TiO<sub>2</sub></th>
                                            <td class="border border-slate-900 text-right">{{$certificate->tlo2}}</td>
                                        </tr>
                                        <tr>
                                            <th class="border border-slate-900" rowspan="3"></th>
                                            <th class="border border-slate-900" rowspan="3">{{$certificate->total_1}}</th>
                                            <th class="border border-slate-900" rowspan="3">{{$certificate->result}}</th>
                                            <th class="border border-slate-900">Na<sub>2</sub>o</th>
                                            <td class="border border-slate-900 text-right">{{$certificate->na2o}}</td>
                                            <th class="border border-slate-900" rowspan="3"></th>
                                            <th class="border border-slate-900" rowspan="3">{{$certificate->total_3}}</th>
                                        </tr>
                                        <tr>
                                            <th class="border border-slate-900">K<sub>2</sub>O</th>
                                            <td class="border border-slate-900 text-right">{{$certificate->k2o}}</td>
                                        </tr>
                                        <tr>
                                            <td class="border border-slate-900 text-right" colspan="2">{{$certificate->total_2}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mb-3">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr>
                                            <th class="border border-slate-900">Sulfur (db)</th>
                                            <th class="border border-slate-900">Na<sub>2</sub>O</th>
                                            <th class="border border-slate-900">Slagging Index (Rs)</th>
                                            <th class="border border-slate-900">Slagging Potential</th>
                                            <th class="border border-slate-900">Fouling Index (Rf)</th>
                                            <th class="border border-slate-900">Fouling Potential</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border border-slate-900 text-center">{{$certificate->sulfur_db}}</td>
                                            <td class="border border-slate-900 text-center">{{$certificate->na2o}}</td>
                                            <td class="border border-slate-900 text-center">{{$certificate->slagging_index}}</td>
                                            <td class="border border-slate-900 text-center">{{$certificate->slagging_potensial}}</td>
                                            <td class="border border-slate-900 text-center">{{$certificate->fouling_index}}</td>
                                            <td class="border border-slate-900 text-center">LOW</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mb-3">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr>
                                            <th class="border border-slate-900" rowspan="2">Unsur</th>
                                            <th class="border border-slate-900" colspan="5">Spesifikasi Batu Bara {{$coal->supplier->name}}</th>
                                        </tr>
                                        <tr>
                                            <th class="border border-slate-900">Typical</th>
                                            <th class="border border-slate-900">Penyesuaian</th>
                                            <th class="border border-slate-900">Penolakan</th>
                                            <th class="border border-slate-900">Hasil Analisa</th>
                                            <th class="border border-slate-900">Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $penaltyAsh = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 1;
                                            })->first();
                                        
                                            $conditionAsh = $penaltyAsh->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penaltyAsh->penalty_will_get_if_number ?? null;
                                            $certificateAsh = $certificate->ash ?? null;
                                            $signAsh = '';
                                        
                                            if ($conditionAsh && $penaltyNumber !== null) {
                                                switch ($conditionAsh) {
                                                    case '==': $result = ($certificateAsh == $penaltyNumber); break;
                                                    case '>':  $result = ($certificateAsh > $penaltyNumber); break;
                                                    case '<':  $result = ($certificateAsh < $penaltyNumber); break;
                                                    case '<=': $result = ($certificateAsh <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificateAsh >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $signAsh = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Abu ( Ash )</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->ash_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penaltyAsh->penalty_will_get_if_sign ?? ''}}   {{$penaltyAsh->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$signAsh}}</span>{{$certificate->ash}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penaltyCarbon = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 7;
                                            })->first();
                                        
                                            $conditionCarbon = $penaltyCarbon->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penaltyCarbon->penalty_will_get_if_number ?? null;
                                            $certificateCarbon = $certificate->fixed_carbon ?? null;
                                            $signCarbon = '';
                                        
                                            if ($conditionCarbon && $penaltyNumber !== null) {
                                                switch ($conditionCarbon) {
                                                    case '==': $result = ($certificateCarbon == $penaltyNumber); break;
                                                    case '>':  $result = ($certificateCarbon > $penaltyNumber); break;
                                                    case '<':  $result = ($certificateCarbon < $penaltyNumber); break;
                                                    case '<=': $result = ($certificateCarbon <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificateCarbon >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $signCarbon = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Fixed Carbon</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->fixed_carbon_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penaltyCarbon->penalty_will_get_if_sign ?? ''}}   {{$penaltyCarbon->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$signCarbon}}</span>{{$certificate->fixed_carbon}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penaltyHgi = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 9;
                                            })->first();
                                        
                                            $conditionHgi = $penaltyHgi->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penaltyHgi->penalty_will_get_if_number ?? null;
                                            $certificateHgi = $certificate->hgi ?? null;
                                            $signHgi = '';
                                        
                                            if ($conditionHgi && $penaltyNumber !== null) {
                                                switch ($conditionHgi) {
                                                    case '==': $result = ($certificateHgi == $penaltyNumber); break;
                                                    case '>':  $result = ($certificateHgi > $penaltyNumber); break;
                                                    case '<':  $result = ($certificateHgi < $penaltyNumber); break;
                                                    case '<=': $result = ($certificateHgi <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificateHgi >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $signHgi = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">HGI</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->hgi_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penaltyHgi->penalty_will_get_if_sign ?? ''}}   {{$penaltyHgi->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$signHgi}}</span>{{$certificate->hgi}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penaltyInherent = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 13;
                                            })->first();
                                        
                                            $conditionInherent = $penaltyInherent->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penaltyInherent->penalty_will_get_if_number ?? null;
                                            $certificateInherent = $certificate->air_dried_moisture ?? null;
                                            $signInherent = '';
                                        
                                            if ($conditionInherent && $penaltyNumber !== null) {
                                                switch ($conditionInherent) {
                                                    case '==': $result = ($certificateInherent == $penaltyNumber); break;
                                                    case '>':  $result = ($certificateInherent > $penaltyNumber); break;
                                                    case '<':  $result = ($certificateInherent < $penaltyNumber); break;
                                                    case '<=': $result = ($certificateInherent <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificateInherent >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $signInherent = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Inherent Moisture</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->inherent_moisture_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penaltyInherent->penalty_will_get_if_sign ?? ''}}   {{$penaltyInherent->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$signInherent}}</span>{{$certificate->air_dried_moisture}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penaltyInitial = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 14;
                                            })->first();
                                        
                                            $conditionInitial = $penaltyInitial->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penaltyInitial->penalty_will_get_if_number ?? null;
                                            $certificateInitial = $certificate->initial_deformation ?? null;
                                            $signInitial = '';
                                        
                                            if ($conditionInitial && $penaltyNumber !== null) {
                                                switch ($conditionInitial) {
                                                    case '==': $result = ($certificateInitial == $penaltyNumber); break;
                                                    case '>':  $result = ($certificateInitial > $penaltyNumber); break;
                                                    case '<':  $result = ($certificateInitial < $penaltyNumber); break;
                                                    case '<=': $result = ($certificateInitial <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificateInitial >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $signInitial = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Initial Deformation</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->initial_deformation_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penaltyInitial->penalty_will_get_if_sign ?? ''}}   {{$penaltyInitial->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$signInitial}}</span>{{$certificate->initial_deformation}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penaltyNa2o = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 18;
                                            })->first();
                                        
                                            $conditionNa2o = $penaltyNa2o->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penaltyNa2o->penalty_will_get_if_number ?? null;
                                            $certificateNa2o = $certificate->na2o ?? null;
                                            $signNa2o = '';
                                        
                                            if ($conditionNa2o && $penaltyNumber !== null) {
                                                switch ($conditionNa2o) {
                                                    case '==': $result = ($certificateNa2o == $penaltyNumber); break;
                                                    case '>':  $result = ($certificateNa2o > $penaltyNumber); break;
                                                    case '<':  $result = ($certificateNa2o < $penaltyNumber); break;
                                                    case '<=': $result = ($certificateNa2o <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificateNa2o >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $signNa2o = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Natrium Oksida ( Na2O )</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->na2o_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penaltyNa2o->penalty_will_get_if_sign ?? ''}}   {{$penaltyNa2o->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$signNa2o}}</span>{{$certificate->na2o}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penaltyCalor = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 19;
                                            })->first();
                                        
                                            $conditionCalor = $penaltyCalor->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penaltyCalor->penalty_will_get_if_number ?? null;
                                            $certificateCalor = $certificate->calorivic_value ?? null;
                                            $signCalor = '';
                                        
                                            if ($conditionCalor && $penaltyNumber !== null) {
                                                switch ($conditionCalor) {
                                                    case '==': $result = ($certificateCalor == $penaltyNumber); break;
                                                    case '>':  $result = ($certificateCalor > $penaltyNumber); break;
                                                    case '<':  $result = ($certificateCalor < $penaltyNumber); break;
                                                    case '<=': $result = ($certificateCalor <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificateCalor >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $signCalor = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Nilai Kalor ( Calorivic Value )</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->calorivic_value_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penaltyCalor->penalty_will_get_if_sign ?? ''}}   {{$penaltyCalor->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$signCalor}}</span>{{$certificate->calorivic_value}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penaltyNitrogen = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 20;
                                            })->first();
                                        
                                            $conditionNitrogen = $penaltyNitrogen->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penaltyNitrogen->penalty_will_get_if_number ?? null;
                                            $certificateNitrogen = $certificate->nitrogen ?? null;
                                            $signNitrogen = '';
                                        
                                            if ($conditionNitrogen && $penaltyNumber !== null) {
                                                switch ($conditionNitrogen) {
                                                    case '==': $result = ($certificateNitrogen == $penaltyNumber); break;
                                                    case '>':  $result = ($certificateNitrogen > $penaltyNumber); break;
                                                    case '<':  $result = ($certificateNitrogen < $penaltyNumber); break;
                                                    case '<=': $result = ($certificateNitrogen <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificateNitrogen >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $signNitrogen = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Nitrogen</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->nitrogen_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penaltyNitrogen->penalty_will_get_if_sign ?? ''}}   {{$penaltyNitrogen->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$signNitrogen}}</span>{{$certificate->nitrogen}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penaltySulfur = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 26;
                                            })->first();
                                        
                                            $conditionSulfur = $penaltySulfur->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penaltySulfur->penalty_will_get_if_number ?? null;
                                            $certificateSulfur = $certificate->total_sulfur ?? null;
                                            $signSulfur = '';
                                        
                                            if ($conditionSulfur && $penaltyNumber !== null) {
                                                switch ($conditionSulfur) {
                                                    case '==': $result = ($certificateSulfur == $penaltyNumber); break;
                                                    case '>':  $result = ($certificateSulfur > $penaltyNumber); break;
                                                    case '<':  $result = ($certificateSulfur < $penaltyNumber); break;
                                                    case '<=': $result = ($certificateSulfur <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificateSulfur >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $signSulfur = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Sulfur</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->total_sulfur_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penaltySulfur->penalty_will_get_if_sign ?? ''}}   {{$penaltySulfur->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$signSulfur}}</span>{{$certificate->total_sulfur}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penaltyMoisture = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 29;
                                            })->first();
                                        
                                            $conditionMoisture = $penaltyMoisture->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penaltyMoisture->penalty_will_get_if_number ?? null;
                                            $certificateMoisture = $certificate->moisture_total ?? null;
                                            $signMoisture = '';
                                        
                                            if ($conditionMoisture && $penaltyNumber !== null) {
                                                switch ($conditionMoisture) {
                                                    case '==': $result = ($certificateMoisture == $penaltyNumber); break;
                                                    case '>':  $result = ($certificateMoisture > $penaltyNumber); break;
                                                    case '<':  $result = ($certificateMoisture < $penaltyNumber); break;
                                                    case '<=': $result = ($certificateMoisture <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificateMoisture >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $signMoisture = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Total Moisture</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->moisture_total_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penaltyMoisture->penalty_will_get_if_sign ?? ''}}   {{$penaltyMoisture->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$signMoisture}}</span>{{$certificate->moisture_total}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penalty238 = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 31;
                                            })->first();
                                        
                                            $condition238 = $penalty238->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penalty238->penalty_will_get_if_number ?? null;
                                            $certificate238 = $certificate->butiran_238 ?? null;
                                            $sign238 = '';
                                        
                                            if ($condition238 && $penaltyNumber !== null) {
                                                switch ($condition238) {
                                                    case '==': $result = ($certificate238 == $penaltyNumber); break;
                                                    case '>':  $result = ($certificate238 > $penaltyNumber); break;
                                                    case '<':  $result = ($certificate238 < $penaltyNumber); break;
                                                    case '<=': $result = ($certificate238 <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificate238 >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $sign238 = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Ukuran < 2,38</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->butiran_238_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penalty238->penalty_will_get_if_sign ?? ''}}   {{$penalty238->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$sign238}}</span>{{$certificate->butiran_238}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penalty32 = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 32;
                                            })->first();
                                        
                                            $condition32 = $penalty32->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penalty32->penalty_will_get_if_number ?? null;
                                            $certificate32 = $certificate->butiran_32 ?? null;
                                            $sign32 = '';
                                        
                                            if ($condition32 && $penaltyNumber !== null) {
                                                switch ($condition32) {
                                                    case '==': $result = ($certificate32 == $penaltyNumber); break;
                                                    case '>':  $result = ($certificate32 > $penaltyNumber); break;
                                                    case '<':  $result = ($certificate32 < $penaltyNumber); break;
                                                    case '<=': $result = ($certificate32 <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificate32 >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $sign32 = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Ukuran < 32</td>
                                            <td class="border border-slate-900 text-right">{{$spesification->butiran_32_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penalty32->penalty_will_get_if_sign ?? ''}}   {{$penalty32->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$sign32}}</span>{{$certificate->butiran_32}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penalty50 = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 33;
                                            })->first();
                                        
                                            $condition50 = $penalty50->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penalty50->penalty_will_get_if_number ?? null;
                                            $certificate50 = $certificate->butiran_50 ?? null;
                                            $sign50 = '';
                                        
                                            if ($condition50 && $penaltyNumber !== null) {
                                                switch ($condition50) {
                                                    case '==': $result = ($certificate50 == $penaltyNumber); break;
                                                    case '>':  $result = ($certificate50 > $penaltyNumber); break;
                                                    case '<':  $result = ($certificate50 < $penaltyNumber); break;
                                                    case '<=': $result = ($certificate50 <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificate50 >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $sign50 = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Ukuran > 50 </td>
                                            <td class="border border-slate-900 text-right">{{$spesification->butiran_50_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penalty50->penalty_will_get_if_sign ?? ''}}   {{$penalty50->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$sign50}}</span>{{$certificate->butiran_50}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penalty70 = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 34;
                                            })->first();
                                        
                                            $condition70 = $penalty70->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penalty70->penalty_will_get_if_number ?? null;
                                            $certificate70 = $certificate->butiran_70 ?? null;
                                            $sign70 = '';
                                        
                                            if ($condition70 && $penaltyNumber !== null) {
                                                switch ($condition70) {
                                                    case '==': $result = ($certificate70 == $penaltyNumber); break;
                                                    case '>':  $result = ($certificate70 > $penaltyNumber); break;
                                                    case '<':  $result = ($certificate70 < $penaltyNumber); break;
                                                    case '<=': $result = ($certificate70 <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificate70 >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $sign70 = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Ukuran > 70 </td>
                                            <td class="border border-slate-900 text-right">{{$spesification->butiran_70_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penalty70->penalty_will_get_if_sign ?? ''}}   {{$penalty70->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$sign70}}</span>{{$certificate->butiran_70}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        @php
                                            $penaltyVolatile = $penalties->filter(function($penalty) {
                                                return $penalty->unit_penalty_id == 34;
                                            })->first();
                                        
                                            $conditionVolatile = $penaltyVolatile->penalty_will_get_if_sign ?? null;
                                            $penaltyNumber = $penaltyVolatile->penalty_will_get_if_number ?? null;
                                            $certificateVolatile = $certificate->volatile_matter ?? null;
                                            $signVolatile = '';
                                        
                                            if ($conditionVolatile && $penaltyNumber !== null) {
                                                switch ($conditionVolatile) {
                                                    case '==': $result = ($certificateVolatile == $penaltyNumber); break;
                                                    case '>':  $result = ($certificateVolatile > $penaltyNumber); break;
                                                    case '<':  $result = ($certificateVolatile < $penaltyNumber); break;
                                                    case '<=': $result = ($certificateVolatile <= $penaltyNumber); break;
                                                    case '>=': $result = ($certificateVolatile >= $penaltyNumber); break;
                                                    default:   $result = false; break;
                                                }
                                                $signVolatile = $result ? '*' : '';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-900">Volatile Matter </td>
                                            <td class="border border-slate-900 text-right">{{$spesification->volatile_matter_typical}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> {{$penaltyVolatile->penalty_will_get_if_sign ?? ''}}   {{$penaltyVolatile->penalty_will_get_if_number ?? ''}}</td>
                                            <td class="border border-slate-900 text-right"> <span class="text-pink-900">{{$signVolatile}}</span>{{$certificate->volatile_matter}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        <tr>
                                            <td class="border border-slate-900">Slagging Index</td>
                                            <td class="border border-slate-900 text-right">SEVERE</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> > 2,00</td>
                                            <td class="border border-slate-900 text-right">{{$certificate->slagging_index}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        <tr>
                                            <td class="border border-slate-900">Potensial Slagging</td>
                                            <td class="border border-slate-900 text-right">SEVERE</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> > MEDIUM</td>
                                            <td class="border border-slate-900 text-right">{{$certificate->slagging_potensial}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        <tr>
                                            <td class="border border-slate-900">Fouling Index</td>
                                            <td class="border border-slate-900 text-right">0</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> > 5,00</td>
                                            <td class="border border-slate-900 text-right">{{$certificate->fouling_index}}</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                        <tr>
                                            <td class="border border-slate-900">Potensial Fouling</td>
                                            <td class="border border-slate-900 text-right">SEVERE</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right"> > MEDIUM</td>
                                            <td class="border border-slate-900 text-right">LOW</td>
                                            <td class="border border-slate-900 text-right"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-8">
                                <h2 class="text-lg font-semibold">Keterangan</h2>
                                <div class="flex gap-6">
                                    <div class="keterangan">
                                        <p class="mt-2">Bituminous Ash (Rs):</p>
                                        <ul class="list-disc ml-6">
                                            <li>Rs &lt; 0.6 = Low</li>
                                            <li>2.0 &lt; Rs &lt; 2.6 = Medium</li>
                                            <li>2.6 &lt; Rs &lt; 6 = High</li>
                                            <li>6 &lt; Rs = Severe</li>
                                        </ul>
                                    </div>

                                    <div class="keterangan">
                                        <p class="mt-2">Lignitic Ash (Rs):</p>
                                        <ul class="list-disc ml-6">
                                            <li>2450 <  Rs* = Low</li>
                                            <li>2250 <  Rs* < 2450 = Medium</li>
                                            <li>2150 <  Rs* < 2250 = High</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="flex gap-6">
                                    <div class="keterangan mt-2">
                                        <ul class="list-disc ml-6">
                                            <li>Rf < 0.2 = Low</li>
                                            <li>0.2 <  Rf < 0.5 = Medium</li>
                                            <li>2.0 <  Rf < 1.0 = High</li>
                                            <li>1.0 <  Rf = SEVERE</li>
                                        </ul>
                                    </div>


                                    <div class="keterangan">
                                        <p class="mt-2">Bituminous Ash (Rs):</p>
                                        <ul class="list-disc ml-6">
                                            <li>Rs &lt; 0.6 = Low</li>
                                            <li>2.0 &lt; Rs &lt; 2.6 = Medium</li>
                                            <li>2.6 &lt; Rs &lt; 6 = High</li>
                                            <li>6 &lt; Rs = Severe</li>
                                        </ul>
                                    </div>
                                    <div class="keterangan">
                                        <p class="mt-2">Bituminous Ash (Rs):</p>
                                        <ul class="list-disc ml-6">
                                            <li>Rs &lt; 0.6 = Low</li>
                                            <li>2.0 &lt; Rs &lt; 2.6 = Medium</li>
                                            <li>2.6 &lt; Rs &lt; 6 = High</li>
                                            <li>6 &lt; Rs = Severe</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $('.supplier-select').change(function(){
            let id  = $(this).val();
            let token = "{{ csrf_token() }}"
            $(".select-contract").empty()
            $(".select-analysis").empty()
            $.ajax({
                method: "post",
                url: "{{route('getContract')}}",
                data: {
                    _token:token,
                    id:id,
                    },
                success: function (response) {
                    var contracts = response
                    $(".select-contract").append(
                             `<option selected disabled>Pilih nomor kontrak</option>`
                                )
                    contracts.forEach(contract=>{
                        $(".select-contract").append(
                             `<option value="${contract.id}">${contract.contract_number}</option>`
                                )
                            })
                        }
                     })
                })
    </script>
    <script>
        $('.select-type').change(function(){
            let type  = $(this).val();
            let id  =  $('.select-contract').find(":selected").val();
            let token = "{{ csrf_token() }}"
            $(".select-analysis").empty()
            $.ajax({
                method: "post",
                url: "{{route('getCertificate')}}",
                data: {
                    _token:token,
                    type:type,
                    id:id,
                    },
                success: function (response) {
                    var numbers = response
                    console.log(numbers)
                    $(".select-analysis").append(
                             `<option selected disabled>Pilih nomor sertifikat</option>`
                                )
                    numbers.forEach( number=>{
                        $(".select-analysis").append(
                             `<option value="${number.id}">${number.analysis_number}</option>`
                                )
                    })


                    // $(".tonase").append(numberWithCommas(contract.total_volume) + " ton")
                    // $(".masa-berlaku").append(contract.contract_start_date + " s/d "+ contract.contract_end_date)
                }
                })
            })

    </script>
@endsection

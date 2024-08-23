@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen min-h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
            </div>
            <div class="w-full flex justify-center mb-6">
                <form method="get" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                    <div class="mb-4">
                        <select name="supplier_id" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md supplier-select">
                            <option selected disabled>Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{request('supplier_id') == $supplier->id ? 'selected' : ''}}> {{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="contract_id" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md select-contract">
                            @if (request('contract_id'))
                                @isset($numbers)
                                    @foreach ($numbers as $number)
                                        <option value="{{$number->id}}"  {{request('contract_id') == $number->id ? 'selected' : ''}}>{{$number->contract_number}}</option>
                                    @endforeach
                                @endisset
                                
                            @endif
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="type" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md select-type">
                            <option selected disabled>Pilih</option>
                            <option value="1"  {{request('type') == 1 ? 'selected' : ''}}>Loading</option>
                            <option value="2"  {{request('type') == 2 ? 'selected' : ''}}>Unloading</option>
                            <option value="3"  {{request('type') == 3 ? 'selected' : ''}}>Labor</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="analysis_id" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md select-analysis">
                            @if (request('analysis_id'))
                                @isset($analysists)
                                    @foreach ($analysists as $analysis)
                                        <option value="{{$analysis->id}}"  {{request('analysis_id') == $analysis->id ? 'selected' : ''}}>{{$analysis->analysis_number}}</option>
                                    @endforeach
                                @endisset
                                
                            @endif
                        </select>
                    </div>
                    <div class="w-full flex justify-end gap-4">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                    </div>
                </form>
            </div>
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
                                            <td>: {{$analysis_status}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">No. Kontrak</th>
                                            <td>: {{$pemasok->contract_number}} </td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Nama Surveyor</th>
                                            <td>: {{$certificate->surveyor->name ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Pemasok</th>
                                            <td>: {{$pemasok->name}}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-left">Nama Kapal</th>
                                            <td>: PT. TRIYASA</td>
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
                                            <th class="border border-slate-900" colspan="5">Spesifikasi Batu Bara {{$pemasok->name}}</th>
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
                                        @foreach ($penalties as $penalty)
                                            <tr>
                                                <td class="border border-slate-900">{{$penalty->name}}</td>
                                                <td class="border border-slate-900 text-right">{{$spesification[$penalty->unit.'_typical'] ?? '-'}}</td>
                                                <td class="border border-slate-900 text-right"></td>
                                                @php
                                                    $sign ='';
                                                    $condition = $penalty->penalty_will_get_if_sign 
                                                @endphp
                                            
                                                <td class="border border-slate-900 text-right">
                                                    {{$penalty->penalty_will_get_if_sign}} {{$penalty->penalty_will_get_if_number}}
                                                    @switch($condition)
                                                        @case('==')
                                                            @php
                                                                $result = $certificate[$penalty->unit] == $penalty->penalty_will_get_if_number;

                                                                $sign = $result ? '*' :'';
                                                            @endphp
                                                            @break
                                                        @case('>')
                                                            @php
                                                                $result = $certificate[$penalty->unit] > $penalty->penalty_will_get_if_number;

                                                                $sign = $result ? '*' :'';
                                                            @endphp
                                                            @break
                                                        @case('<')
                                                            @php
                                                                $result = $certificate[$penalty->unit] < $penalty->penalty_will_get_if_number;

                                                                $sign = $result ? '*' :'';
                                                            @endphp
                                                            @break
                                                        @case('<=')
                                                            @php
                                                                $result = $certificate[$penalty->unit] <= $penalty->penalty_will_get_if_number;

                                                                $sign = $result ? '*' :'';
                                                            @endphp
                                                            @break
                                                        @case('>=')
                                                            @php
                                                                $result = $certificate[$penalty->unit] >= $penalty->penalty_will_get_if_number;

                                                                $sign = $result ? '*' :'';
                                                            @endphp
                                                            @break
                                                        @default
                                                            @php
                                                                $sign = '';
                                                            @endphp
                                                    @endswitch
                                                  
                                                </td>
                                                
                                                <td class="border border-slate-900 text-right">{{$certificate[$penalty->unit]}}   <span class="text-pink-900"> {{$sign}}</span></td>
                                                <td class="border border-slate-900 text-right">wt%</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="border border-slate-900">Slagging Index</td>
                                            <td class="border border-slate-900 text-right"></td>
                                            <td class="border border-slate-900 text-right">SEVERE</td>
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

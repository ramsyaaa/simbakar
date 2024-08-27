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
                        <select name="ship_id" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md ship-select">
                            <option selected disabled>Pilih Kapal</option>
                            @foreach ($ships as $ship)
                                <option value="{{$ship->id}}" {{request('ship_id') == $ship->id ? 'selected' : ''}}> {{$ship->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="contract_id" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md select-contract">
                            @if (request('contract_id'))
                                @isset($numbers)
                                    @foreach ($numbers as $number)
                                        <option value="{{$number->id}}"  {{request('contract_id') == $number->id ? 'selected' : ''}}>{{date('d F Y', strtotime($number->receipt_date))}}</option>
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
            @isset($loading)     

            <div id="my-pdf">
                
                <div class="bg-white rounded-lg p-6 body">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <img src="{{asset('logo.png')}}" alt="" width="200">
                            <p class="text-right">UBP SURALAYA</p>
                        </div>
                        <div class="text-center text-[20px] font-bold">
                            <p>Perbandingan Hasil Analisa Kualitas Batu Bara Kapal {{$ship->name ?? ''}}</p>
                            <p>{{$pemasok->name ?? ''}} Tanggal {{date('d F Y', strtotime($contract->receipt_date))}}</p>
                            {{-- <p>No: {{$tug->bpb_number}}/IBPB/UBPSLA/PBB/{{date('Y')}}</p> --}}
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-auto hide-scrollbar max-w-full">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="border border-gray-400 p-2" rowspan="2">No</th>
                                    <th class="border border-gray-400 p-2" rowspan="2">Parameter</th>
                                    <th class="border border-gray-400 p-2" colspan="3">Hasil Analisa</th>
                                    <th class="border border-gray-400 p-2" colspan="3">Selisih</th>
                                </tr>
                                <tr>
                                    <th class="border border-gray-400 p-2">Loading Port</th>
                                    <th class="border border-gray-400 p-2">Unloading</th>
                                    <th class="border border-gray-400 p-2">Labor SLA</th>
                                    <th class="border border-gray-400 p-2">Loading dan Unloading Port</th>
                                    <th class="border border-gray-400 p-2">Unloading Port dan Labor SLA</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td class="border border-gray-400 p-2">1</td>
                                        <td class="border border-gray-400 p-2">Total Moisure ( Ar )</td>
                                        <td class="border border-gray-400 p-2">{{$loading->moisture_total ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->moisture_total ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->moisture_total ?? '-'}}</td>
                                        @php
                                            $selisih_moisture_unloading = $loading->moisture_total - $unloading->moisture_total ;
                                            $selisih_moisture_labor = $loading->moisture_total - $labor->moisture_total ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_moisture_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_moisture_labor ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-2">2</td>
                                        <td class="border border-gray-400 p-2">Inherent Moisture ( Adb )</td>
                                        <td class="border border-gray-400 p-2">{{$loading->air_dried_moisture ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->air_dried_moisture ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->air_dried_moisture ?? '-'}}</td>
                                        @php
                                            $selisih_dried_unloading = $loading->air_dried_moisture - $unloading->air_dried_moisture ;
                                            $selisih_dried_labor = $loading->air_dried_moisture - $labor->air_dried_moisture ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_dried_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_dried_labor ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-2">3</td>
                                        <td class="border border-gray-400 p-2">Sulfur ( Adb )</td>
                                        <td class="border border-gray-400 p-2">{{$loading->total_sulfur ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->total_sulfur ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->total_sulfur ?? '-'}}</td>
                                        @php
                                            $selisih_sulfur_unloading = $loading->total_sulfur - $unloading->total_sulfur ;
                                            $selisih_sulfur_labor = $loading->total_sulfur - $labor->total_sulfur ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_sulfur_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_sulfur_labor ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-2">4</td>
                                        <td class="border border-gray-400 p-2">Gross Calorivic Value</td>
                                        <td class="border border-gray-400 p-2">{{$loading->total_sulfur ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->calorivic_value ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->calorivic_value ?? '-'}}</td>
                                        @php
                                            $selisih_calor_unloading = $loading->calorivic_value - $unloading->calorivic_value ;
                                            $selisih_calor_labor = $loading->calorivic_value - $labor->calorivic_value ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_calor_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_calor_labor ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-2">5</td>
                                        <td class="border border-gray-400 p-2">Nitrogen</td>
                                        <td class="border border-gray-400 p-2">{{$loading->nitrogen ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->nitrogen ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->nitrogen ?? '-'}}</td>
                                        @php
                                            $selisih_nitrogen_unloading = $loading->nitrogen - $unloading->nitrogen ;
                                            $selisih_nitrogen_labor = $loading->nitrogen - $labor->nitrogen ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_nitrogen_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_nitrogen_labor ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-2">6</td>
                                        <td class="border border-gray-400 p-2">HGI</td>
                                        <td class="border border-gray-400 p-2">{{$loading->hgi ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->hgi ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->hgi ?? '-'}}</td>
                                        @php
                                            $selisih_hgi_unloading = $loading->hgi - $unloading->hgi ;
                                            $selisih_hgi_labor = $loading->hgi - $labor->hgi ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_hgi_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_hgi_labor ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-2">7</td>
                                        <td class="border border-gray-400 p-2">Ash Content ( Adb )</td>
                                        <td class="border border-gray-400 p-2">{{$loading->ash ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->ash ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->ash ?? '-'}}</td>
                                        @php
                                            $selisih_ash_unloading = $loading->ash - $unloading->ash ;
                                            $selisih_ash_labor = $loading->ash - $labor->ash ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_ash_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_ash_labor ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-2">8</td>
                                        <td class="border border-gray-400 p-2">Ukuran Butiran < 2.38 mm</td>
                                        <td class="border border-gray-400 p-2">{{$loading->butiran_238 ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->butiran_238 ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->butiran_238 ?? '-'}}</td>
                                        @php
                                            $selisih_238_unloading = $loading->butiran_238 - $unloading->butiran_238 ;
                                            $selisih_238_labor = $loading->butiran_238 - $labor->butiran_238 ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_238_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_238_labor ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-2">9</td>
                                        <td class="border border-gray-400 p-2">Ukuran Butiran < 32 mm</td>
                                        <td class="border border-gray-400 p-2">{{$loading->butiran_32 ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->butiran_32 ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->butiran_32 ?? '-'}}</td>
                                        @php
                                            $selisih_32_unloading = $loading->butiran_32 - $unloading->butiran_32 ;
                                            $selisih_32_labor = $loading->butiran_32 - $labor->butiran_32 ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_32_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_32_labor ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-2">10</td>
                                        <td class="border border-gray-400 p-2">Ukuran Butiran < 50 mm</td>
                                        <td class="border border-gray-400 p-2">{{$loading->butiran_50 ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->butiran_50 ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->butiran_50 ?? '-'}}</td>
                                        @php
                                            $selisih_50_unloading = $loading->butiran_50 - $unloading->butiran_50 ;
                                            $selisih_50_labor = $loading->butiran_50 - $labor->butiran_50 ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_50_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_50_labor ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-2">11</td>
                                        <td class="border border-gray-400 p-2">Inherent Deformation</td>
                                        <td class="border border-gray-400 p-2">{{$loading->inherent_deformation ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->inherent_deformation ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->inherent_deformation ?? '-'}}</td>
                                        @php
                                            $selisih_deformation_unloading = $loading->inherent_deformation - $unloading->inherent_deformation ;
                                            $selisih_deformation_labor = $loading->inherent_deformation - $labor->inherent_deformation ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_deformation_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_deformation_labor ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-400 p-2">12</td>
                                        <td class="border border-gray-400 p-2">Slagging Index</td>
                                        <td class="border border-gray-400 p-2">{{$loading->slagging_index ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->slagging_index ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->slagging_index ?? '-'}}</td>
                                        @php
                                            $selisih_slagging_index_unloading = $loading->slagging_index - $unloading->slagging_index ;
                                            $selisih_slagging_index_labor = $loading->slagging_index - $labor->slagging_index ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_slagging_index_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$selisih_slagging_index_labor ?? '-'}}</td>
                                    </tr>
                                        <td class="border border-gray-400 p-2">13</td>
                                        <td class="border border-gray-400 p-2">Potensial Slagging</td>
                                        <td class="border border-gray-400 p-2">{{$loading->potensial_slagging ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->potensial_slagging ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->potensial_slagging ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">-</td>
                                        <td class="border border-gray-400 p-2">-</td>
                                    </tr>
                                    </tr>
                                        <td class="border border-gray-400 p-2">14</td>
                                        <td class="border border-gray-400 p-2">Fouling Index</td>
                                        <td class="border border-gray-400 p-2">{{$loading->fouling_index ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->fouling_index ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->fouling_index ?? '-'}}</td>
                                        @php
                                            $selisih_fouling_index_unloading = $loading->fouling_index - $unloading->fouling_index ;
                                            $selisih_fouling_index_labor = $loading->fouling_index - $labor->fouling_index ;
                                        @endphp
                                        <td class="border border-gray-400 p-2">{{$selisih_fouling_index_unloading ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">-</td>
                                    </tr>
                                    </tr>
                                        <td class="border border-gray-400 p-2">15</td>
                                        <td class="border border-gray-400 p-2">Potensial Fouling</td>
                                        <td class="border border-gray-400 p-2">{{$loading->potensial_fouling ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$unloading->potensial_fouling ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">{{$labor->potensial_fouling ?? '-'}}</td>
                                        <td class="border border-gray-400 p-2">-</td>
                                        <td class="border border-gray-400 p-2">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endisset
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('.supplier-select').change(function(){  
        $(".select-contract").empty()
    })
</script>
    <script>
        $('.ship-select').change(function(){  
            let supplier_id  =  $('.supplier-select').find(":selected").val();
            let ship_id  = $(this).val();
            let token = "{{ csrf_token() }}"
            $(".select-contract").empty()
            $.ajax({
                method: "post",
                url: "{{route('getContractShip')}}",
                data: {
                    _token:token,
                    supplier_id:supplier_id,
                    ship_id:ship_id,
                    },
                success: function (response) {
                    var contracts = response
                    console.log(contracts)
                    $(".select-contract").append(
                             `<option selected disabled>Pilih Tanggal</option>`
                                )
                    contracts.forEach(contract=>{
                        $(".select-contract").append(
                             `<option value="${contract.id}">${contract.receipt_date}</option>`
                                )
                            })
                        
                }
                })
            })

    </script>
@endsection

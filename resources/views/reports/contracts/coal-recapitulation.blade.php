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
                        <select name="supplier_id" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md supplier-select" required>
                            <option value="">Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{request('supplier_id') == $supplier->id ? 'selected' : ''}}> {{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="contract_id" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md select-contract" required>
                            @if (request('contract_id'))
                                @isset($numbers)
                                    @foreach ($numbers as $number)
                                        <option value="{{$number->id}}"  {{request('contract_id') == $number->id ? 'selected' : ''}}>{{$number->contract_number}}</option>
                                    @endforeach
                                @endisset
                                
                            @endif
                        </select>
                    </div>
                    <div>
                        <label for="" class="w-full text-sm">Jumlah Tonase pada kontrak / adendum <span class="tonase"></span></label>
                    </div>
                    <div>
                        <label for="" class="w-full text-sm">Masa berlaku <span class="masa-berlaku"></span></label>
                    </div>

                    <div class="w-full flex justify-end gap-4">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                    </div>
                </form>
            </div>
            @isset($contracts)

            <div id="my-pdf">

                <div class="bg-white rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <img src="{{asset('logo.png')}}" alt="" width="200">
                            <p class="text-right">UBP SURALAYA</p>
                        </div>
                        <div class="text-center text-[20px] font-bold">
                            <p>REKAPITULASI REALISASI KONTRAK BATU BARA {{$contracts[0]->supplier->name ?? ''}}</p>
                            <p>{{$contracts[0]->contract->contract_number ?? ''}}</p>
                            {{-- <p>No: {{$tug->bpb_number}}/IBPB/UBPSLA/PBB/{{date('Y')}}</p> --}}
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-auto hide-scrollbar max-w-full">
                        <table class="min-w-max">
                            <thead>
                                <tr>
                                    <th class="border border-gray-400 p-2">No</th>
                                    <th class="border border-gray-400 p-2">Nama Kapal</th>
                                    <th class="border border-gray-400 p-2">Tanggal Bongkar</th>
                                    <th class="border border-gray-400 p-2">Tanggal Selesai</th>
                                    <th class="border border-gray-400 p-2">Lama Bongkar</th>
                                    <th class="border border-gray-400 p-2">DS</th>
                                    <th class="border border-gray-400 p-2">BL</th>
                                    <th class="border border-gray-400 p-2">TUG 3</th>
                                    <th class="border border-gray-400 p-2">Dermaga</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    @foreach ($contracts as $contract)
                                    <tr>
                                        <td class="border border-gray-400 p-2">{{$loop->iteration}}</td>
                                        <td class="border border-gray-400 p-2">{{$contract->ship->name ?? ''}}</td>
                                        <td class="border border-gray-400 p-2">{{$contract->unloading_date}}</td>
                                        <td class="border border-gray-400 p-2">{{$contract->end_date}}</td>
                                        <td class="border border-gray-400 p-2">{{$contract->duration_time}}</td>
                                        <td class="border border-gray-400 p-2">{{ number_format($contract->ds)}}</td>
                                        <td class="border border-gray-400 p-2">{{ number_format($contract->bl)}}</td>
                                        <td class="border border-gray-400 p-2">{{ number_format($contract->tug_3_accept)}}</td>
                                        <td class="border border-gray-400 p-2">{{$contract->dock->name ?? ''}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td class="border border-gray-400 p-2" colspan="5">Total</td>
                                        <td class="border border-gray-400 p-2">{{ number_format($ds)}}</td>
                                        <td class="border border-gray-400 p-2">{{ number_format($bl)}}</td>
                                        <td class="border border-gray-400 p-2">{{ number_format($tug)}}</td>
                                        <td class="border border-gray-400 p-2"></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endisset

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
            $(".tonase").empty()
            $(".masa-berlaku").empty()
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
                             `<option value="">Pilih nomor kontrak</option>`
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
        $('.select-contract').change(function(){  
            let id  = $(this).val();
            let token = "{{ csrf_token() }}"
            $(".tonase").empty()
            $(".masa-berlaku").empty()
            $.ajax({
                method: "post",
                url: "{{route('getNumber')}}",
                data: {
                    _token:token,
                    id:id,
                    },
                success: function (response) {
                    var contract = response
                    console.log(contract)
                    $(".tonase").append(numberWithCommas(contract.total_volume) + " ton")
                    $(".masa-berlaku").append(contract.contract_start_date + " s/d "+ contract.contract_end_date)
                }
                })
            })

    </script>
@endsection

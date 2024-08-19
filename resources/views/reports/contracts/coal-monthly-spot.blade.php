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
                        <select name="supplier" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option value="0" {{request('supplier') == 0 ? 'selected' : ''}}>Semua Pemasok</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{request('supplier') == $supplier->id ? 'selected' : ''}}>{{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option value="">Tahun</option>
                            @for ($i = date('Y'); $i >= 2000; $i--)
                                <option {{request()->year == $i ? 'selected' :''}}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="w-full flex justify-end gap-4">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                    </div>
                </form>
            </div>

            <div id="my-pdf">
                <div class="bg-white rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <img src="{{asset('logo.png')}}" alt="" width="200">
                            <p class="text-right">UBP SURALAYA</p>
                        </div>
                        <div class="text-center text-[20px] font-bold">
                            <p class="uppercase">rekapitulasi rencana & simulasi kontrak spot batu bara {{request('supplier') == 0  ? 'Semua Pemasok' : $name->name}} tahun {{$year}}</p>
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-auto hide-scrollbar max-w-full">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="border border-gray-400 p-2">Bulan</th>
                                    <th colspan="2" class="border border-gray-400 p-2">Rencana</th>
                                    <th colspan="2" class="border border-gray-400 p-2">Realisasi</th>
                                    <th colspan="2" class="border border-gray-400 p-2">Deviasi Realisasi</th>
                                </tr>
                                <tr>
                                    <th class="border border-gray-400 p-2">Kontrak ( Ton )</th>
                                    <th class="border border-gray-400 p-2">Adendum ( Ton )</th>
                                    <th class="border border-gray-400 p-2">Ton</th>
                                    <th class="border border-gray-400 p-2">%</th>
                                    <th class="border border-gray-400 p-2">Kontrak ( Ton )</th>
                                    <th class="border border-gray-400 p-2">Adendum ( Ton )</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $sumTon = 0;
                                $sumPlan = 0;
                                $sumAdendum = 0;
                                @endphp
                            @foreach ($contracts as $key => $contract)     
                            @php
                                $sumTon = $sumTon + $contract['ton'];
                                $sumPlan = $sumPlan + $contract['plan_realisasi'];
                                $sumAdendum = $sumAdendum + $contract['adendum_realisasi'];
                                @endphp      
                                <tr>
                                    <td class="border border-gray-400 p-2">{{$contract['month']}}</td>
                                    <td class="border border-gray-400 p-2">{{$contract['plan_kontrak']}}</td>
                                    <td class="border border-gray-400 p-2">{{$contract['adendum_kontrak']}}</td>
                                    <td class="border border-gray-400 p-2">{{ number_format($contract['ton'])}}</td>
                                    <td class="border border-gray-400 p-2">{{$contract['%']}}</td>
                                    <td class="border border-gray-400 p-2">{{ number_format($contract['plan_realisasi'])}}</td>
                                    <td class="border border-gray-400 p-2">{{ number_format($contract['adendum_realisasi'])}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td class="border border-gray-400 p-2">Total</td>
                                    <td class="border border-gray-400 p-2"></td>
                                    <td class="border border-gray-400 p-2"></td>
                                    <td class="border border-gray-400 p-2">{{ number_format($sumTon)}}</td>
                                    <td class="border border-gray-400 p-2">0</td>
                                    <td class="border border-gray-400 p-2">{{ number_format($sumPlan)}}</td>
                                    <td class="border border-gray-400 p-2">{{ number_format($sumAdendum)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection

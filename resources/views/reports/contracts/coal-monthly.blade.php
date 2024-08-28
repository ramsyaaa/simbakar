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
                        <select name="type" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option>Jangka Panjang</option>
                            <option>Jangka Menengah</option>
                            <option>Spot</option>
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

            <div id="my-pdf" class="bg-white rounded-lg p-6">
                <div class="body">

                <div class="flex justify-between items-center mb-4">
                    <div>
                        <img src="{{asset('logo.png')}}" alt="" width="200">
                        <p class="text-right">UBP SURALAYA</p>
                    </div>
                    <div class="text-center text-[20px] font-bold">
                        <p>RENCANA DAN REALISASI KONTRAK BATUBARA TAHUN {{ request()->year ?? ''}}</p>
                    </div>
                    <div></div>
                </div>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th rowspan="2" class="border border-gray-400 p-2">Kontrak</th>
                                <th rowspan="2" colspan="2" class="border border-gray-400 p-2">Rencana dan realisasi</th>
                                <th colspan="12" class="border border-gray-400 p-2">Tahun 2024</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Jumlah</th>
                            </tr>
                            <tr>
                                <th class="border border-gray-400 p-2">Januari</th>
                                <th class="border border-gray-400 p-2">Febuari</th>
                                <th class="border border-gray-400 p-2">Maret</th>
                                <th class="border border-gray-400 p-2">April</th>
                                <th class="border border-gray-400 p-2">Mei</th>
                                <th class="border border-gray-400 p-2">Juni</th>
                                <th class="border border-gray-400 p-2">Juli</th>
                                <th class="border border-gray-400 p-2">Agustus</th>
                                <th class="border border-gray-400 p-2">September</th>
                                <th class="border border-gray-400 p-2">Oktober</th>
                                <th class="border border-gray-400 p-2">November</th>
                                <th class="border border-gray-400 p-2">Desember</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contracts as $key => $contract)
                            <tr>
                                <td rowspan="4" class="border border-gray-400 p-2">
                                   {{$key}} 
                                </td>
                                    <td class="border border-gray-400 p-2" rowspan="2">Rencana</td>
                                    <td class="border border-gray-400 p-2">Kontrak</td>
                                    @php
                                        $sumKontrak  = 0;
                                    @endphp
                                    @foreach ($contract as $month => $value)
                                        @php
                                            $sumKontrak  = $value['kontrak'] + $sumKontrak;
                                        @endphp
                                        <td class="border border-gray-400 p-2"> {{ number_format($value['kontrak'])}}</td>
                                    @endforeach
                                        <td class="border border-gray-400 p-2"> {{ number_format($sumKontrak)}}</td>
                                </tr>
                                <tr>
                                    @php
                                        $sumRakor  = 0;
                                    @endphp
                                    <td class="border border-gray-400 p-2">Rakor</td>
                                    @foreach ($contract as $month => $value)
                                        @php
                                            $sumRakor  = $value['rakor'] + $sumRakor;
                                        @endphp
                                        <td class="border border-gray-400 p-2"> {{ number_format($value['rakor'])}}</td>
                                    @endforeach
                                    <td class="border border-gray-400 p-2"> {{ number_format($sumRakor)}}</td>
                                </tr>
                                <tr>
                                    @php
                                        $sumTon  = 0;
                                    @endphp
                                    <td class="border border-gray-400 p-2" rowspan="2">Realisasi</td>
                                    <td class="border border-gray-400 p-2">Ton</td>
                                    @foreach ($contract as $month => $value)
                                    @php
                                        $sumTon  = $value['ton'] + $sumTon;
                                    @endphp
                                        <td class="border border-gray-400 p-2"> {{ number_format($value['ton'])}}</td>
                                    @endforeach
                                    <td class="border border-gray-400 p-2"> {{ number_format($sumTon)}}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 p-2">( % )</td>
                                    @foreach ($contract as $month => $value)
                                        <td class="border border-gray-400 p-2"> {{$value['%']}}</td>
                                        @endforeach
                                        <td class="border border-gray-400 p-2">0</td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        </div>
    </div>
</div>
@endsection

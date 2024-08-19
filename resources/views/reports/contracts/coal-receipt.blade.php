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
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <img src="{{asset('logo.png')}}" alt="" width="200">
                        <p class="text-right">UBP SURALAYA</p>
                    </div>
                    <div class="text-center text-[20px] font-bold">
                        <p>REKAPITULASI PENERIMAAN BATU BARA <br> PT INDONESIA POWER UBP. SURALAYA <br> TAHUN {{ request('year' ?? '')}}</p>
                    </div>
                    <div></div>
                </div>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th rowspan="2" class="border border-gray-400 p-2">No</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Pemasok</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Kontrak</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Volume Kontrak ( Ton )</th>
                                <th colspan="12" class="border border-gray-400 p-2">Realisasi Tahun {{request('year') ?? ''}}</th>
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
                            @php
                                $jan = 0;
                                $feb = 0;
                                $mar = 0;
                                $apr = 0;
                                $mei = 0;
                                $jun = 0;
                                $jul = 0;
                                $aug = 0;
                                $sep = 0;
                                $oct = 0;
                                $nov = 0;
                                $des = 0;
                                $total = 0;
                            @endphp
                            @foreach ($contracts as $key => $contract)
                            @php
                                $total = $contract->total + $total;
                            @endphp
                            <tr>
                                <td class="border border-gray-400 p-2">{{$loop->iteration}}</td>
                                <td class="border border-gray-400 p-2">{{$contract->name}}</td>
                                <td class="border border-gray-400 p-2">{{$contract->contract_number}}</td>
                                <td class="border border-gray-400 p-2">{{ number_format($contract->total_volume)}}</td>
                                @foreach ($contract->data as $key => $item)
                                    @if ($key == 1)
                                        @php
                                            $jan = $jan + $item;
                                        @endphp
                                    @endif
                                    @if ($key == 2)
                                        @php
                                            $feb = $feb + $item;
                                        @endphp
                                    @endif
                                    @if ($key == 3)
                                        @php
                                            $mar = $mar + $item;
                                        @endphp
                                    @endif
                                    @if ($key == 4)
                                        @php
                                            $apr = $mar + $item;
                                        @endphp
                                    @endif
                                    @if ($key == 5)
                                        @php
                                            $mei = $mei + $item;
                                        @endphp
                                    @endif
                                    @if ($key == 6)
                                        @php
                                            $jun = $jun + $item;
                                        @endphp
                                    @endif
                                    @if ($key == 7)
                                        @php
                                            $jul = $jul + $item;
                                        @endphp
                                    @endif
                                    @if ($key == 8)
                                        @php
                                            $aug = $aug + $item;
                                        @endphp
                                    @endif
                                    @if ($key == 9)
                                        @php
                                            $sep = $sep + $item;
                                        @endphp
                                    @endif
                                    @if ($key == 10)
                                        @php
                                            $oct = $oct + $item;
                                        @endphp
                                    @endif
                                    @if ($key == 11)
                                        @php
                                            $nov = $nov + $item;
                                        @endphp
                                    @endif
                                    @if ($key == 12)
                                        @php
                                            $des = $des + $item;
                                        @endphp
                                    @endif
                                    <td class="border border-gray-400 p-2">{{ number_format($item)}}</td>
                                @endforeach
                               
                                <td class="border border-gray-400 p-2">{{number_format($contract->total)}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="border border-gray-400 p-2 text-center" colspan="4">Total</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($jan)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($feb)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($mar)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($apr)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($mei)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($jun)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($jul)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($aug)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($sep)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($oct)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($nov)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($des)}}</td>
                                <td class="border border-gray-400 p-2 text-center">{{number_format($total)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

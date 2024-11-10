@extends('layouts.app')


@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        Filter Pemakaian @if($type_bbm == 'solar')HSD @elseif($type_bbm == 'residu')MFO @endif @if($type == 'heavy_equipment') Albes @elseif ($type == "unit") Unit @elseif($type == 'other') Lainnya @endif
                    </div>
                </div>
            </div>
            <div class="w-full flex justify-center mb-6">
                <form method="POST" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                    @csrf
                    <div class="mb-4">
                        <div class="w-full mb-2 lg:mb-0">
                            <select id="tahunInput" name="tahunInput" class="w-full h-[44px] rounded-md border px-2" autofocus>
                                <option selected disabled>Pilih Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option {{request()->tahunInput == $i ? 'selected' :''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="w-full flex justify-end gap-4">
                        <a href="{{ route('reports.executive-summary.index') }}" class="bg-red-500 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
                        <button type="button" class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="ExportToExcel('xlsx')">Download</button>
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                    </div>
                </form>
            </div>

            @if($tahunInput != null)
            <div id="my-pdf" class="bg-white rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <img src="{{asset('logo.png')}}" alt="" width="200">
                        <p class="text-right">UBP SURALAYA</p>
                    </div>
                    <div class="text-center text-[20px] font-bold">
                        <p>Laporan Pemakaian @if($type_bbm == 'solar')HSD @elseif($type_bbm == 'residu')MFO @endif @if($type == 'heavy_equipment') Albes @elseif ($type == "unit") Unit @elseif($type == 'other') Lainnya @endif</p>
                        {{-- <p>No: {{$tug->bpb_number}}/IBPB/UBPSLA/PBB/{{date('Y')}}</p> --}}
                    </div>
                    <div></div>
                </div>
                <div class="overflow-auto max-w-full">
                    <table class="w-full" id="table">
                        <thead>
                            <tr>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Bulan</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Unit 1-4 (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Unit 5-7 (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Total Unit 5-7 (Liter)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $months = [
                                    1 => "Januari",
                                    2 => "Februari",
                                    3 => "Maret",
                                    4 => "April",
                                    5 => "Mei",
                                    6 => "Juni",
                                    7 => "Juli",
                                    8 => "Agustus",
                                    9 => "September",
                                    10 => "Oktober",
                                    11 => "November",
                                    12 => "Desember"
                                ];
                            @endphp
                            @foreach ($bbm_usage_1_4 as $index => $usage)
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2 font-bold">{{ $months[$index] }}</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ number_format($usage, 0, '.', ',') }}</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ number_format($bbm_usage_5_7[$index], 0, '.', ',') }}</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ number_format(($usage + $bbm_usage_5_7[$index]), 0, '.', ',') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold bg-gray-300">Jumlah</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold bg-gray-300 text-center">{{ number_format(array_sum($bbm_usage_1_4), 0, '.', ',') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold bg-gray-300 text-center">{{ number_format(array_sum($bbm_usage_5_7), 0, '.', ',') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold bg-gray-300 text-center">{{ number_format((array_sum($bbm_usage_1_4) + array_sum($bbm_usage_5_7)), 0, '.', ',') }}</td>
                            </tr>
                            
                            {{-- <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold">Jumlah</td>
                                @foreach ($total_permonth as $item)
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold">{{ number_format($item, 0, '.', ',') }}</td>
                                @endforeach
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

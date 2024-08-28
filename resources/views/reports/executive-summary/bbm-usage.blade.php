@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen min-h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
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
                        <input type="number" name="tahunInput" class="border h-[40px] w-full rounded-lg px-3" value="{{ request('tahun', $tahunInput) }}" min="1980" max="2200">
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
                        <p>Laporan Pemakaian @if($type_bbm == 'solar')HSD @elseif($type_bbm == 'residu')MFO @endif @if($type == 'heavy_equipment') Albes @elseif ($type == "unit") Unit @elseif($type == 'other') Lainnya @endif</p>
                        {{-- <p>No: {{$tug->bpb_number}}/IBPB/UBPSLA/PBB/{{date('Y')}}</p> --}}
                    </div>
                    <div></div>
                </div>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Unit</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="13">Bulan</th>
                            </tr>
                            <tr>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Jan <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Feb <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Mar <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Apr <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Mei <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Jun <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Jul <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Agu <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Sep <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Okt <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Nov <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Des <br> (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $total_permonth = [0,0,0,0,0,0,0,0,0,0,0,0,0];
                            @endphp

                            @foreach ($bbm_usage as $index => $item)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $index }}</td>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($item as $index1 => $item1)
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item1 }}</td>
                                @php
                                    $total_permonth[$i] = $total_permonth[$i] + $item1;
                                    $i = $i + 1;
                                @endphp
                                @endforeach
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ array_sum($item) }}</td>
                                @php
                                    $total_permonth[12] =  $total_permonth[12]+array_sum($item);
                                @endphp
                            </tr>
                            @endforeach
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold">Jumlah</td>
                                @foreach ($total_permonth as $item)
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold">{{ $item }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

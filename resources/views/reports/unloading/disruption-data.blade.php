@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="flex items-end justify-between mb-2">
            </div>
            <div class="w-full flex justify-center mb-6">
                <form method="get" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                    <div class="mb-4">
                        <select name="supplier_id" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md supplier-select" required>
                            <option value="0">Semua Pemasok</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{request('supplier_id') == $supplier->id ? 'selected' : ''}}> {{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="date" class="font-bold text-[#232D42] text-[16px]">Tanggal</label>
                        <div class="relative">
                            <input required type="month" name="date" value="{{ request('date') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                        </div>
                    </div>

                    <div class="w-full flex justify-end gap-4">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button type="button" class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="ExportToExcel('xlsx')">Download</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                        <a href="{{route('reports.coal-quality.index')}}" class="bg-pink-900 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
                    </div>
                </form>
            </div>
            @isset($coals)

            <div id="my-pdf">

                <div class="bg-white rounded-lg p-6 body">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <img src="{{asset('logo.png')}}" alt="" width="200">
                            <p class="text-right">UBP SURALAYA</p>
                        </div>
                        <div class="text-center text-[20px] font-bold">
                            <p>DATA GANGGUAN UBP.  SURALAYA DAN GANGGUAN KAPAL</p>
                            <p> PENERIMAAN {{$pemasok->name ?? ''}} Bulan {{date('F Y', strtotime(request('date')))}}</p> 
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-max" id="table">
                            <thead>
                                <tr>
                                    <th class="border border-gray-400 p-2" colspan="12">Data Gangguan UBP Suralaya</th>
                                </tr>
                                <tr>
                                    <th class="border border-gray-400 p-2" rowspan="2">No</th>
                                    <th class="border border-gray-400 p-2" rowspan="2">Nama Kapal</th>
                                    <th class="border border-gray-400 p-2" rowspan="2">Tanggal Penerimaan</th>
                                    <th class="border border-gray-400 p-2">Tonase</th>
                                    <th class="border border-gray-400 p-2" colspan="3">Jenis Gangguan PLTU</th>
                                    <th class="border border-gray-400 p-2" colspan="2">Waktu Durasi</th>
                                    <th class="border border-gray-400 p-2">Jumlah</th>
                                    <th class="border border-gray-400 p-2">Total Gangguan SLA</th>
                                    <th class="border border-gray-400 p-2">Total Gangguan</th>
                                </tr>
                                <tr>
                                    <th class="border border-gray-400 p-2">Kg</th>
                                    <th class="border border-gray-400 p-2">Tanggal</th>
                                    <th class="border border-gray-400 p-2">DMG</th>
                                    <th class="border border-gray-400 p-2">Uraian</th>
                                    <th class="border border-gray-400 p-2">Jam Mulai</th>
                                    <th class="border border-gray-400 p-2">Jam Akhir</th>
                                    <th class="border border-gray-400 p-2">Menit</th>
                                    <th class="border border-gray-400 p-2">Menit</th>
                                    <th class="border border-gray-400 p-2">Jam</th>

                                </tr>
                            </thead>
                        <tbody>
                            @php
                                $totalTug = 0;
                                $totalMinute = 0;
                            @endphp
                            @foreach ($coals as $coal)
                            
                            @php
                                $totalTime = 0;    
                                $iteration = $loop->iteration
                            @endphp
                                @foreach ($coal as $item)
                                    @php
                                        $totalTime = $item->minutes + $totalTime;
                                    @endphp
                                    <tr>
                                        <td class="border border-gray-400 p-2">
                                            @if ($loop->first)
                                                {{$iteration}}
                                                
                                            @endif
                                        </td>
                                        <td class="border border-gray-400 p-2">
                                            @if ($loop->first)
                                            {{$item->name}}
                                                
                                            @endif
                                        </td>
                                        <td class="border border-gray-400 p-2">
                                            {{$item->receipt_date}}       
                                        </td>
                                        <td class="border border-gray-400 p-2">
                                            @if ($loop->first)
                                            @php
                                                $totalTug = $item->tug_3_accept + $totalTug;
                                            @endphp
                                                {{number_format($item->tug_3_accept)}}
                                                
                                            @endif
                                        </td>
                                        <td class="border border-gray-400 p-2">{{date('d-m-Y', strtotime($item->start_disruption_date))}}</td>
                                        <td class="border border-gray-400 p-2">
                                            @if ($loop->first)
                                            2
                                                
                                            @endif
                                        </td>
                                        <td class="border border-gray-400 p-2">{{$item->kind_disruption}}</td>
                                        <td class="border border-gray-400 p-2">{{date('H:i:s', strtotime($item->start_disruption_date))}}</td>
                                        <td class="border border-gray-400 p-2">{{date('H:i:s', strtotime($item->end_disruption_date))}}</td>
                                        <td class="border border-gray-400 p-2">{{$item->minutes}}</td>
                                        <td class="border border-gray-400 p-2">
                                            @if ($loop->last)
                                                @php
                                                $totalMinute = $totalTime + $totalMinute;
                                                @endphp
                                                {{$totalTime}}
                                            
                                            @endif
                                        </td>
                                        <td class="border border-gray-400 p-2">
                                            @if ($loop->last)
                                            @php
                                                $totalHour = $totalTime / 60 ;
                                            @endphp
                                                {{number_format($totalHour,2)}}
                                            
                                            @endif
                                        </td>
                                       
                                    </tr>
                                   
                                @endforeach
                              
                            @endforeach
                            <tr>
                                <td class="border border-gray-400 p-2" colspan="3">Total</td>
                                <td class="border border-gray-400 p-2">{{number_format($totalTug)}}</td>
                                <td class="border border-gray-400 p-2" colspan="6"></td>
                                <td class="border border-gray-400 p-2">{{$totalMinute}}</td>
                                <td class="border border-gray-400 p-2">
                                    @php
                                        $hour = $totalMinute / 60 ;
                                    @endphp
                                    {{number_format($hour,2)}}
                                </td>
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

@endsection

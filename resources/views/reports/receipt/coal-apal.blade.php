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
                    <div class="w-full mb-4">
                        <label for="start_year">Tahun</label>
                        <select name="year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option value="">Tahun</option>
                            @for ($i = date('Y'); $i >= 2000; $i--)
                                <option {{request()->year == $i || $i == date('Y') ? 'selected' :''}}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="w-full flex justify-end gap-4">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button type="button" class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="ExportToExcel('xlsx')">Download</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                        <a href="{{route('reports.receipt.index')}}" class="bg-pink-900 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
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
                            <p>Realisasi Pengapalan Batubara</p>
                            <p>Di Dermaga PLTU SURALAYA</p> 
                            <p>Tahun {{request()->year}}</p> 
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-max" id="table">
                            <thead>
                                <tr>
                                    <th class="border border-slate-900 p-2" rowspan="3">No</th>
                                    <th class="border border-slate-900 p-2" rowspan="3">Bulan</th>
                                    <th class="border border-slate-900 p-2" colspan="{{$docks->count() * 2 }}">Realisasi Pembongkaran Di Dermaga Dan Realisasi Penerimaan Batubara Tahun {{request()->year}}</th>
                                    <th class="border border-slate-900 p-2" rowspan="3">Total Kapal Tongkang</th>
                                    <th class="border border-slate-900 p-2" rowspan="3">Total Terima ( Kg )</th>
                                </tr>
                                <tr>
                                    @foreach ($docks as $dock)
                                    <th class="border border-slate-900 p-2" colspan="2">Dermaga {{$dock->name}}</th>        
                                    @endforeach
                                   
                                </tr>
                                <tr>
                                    @foreach ($docks as $dock)
                                        <th class="border border-slate-900 p-2">Jumlah Kapal / Tongkang</th>
                                        <th class="border border-slate-900 p-2">Jumlah Terima ( Kg )</th>      
                                        @endforeach
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalShip = 0;
                                        $totalTug = 0;
                                    @endphp
                                @foreach ($coals as $coal)
                                    <tr>
                                        <td class="border border-slate-900 p-2">{{$loop->iteration}}</td>
                                        <td class="border border-slate-900 p-2"> {{ Carbon\Carbon::create()->day(1)->month($loop->iteration)->format('M') }}</td> 
                                        @foreach ($docks as $item)
                                            @if (!empty($coal))
                                                @php
                                             
                                                // Count the number of ships with the given dock_id
                                                $shipCount = $coal->where('dock_id', $item->id)
                                                                    ->count('ship_id');
                                                $totalCount = $coal->where('dock_id', $item->id)->sum('tug_3_accept');
                                                $totalShip = $totalShip + $shipCount;
                                                $totalTug = $totalTug + $totalCount;
                                                @endphp
                                                <td class="border border-slate-900 p-2 text-right">{{ $shipCount }}</td>
                                                <td class="border border-slate-900 p-2 text-right">{{number_format($totalCount)}}</td> 
                                            @else
                                                <td class="border border-slate-900 p-2 text-right">0</td>
                                                <td class="border border-slate-900 p-2 text-right">0</td> 
                                            @endif
                                            
                                        @endforeach
                                        <td class="border border-slate-900 p-2 text-right">{{isset($coal) ? $coal->count('ship_id') : 0}}</td>
                                        <td class="border border-slate-900 p-2 text-right">{{isset($coal) ? number_format($coal->sum('tug_3_accept')) : 0}}</td> 
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="border border-slate-900 p-2"></td> 
                                    <td class="border border-slate-900 p-2"></td> 
                                    @foreach ($docks as $item)
                                    @php
                                        $totalShipsPerDock = $getCoals->where('dock_id',$item->id)->count('ship_id');
                                        $totalTugPerDock = $getCoals->where('dock_id',$item->id)->sum('tug_3_accept');
                                    @endphp
                                    <td class="border border-slate-900 p-2 font-bold text-right">{{ $totalShipsPerDock}}</td> <!-- Total kapal per dock -->
                                    <td class="border border-slate-900 p-2 font-bold text-right">{{ number_format($totalTugPerDock) }}</td> <!-- Total jumlah per dock -->
                                    @endforeach
                                    <td class="border border-slate-900 p-2 font-bold text-right">{{number_format($totalShip)}}</td> 
                                    <td class="border border-slate-900 p-2 font-bold text-right">{{number_format($totalTug)}}</td> 
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

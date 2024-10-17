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
                        <select name="dock_id" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md dock-select" required>
                            <option value="0">Semua Dermaga</option>
                            @foreach ($docks as $dock)
                                <option value="{{$dock->id}}" {{request('dock_id') == $dock->id ? 'selected' : ''}}> {{$dock->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="ship_id" id="ship_id" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md ship-select" required>
                            <option value="0">Semua Kapal</option>
                            @foreach ($ships as $ship)
                                <option value="{{$ship->id}}" {{request('ship_id') == $ship->id ? 'selected' : ''}}> {{$ship->name}}</option>
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
            {{-- @isset($loading) --}}

            <div id="my-pdf">

                <div class="bg-white rounded-lg p-6 body">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <img src="{{asset('logo.png')}}" alt="" width="200">
                            <p class="text-right">UBP SURALAYA</p>
                        </div>
                        <div class="text-center text-[20px] font-bold">
                            <p>Laporan Kegiatan Operasional DUKS</p>
                            <p>Bulan {{date('F Y', strtotime(request('date')))}} di Dermaga ( {{$dermaga->name ?? 'Semua '}} )</p> 
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-max" id="table">
                            <thead>
                                <tr>
                                    <th class="border border-gray-400 p-2" rowspan="2">No</th>
                                    <th class="border border-gray-400 p-2" rowspan="2">Nama Kapal</th>
                                    <th class="border border-gray-400 p-2" rowspan="2">Nama Nahkoda</th>
                                    <th class="border border-gray-400 p-2" rowspan="2">Bendera</th>
                                    <th class="border border-gray-400 p-2" colspan="3">Ukuran Kapal</th>
                                    <th class="border border-gray-400 p-2" colspan="2">Waktu Sandar</th>
                                    <th class="border border-gray-400 p-2" rowspan="2">Asal Pelabuhan</th>
                                    <th class="border border-gray-400 p-2" colspan="2">Bongkar</th>
                                </tr>
                                <tr>
                                    <th class="border border-gray-400 p-2">DWT</th>
                                    <th class="border border-gray-400 p-2">GRT</th>
                                    <th class="border border-gray-400 p-2">Panjang</th>
                                    <th class="border border-gray-400 p-2">Tanggal</th>
                                    <th class="border border-gray-400 p-2">Jam</th>
                                    <th class="border border-gray-400 p-2">Kg</th>
                                    <th class="border border-gray-400 p-2">Jenis</th>

                                </tr>
                            </thead>
                        <tbody>
                            @foreach ($coals as $coal)
                                <tr>
                                    <td class="border border-gray-400 p-2">{{$loop->iteration}}</td>
                                    <td class="border border-gray-400 p-2">{{$coal->ship->name}}</td>
                                    <td class="border border-gray-400 p-2">{{$coal->captain}}</td>
                                    <td class="border border-gray-400 p-2">{{$coal->ship->flag}}</td>
                                    <td class="border border-gray-400 p-2">{{$coal->ship->dwt}}</td>
                                    <td class="border border-gray-400 p-2">{{$coal->ship->grt}}</td>
                                    <td class="border border-gray-400 p-2">{{$coal->ship->loa}}</td>
                                    <td class="border border-gray-400 p-2">{{date('d-m-Y', strtotime($coal->dock_ship_date))}}</td>
                                    <td class="border border-gray-400 p-2">{{date('H:i:s', strtotime($coal->dock_ship_date))}}</td>
                                    <td class="border border-gray-400 p-2">{{$coal->originHarbor->name ?? ''}}</td>
                                    <td class="border border-gray-400 p-2">{{number_format($coal->tug_3_accept)}}</td>
                                    <td class="border border-gray-400 p-2">Batu Bara</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                        </div>
                    </div>
                </div>
            </div>
            {{-- @endisset --}}
    </div>
</div>
@endsection
@section('scripts')

@endsection

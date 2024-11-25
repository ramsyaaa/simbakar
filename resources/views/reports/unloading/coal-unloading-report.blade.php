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
                        Realisasi Pembongkaran Batu Bara
                    </div>
                    {{-- <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Analisa</span>
                    </div> --}}
                </div>
            </div>
            <div class="w-full flex justify-center mb-6">
                <form method="get" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                    @csrf
                    <div class="flex gap-4 items-center mb-4">
                        <label for="filter_type">Filter:</label>
                        <select class="w-full border h-[40px] rounded-lg" id="filter_type" name="filter_type">
                            <option value="month" {{ $filter_type == 'month' ? 'selected' : '' }}>Bulan</option>
                            <option value="dock" {{ $filter_type == 'dock' ? 'selected' : '' }}>Dermaga</option>
                            <option value="ship" {{ $filter_type == 'ship' ? 'selected' : '' }}>Kapal</option>
                        </select>
                    </div>

                    <div id="month-fields" class="filter-field mb-6" style="display: none;">
                        
                    </div>

                    <div id="dock-fields" class="filter-field w-full" style="display: none;">
                        <div class="mb-4">
                            <select name="dock_id" id="" class="select-2 w-full h-[44px] border rounded-md" style="width: 100%">
                                @foreach ($docks as $dock)
                                    <option value="{{$dock->id}}" {{request('dock_id') == $dock->id ? 'selected' : ''}}> {{$dock->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <select name="type_id" id="" class="select-2 w-full h-[44px] border rounded-md type-select" style="width: 100%">
                                <option value="0">Semua Jenis Kapal</option>
                                @foreach ($types as $type)
                                    <option value="{{$type->id}}" {{request('type_id') == $type->id ? 'selected' : ''}}> {{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="ship-fields" class="filter-field" style="display: none;">
                        <div class="mb-4">
                            <select name="ship_id" id="" class="select-2 w-full h-[44px] text-[#8A92A6] border rounded-md dock-select" style="width: 100%">
                                @foreach ($ships as $ship)
                                    <option value="{{$ship->id}}" {{request('ship_id') == $ship->id ? 'selected' : ''}}> {{$ship->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="month" id="date" name="date" class="border h-[40px] w-full rounded-lg px-3" value="{{ request('date') ?? '' }}">

                    <div class="w-full flex justify-end mt-3 gap-3">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button type="button" class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="ExportToExcel('xlsx')">Download</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                        <a href="{{route('reports.unloading.index')}}" class="bg-pink-900 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
                    </div>
                </form>
            </div>

            @isset($coals)

                <div id="my-pdf">
                    <div class="body bg-white rounded-lg p-6">

                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <img src="{{asset('logo.png')}}" alt="" width="200">
                            <p class="text-right">UBP SURALAYA</p>
                        </div>
                        <div class="text-center text-[20px] font-bold">
                            @if (request('filter_type') == 'month')
                            <p>Realisasi Pembongkaran Batubara</p>
                            <p>Bulan {{date('F Y', strtotime(request('date')))}}</p> 
                            @endif
                            @if (request('filter_type') == 'dock')
                            <p>Realisasi Pembongkaran Batubara</p>
                            <p>Bulan {{date('F Y', strtotime(request('date')))}} di Dermaga ( {{$dermaga->name ?? 'Semua '}} )</p> 
                            @endif
                            @if (request('filter_type') == 'ship')
                            <p>Realisasi Pembongkaran Batubara</p>
                            <p>Bulan {{date('F Y', strtotime(request('date')))}} di Kapal ( {{$kapal->name ?? 'Semua '}} )</p> 
                            @endif
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-auto max-w-full">
                        <table class="min-w-max" id="table">
                            <thead>
                                <tr>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">No</th>
                                    @if (request()->filter_type != 'ship')
                                        <th class="border border-gray-400 text-white bg-[#047A96] p-2">Kapal</th>    
                                    @endif
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">Pemasok</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">Agen</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">Tiba</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">Sandar</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">Mulai Bongkar</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">Selesai Bongkar</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">Berangkat</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">Pemakaian Listrik ( KWH )</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">B/L ( Kg )</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">D/S ( Kg )</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">B/W ( Kg )</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">TUG 3 ( Kg )</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">Dermaga</th>
                                    <th class="border border-gray-400 text-white bg-[#047A96] p-2">GRT Kapal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coals as $coal)
                                <tr>
                                    <td class="border border-gray-400 p-2">{{$loop->iteration}}</td>
                                    @if (request()->filter_type != 'ship')   
                                        <td class="border border-gray-400 p-2">{{$coal->ship->name ?? ''}}</td>
                                    @endif
                                    <td class="border border-gray-400 p-2">{{$coal->supplier->name ?? ''}}</td>
                                    <td class="border border-gray-400 p-2">{{$coal->agent->name ?? ''}}</td>
                                    <td class="border border-gray-400 p-2">{{date('d-m-Y H:i:s', strtotime($coal->arrived_date))}}</td>
                                    <td class="border border-gray-400 p-2">{{date('d-m-Y H:i:s', strtotime($coal->dock_ship_date))}}</td>
                                    <td class="border border-gray-400 p-2">{{date('d-m-Y H:i:s', strtotime($coal->unloading_date))}}</td>
                                    <td class="border border-gray-400 p-2">{{date('d-m-Y H:i:s', strtotime($coal->end_date))}}</td>
                                    <td class="border border-gray-400 p-2">{{date('d-m-Y H:i:s', strtotime($coal->departure_date))}}</td>
                                    <td class="border border-gray-400 p-2 text-right">0</td>
                                    <td class="border border-gray-400 p-2 text-right">{{number_format($coal->bl)}}</td>
                                    <td class="border border-gray-400 p-2 text-right">{{number_format($coal->ds)}}</td>
                                    <td class="border border-gray-400 p-2 text-right">{{number_format($coal->bw)}}</td>
                                    <td class="border border-gray-400 p-2 text-right">{{number_format($coal->tug_3_accept)}}</td>
                                    <td class="border border-gray-400 p-2">{{$coal->dock->name ?? ''}}</td>
                                    <td class="border border-gray-400 p-2">{{$coal->ship->grt ?? ''}}</td>
                              
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="border border-gray-400 p-2 text-center" colspan="10">Total</td>
                                    <td class="border border-gray-400 p-2 text-right"> {{number_format($coals->sum('bl'))}}</td>
                                    <td class="border border-gray-400 p-2 text-right"> {{number_format($coals->sum('ds'))}}</td>
                                    <td class="border border-gray-400 p-2 text-right"> {{number_format($coals->sum('bw'))}}</td>
                                    <td class="border border-gray-400 p-2 text-right"> {{number_format($coals->sum('tug_3_accept'))}}</td>
                                    <td class="border border-gray-400 p-2"></td>
                                    <td class="border border-gray-400 p-2"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endisset

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterTypeSelect = document.getElementById('filter_type');
        const dockFields = document.getElementById('dock-fields');
        const monthFields = document.getElementById('month-fields');
        const shipFields = document.getElementById('ship-fields');

        function updateFields() {
            const filterType = filterTypeSelect.value;

            // Sembunyikan semua input terlebih dahulu
            dockFields.style.display = 'none';
            monthFields.style.display = 'none';
            shipFields.style.display = 'none';

            // Tampilkan input yang sesuai dengan filter_type
            if (filterType === 'dock') {
                dockFields.style.display = 'block';
            } else if (filterType === 'month') {
                monthFields.style.display = 'block';
            } else if (filterType === 'ship') {
                shipFields.style.display = 'block';
            }
        }

        // Inisialisasi tampilan berdasarkan nilai saat ini
        updateFields();

        // Perbarui tampilan saat filter_type berubah
        filterTypeSelect.addEventListener('change', updateFields);
    });
</script>

@endsection

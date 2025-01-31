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
                        Perbandingan Penerimaan Batubara (B/L , D/S , B/W , TUG3)
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
                            <option value="day" {{ $filter_type == 'day' ? 'selected' : '' }}>Hari</option>
                            <option value="month" {{ $filter_type == 'month' ? 'selected' : '' }}>Bulan</option>
                            <option value="year" {{ $filter_type == 'year' ? 'selected' : '' }}>Tahun</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="dock_id" id="" class="select-2 w-full h-[44px] border rounded-md" style="width: 100%">
                            <option value="0">Semua Dermaga</option>
                            @foreach ($docks as $dock)
                                <option value="{{$dock->id}}" {{request('dock_id') == $dock->id ? 'selected' : ''}}> {{$dock->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="ship_id" id="" class="select-2 w-full h-[44px] border rounded-md type-select" style="width: 100%">
                            <option value="0">Semua Kapal</option>
                            @foreach ($ships as $ship)
                                <option value="{{$ship->id}}" {{request('ship_id') == $ship->id ? 'selected' : ''}}> {{$ship->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="day-fields" class="filter-field mb-6" style="display: none;">
                        <input type="month" id="bulan_tahun" name="bulan_tahun" class="border h-[40px] w-full rounded-lg px-3" value="{{ request('bulan_tahun') ?? '' }}">
                    </div>

                    <div id="month-fields" class="filter-field" style="display: none;">
                        <select name="tahun" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option value="">Tahun</option>
                            @for ($i = date('Y'); $i >= 2000; $i--)
                                <option {{request()->tahun == $i ? 'selected' :''}}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div id="year-fields" class="filter-field" style="display: none;">
                        <div class="w-full mb-4">
                            <label for="start_year">Tahun Awal:</label>
                            <select name="start_year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option {{request()->start_year == $i || $i == 2021 ? 'selected' :''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="w-full mb-4">
                            <label for="end_year">Tahun Akhir:</label>
                            <select name="end_year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option {{request()->end_year == $i || $i == date('Y') ? 'selected' :''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="w-full flex justify-end mt-3 gap-3">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button type="button" class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="ExportToExcel('xlsx')">Download</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                        <a href="{{route('reports.receipt.index')}}" class="bg-pink-900 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
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
                            <p>Perbandingan Jumlah Penerimaan Batubara</p>
                            <p>{{$kapal->name ?? 'Semua Kapal'}} / {{$dermaga->name ?? 'Semua Dermaga'}}</p>
                            @if (request('filter_type') == 'day')
                            <p>Bulan {{date('F Y', strtotime(request('bulan_tahun')))}}</p> 
                            @endif
                            @if (request('filter_type') == 'month')
                            <p>Tahun {{request('tahun')}}</p>  
                            @endif
                            @if (request('filter_type') == 'year')
                            <p>Dari Tahun {{request('start_year')}} Ke {{request('end_year')}}</p>
                            @endif
                            
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-auto max-w-full">
                        <table class="min-w-max" id="table">
                            @if (request('filter_type') == 'day')
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">No</th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">Nama Kapal</th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">Pemasok</th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">Tanggal Selesai Bongkar</th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">B/L (Kg)</th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">D/S (Kg)</th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">B/W (Kg)</th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">Diterima (TUG3) (Kg)</th>
                                        <th colspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">D/S & B/L</th>
                                        <th colspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">D/S & B/W</th>
                                    </tr>
                                    <tr>
                                        <th class="border border-gray-400 text-white bg-[#047A96] p-2">Selisih</th>
                                        <th class="border border-gray-400 text-white bg-[#047A96] p-2">%Selisih</th>
                                        <th class="border border-gray-400 text-white bg-[#047A96] p-2">Selisih</th>
                                        <th class="border border-gray-400 text-white bg-[#047A96] p-2">%Selisih</th>
        
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($coals as $coal)
                                    <tr>
                                        <td class="border border-gray-400 p-2">{{$loop->iteration}}</td>
                                        <td class="border border-gray-400 p-2">{{$coal->ship->name ?? ''}}</td>
                                        <td class="border border-gray-400 p-2">{{$coal->supplier->name ?? ''}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{date('d-m-Y', strtotime($coal->end_date))}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->bl)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->ds)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">0</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->tug_3_accept)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->selisih_bl)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->selisih_bl_percentage,2)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->selisih_bw)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->selisih_bw_percentage,2)}}</td>
                                        
                                    </tr>
                                    @endforeach
                                    @php
                                        $total= collect($coals);
                                    @endphp
                                    <tr>
                                        <td colspan="4" class="border border-gray-400 font-bold p-2">Jumlah</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">{{number_format($total->sum('bl'))}}</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">{{number_format($total->sum('ds'))}}</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">0</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">{{number_format($total->sum('tug_3_accept'))}}</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">{{number_format($total->sum('selisih_bl'))}}</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">-</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">{{number_format($total->sum('selisih_bw'))}}</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">-</td>
                                    </tr>
                                </tbody>
                            @else
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">No</th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">
                                            @if (request('filter_type') == 'month')
                                             Bulan
                                            @else
                                            Tahun   
                                            @endif
                                        </th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">B/L (Kg)</th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">D/S (Kg)</th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">B/W (Kg)</th>
                                        <th rowspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">Diterima (TUG3) (Kg)</th>
                                        <th colspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">D/S & B/L</th>
                                        <th colspan="2" class="border border-gray-400 text-white bg-[#047A96] p-2">D/S & B/W</th>
                                    </tr>
                                    <tr>
                                        <th class="border border-gray-400 text-white bg-[#047A96] p-2">Selisih</th>
                                        <th class="border border-gray-400 text-white bg-[#047A96] p-2">%Selisih</th>
                                        <th class="border border-gray-400 text-white bg-[#047A96] p-2">Selisih</th>
                                        <th class="border border-gray-400 text-white bg-[#047A96] p-2">%Selisih</th>
        
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($coals as $coal)
                                    <tr>
                                        <td class="border border-gray-400 p-2">{{$loop->iteration}}</td>
                                        <td class="border border-gray-400 p-2">{{$coal->label}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->bl)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->ds)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">0</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->tug_3_accept)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->selisih_bl)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->selisih_bl_percentage,2)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->selisih_bw)}}</td>
                                        <td class="border border-gray-400 p-2 text-right">{{number_format($coal->selisih_bw_percentage,2)}}</td>
                                        
                                    </tr>
                                    @endforeach
                                    @php
                                        $total= collect($coals);
                                    @endphp
                                    <tr>
                                        <td colspan="2" class="border border-gray-400 font-bold p-2 text-right">Jumlah</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">{{number_format($total->sum('bl'))}}</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">{{number_format($total->sum('ds'))}}</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">0</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">{{number_format($total->sum('tug_3_accept'))}}</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">{{number_format($total->sum('selisih_bl'))}}</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">-</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">{{number_format($total->sum('selisih_bw'))}}</td>
                                        <td class="border border-gray-400 font-bold p-2 text-right">-</td>
                                    </tr>
                                
                                </tbody>
                            @endif
                            
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
        const dayFields = document.getElementById('day-fields');
        const monthFields = document.getElementById('month-fields');
        const yearFields = document.getElementById('year-fields');

        function updateFields() {
            const filterType = filterTypeSelect.value;

            // Sembunyikan semua input terlebih dahulu
            dayFields.style.display = 'none';
            monthFields.style.display = 'none';
            yearFields.style.display = 'none';

            // Tampilkan input yang sesuai dengan filter_type
            if (filterType === 'day') {
                dayFields.style.display = 'block';
            } else if (filterType === 'month') {
                monthFields.style.display = 'block';
            } else if (filterType === 'year') {
                yearFields.style.display = 'block';
            }
        }

        // Inisialisasi tampilan berdasarkan nilai saat ini
        updateFields();

        // Perbarui tampilan saat filter_type berubah
        filterTypeSelect.addEventListener('change', updateFields);
    });
</script>

@endsection

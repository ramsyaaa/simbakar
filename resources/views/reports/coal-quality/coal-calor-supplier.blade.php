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
                        Nilai Kalor & Moisture Batu Bara Per Pemasok
                    </div>
                    {{-- <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Analisa</span>
                    </div> --}}
                </div>
            </div>
            <div class="w-full flex justify-center mb-6">
                <form method="GET" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
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
                        <select name="supplier_id" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md supplier-select">
                            <option selected disabled>Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{request('supplier_id') == $supplier->id ? 'selected' : ''}}> {{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="day-fields" class="filter-field mb-6" style="display: none;">
                        <input type="month" id="bulan_tahun" name="bulan_tahun" class="border h-[40px] w-full rounded-lg px-3" value="{{ request('bulan_tahun', date($tahun . '-' . $bulan)) }}">
                    </div>

                    <div id="month-fields" class="filter-field" style="display: none;">
                        <input type="number" id="tahun" name="tahun" class="border h-[40px] w-full rounded-lg px-3" value="{{ request('tahun', $tahunInput) }}" min="1980" max="2200">
                    </div>

                    <div id="year-fields" class="filter-field" style="display: none;">
                        <div class="w-full mb-4">
                            <label for="start_year">Tahun Awal:</label>
                            <input type="number" id="start_year" class="border h-[40px] w-full rounded-lg px-3" name="start_year" value="{{ request('start_year', $start_year) }}" min="2000" max="2100">
                        </div>

                        <div class="w-full mb-4">
                            <label for="end_year">Tahun Akhir:</label>
                            <input type="number" id="end_year" name="end_year" class="border h-[40px] w-full rounded-lg px-3" value="{{ request('end_year', $end_year) }}" min="2000" max="2100">
                        </div>
                    </div>
                    <div class="flex gap-4 w-full mb-4">
                        @if(!empty($analytic))
                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasidata-awal-tahun" name="analytic[]" value="unloading" {{ in_array('unloading', $analytic) ? 'checked' :''  }}>
                                <label class="form-check-label" for="inisiasidata-awal-tahun">
                                Unloading
                                </label>
                            </div>
                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasipenerimaan-batu-bara" name="analytic[]" value="loading" {{ in_array('loading', $analytic) ? 'checked' :''  }}>
                                <label class="form-check-label" for="inisiasipenerimaan-batu-bara">
                                Loading
                                </label>
                            </div>
                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasipemakaian" name="analytic[]" value="labor" {{ in_array('labor', $analytic) ? 'checked' :''  }}>
                                <label class="form-check-label" for="inisiasipemakaian">
                                Labor
                                </label>
                            </div>
                        @else
                            
                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasidata-awal-tahun" name="analytic[]" value="unloading" checked>
                                <label class="form-check-label" for="inisiasidata-awal-tahun">
                                Unloading
                                </label>
                            </div>
                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasipenerimaan-batu-bara" name="analytic[]" value="loading" checked>
                                <label class="form-check-label" for="inisiasipenerimaan-batu-bara">
                                Loading
                                </label>
                            </div>
                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasipemakaian" name="analytic[]" value="labor" checked>
                                <label class="form-check-label" for="inisiasipemakaian">
                                Labor
                                </label>
                            </div>
                        @endisset
                        
                    </div>
                    <div class="w-full flex justify-end gap-3">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
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
                           <p>Nilai Kalor & Moisture Batu Bara {{$pemasok->name ?? ''}}
                            <br>
                            @if ($filter_type == 'day')
                               Bulan {{$bulan }} - {{$tahunInput}}
                           @endif
                            @if ($filter_type == 'month')
                               Tahun - {{$tahunInput}}
                           @endif
                            @if ($filter_type == 'year')
                               Tahun {{$start_year }} s/d {{$end_year}}
                           @endif
                        </p>
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-auto hide-scrollbar max-w-full">
                        <table class="w-full">
                            @if ($filter_type == 'day')
                                    <thead>
                                        <tr>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">No</th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Kapal</th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Tanggal Bongkar</th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Terima ( TUG 3 ) ( Kg )</th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="{{count($analytic)}}">Nilai Kalor ( Ar )</th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="{{count($analytic)}}">Kadar Total Moisture ( Ar )</th>
                                        </tr>
                                        <tr>
                                            @foreach ($analytic as $item)
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6] capitalize">{{$item}}</th> 
                                            @endforeach
                                            @foreach ($analytic as $item)
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6] capitalize">{{$item}}</th> 
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coals as $coal)
                                        <tr>

                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$loop->iteration}}</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->ship->name}}</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->unloading_date}}</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{number_format($coal->tug_3_accept)}}</td>
                                            @if (in_array('unloading',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->unloading->calorivic_value}}</td>
                                            @endif
                                            @if (in_array('loading',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->loading->calorivic_value}}</td>
                                            @endif
                                            @if (in_array('labor',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->labor->calorivic_value}}</td>
                                            @endif
                                            @if (in_array('unloading',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->unloading->moisture_total}}</td>
                                            @endif
                                            @if (in_array('loading',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->loading->moisture_total}}</td>
                                            @endif
                                            @if (in_array('labor',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->labor->moisture_total}}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="h-[36px] text-[16px] font-normal border px-2" colspan="2"></td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">Total</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{number_format($coals->sum('tug_3_accept'))}}</td>
                                            @if (in_array('unloading',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{$coals->pluck('unloading.calorivic_value')->avg()}}</td>

                                            @endif
                                            @if (in_array('loading',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{$coals->pluck('loading.calorivic_value')->avg()}}</td>

                                            @endif
                                            @if (in_array('labor',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{$coals->pluck('labor.calorivic_value')->avg()}}</td>

                                            @endif
                                            @if (in_array('unloading',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{$coals->pluck('unloading.moisture_total')->avg()}}</td>

                                            @endif
                                            @if (in_array('loading',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{$coals->pluck('loading.moisture_total')->avg()}}</td>

                                            @endif
                                            @if (in_array('labor',$analytic))
                                             <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{$coals->pluck('labor.moisture_total')->avg()}}</td>

                                            @endif
                                        </tr>                                        
                                    </tbody>
                            @else
                                    <thead>
                                        <tr>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Tanggal</th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Terima ( TUG 3 ) ( Kg )</th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="{{count($analytic)}}">Nilai Kalor ( Ar )</th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="{{count($analytic)}}">Kadar Total Moisture ( Ar )</th>
                                        </tr>
                                        <tr>
                                            @foreach ($analytic as $item)
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6] capitalize">{{$item}}</th> 
                                            @endforeach
                                            @foreach ($analytic as $item)
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6] capitalize">{{$item}}</th> 
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                            
                                    <tbody>
                                        @php
                                            $coalsCollection = collect($coals);
                                        @endphp
                                    
                                        @foreach ($coals as $coal)
                                        <tr>

                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal['month']}}</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{number_format($coal['tug_3_accept'])}}</td>
                                            @if (in_array('unloading',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal['unloading_calor']}}</td>
                                            @endif
                                            @if (in_array('loading',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal['loading_calor']}}</td>
                                            @endif
                                            @if (in_array('labor',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal['labor_calor']}}</td>
                                            @endif
                                            @if (in_array('unloading',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal['unloading_moisture']}}</td>
                                            @endif
                                            @if (in_array('loading',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal['loading_moisture']}}</td>
                                            @endif
                                            @if (in_array('labor',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal['labor_moisture']}}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        <tr>
                                            {{-- <td class="h-[36px] text-[16px] font-normal border px-2" colspan="1"></td> --}}
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">Total</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->sum('tug_3_accept')) }}</td>
                                            
                                            @if (in_array('unloading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->avg('unloading_calor'),2) }}</td>
                                            @endif
                                            
                                            @if (in_array('loading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->avg('loading_calor'),2) }}</td>
                                            @endif
                                            
                                            @if (in_array('labor', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->avg('labor_calor'),2) }}</td>
                                            @endif
                                            
                                            @if (in_array('unloading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->avg('unloading_moisture'),2) }}</td>
                                            @endif
                                            
                                            @if (in_array('loading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->avg('loading_moisture'),2) }}</td>
                                            @endif
                                            
                                            @if (in_array('labor', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->avg('labor_moisture'),2) }}</td>
                                            @endif
                                        </tr>
                                    </tbody>
                                @endif     
                            </table>
                        </div>
                    </div>
                </div>
            </div>
         @endisset
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

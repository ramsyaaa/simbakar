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
                        Nilai Kalor & Moisture Batu Bara
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

                    <div id="day-fields" class="filter-field mb-6" style="display: none;">
                        <input type="month" id="bulan_tahun" name="bulan_tahun" class="border h-[40px] w-full rounded-lg px-3" value="{{ request('bulan_tahun', date($tahun . '-' . $bulan)) }}">
                    </div>

                    <div id="month-fields" class="filter-field" style="display: none;">
                        <select name="tahun" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option value="">Tahun</option>
                            @for ($i = date('Y'); $i >= 2000; $i--)
                                <option {{request()->year == $i ? 'selected' :''}}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div id="year-fields" class="filter-field" style="display: none;">
                        <div class="w-full mb-4">
                            <label for="start_year">Tahun Awal:</label>
                            <select name="start_year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option {{request()->start_year == $i ? 'selected' :''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="w-full mb-4">
                            <label for="end_year">Tahun Akhir:</label>
                            <select name="end_year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option {{request()->end_year == $i ? 'selected' :''}}>{{ $i }}</option>
                                @endfor
                            </select>
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
                           <p>Nilai Kalor & Moisture Batu Bara
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
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-max" id="table">
                            @if ($filter_type == 'day')
                                    <thead>
                                        <tr>
                                            <th class="border text-white bg-[#047A96] h-[52px]" rowspan="2">No</th>
                                            <th class="border text-white bg-[#047A96] h-[52px]" rowspan="2">Kapal</th>
                                            <th class="border text-white bg-[#047A96] h-[52px]" rowspan="2">Pemasok</th>
                                            <th class="border text-white bg-[#047A96] h-[52px]" rowspan="2">Tanggal Bongkar</th>
                                            <th class="border text-white bg-[#047A96] h-[52px]" rowspan="2">Terima ( TUG 3 ) ( Kg )</th>
                                            <th class="border text-white bg-[#047A96] h-[52px]" colspan="{{count($analytic)}}">Nilai Kalor ( Ar )</th>
                                            <th class="border text-white bg-[#047A96] h-[52px]" colspan="{{count($analytic)}}">Kadar Total Moisture ( Ar )</th>
                                        </tr>
                                        <tr>
                                            @foreach ($analytic as $item)
                                                <th class="border text-white bg-[#047A96] h-[52px] capitalize">{{$item}}</th>
                                            @endforeach
                                            @foreach ($analytic as $item)
                                                <th class="border text-white bg-[#047A96] h-[52px] capitalize">{{$item}}</th>
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coals as $coal)
                                        <tr>

                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$loop->iteration}}</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->ship->name}}</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->supplier->name}}</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{ date('d-m-Y H:i:s', strtotime($coal->unloading_date))}}</td>
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
                                            <td class="h-[36px] text-[16px] font-normal border px-2" colspan="3"></td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">Total</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{number_format($coals->sum('tug_3_accept'))}}</td>
                                            @if (in_array('unloading',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{round($coals->pluck('unloading.calorivic_value')->avg())}}</td>

                                            @endif
                                            @if (in_array('loading',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{round($coals->pluck('loading.calorivic_value')->avg())}}</td>

                                            @endif
                                            @if (in_array('labor',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{round($coals->pluck('labor.calorivic_value')->avg())}}</td>

                                            @endif
                                            @if (in_array('unloading',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{number_format($coals->pluck('unloading.moisture_total')->avg(),2)}}</td>

                                            @endif
                                            @if (in_array('loading',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{number_format($coals->pluck('loading.moisture_total')->avg(),2)}}</td>

                                            @endif
                                            @if (in_array('labor',$analytic))
                                             <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" >{{number_format($coals->pluck('labor.moisture_total')->avg(),2)}}</td>

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
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{(int) $coal['unloading_calor']}}</td>
                                            @endif
                                            @if (in_array('loading',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{ (int) $coal['loading_calor']}}</td>
                                            @endif
                                            @if (in_array('labor',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{(int) $coal['labor_calor']}}</td>
                                            @endif
                                            @if (in_array('unloading',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format( $coal['unloading_moisture'],2)}}</td>
                                            @endif
                                            @if (in_array('loading',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format( $coal['loading_moisture'],2)}}</td>
                                            @endif
                                            @if (in_array('labor',$analytic))
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format( $coal['labor_moisture'],2)}}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        <tr>
                                            {{-- <td class="h-[36px] text-[16px] font-normal border px-2" colspan="1"></td> --}}
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">Total</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->sum('tug_3_accept')) }}</td>
                                            {{-- nilai kalor --}}
                                           @if (in_array('unloading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">
                                                    {{ (int)$coalsCollection->where('unloading_calor', '>', 0)->avg('unloading_calor') }}
                                                </td>
                                            @endif

                                            @if (in_array('loading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">
                                                    {{ (int)$coalsCollection->where('loading_calor', '>', 0)->avg('loading_calor') }}
                                                </td>
                                            @endif

                                            @if (in_array('labor', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">
                                                    {{ (int)$coalsCollection->where('labor_calor', '>', 0)->avg('labor_calor') }}
                                                </td>
                                            @endif

                                            {{-- total moisture --}}
                                            @if (in_array('unloading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">
                                                    {{ number_format($coalsCollection->where('unloading_moisture', '>', 0)->avg('unloading_moisture'), 2) }}
                                                </td>
                                            @endif

                                            @if (in_array('loading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">
                                                    {{ number_format($coalsCollection->where('loading_moisture', '>', 0)->avg('loading_moisture'), 2) }}
                                                </td>
                                            @endif

                                            @if (in_array('labor', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">
                                                    {{ number_format($coalsCollection->where('labor_moisture', '>', 0)->avg('labor_moisture'), 2) }}
                                                </td>
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

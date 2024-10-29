@extends('layouts.app')


@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="flex items-end justify-between mb-2">
                <div>

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
                            <option value="0">Semua Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{request('supplier_id') == $supplier->id ? 'selected' : ''}}> {{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="day-fields" class="filter-field mb-6" style="display: none;">
                        <input type="month" id="bulan_tahun" name="bulan_tahun" class="border h-[40px] w-full rounded-lg px-3" value="{{ request('bulan_tahun') }}">
                    </div>

                    <div id="month-fields" class="filter-field" style="display: none;">
                        <label for="start_year">Tahun</label>
                        <input type="number" id="tahun" name="tahun" class="border h-[40px] w-full rounded-lg px-3" value="{{ request('tahun') }}" min="1980" max="2200">
                    </div>

                    <div id="year-fields" class="filter-field" style="display: none;">
                        <div class="flex gap-3">
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
                    </div>
                    <div class="mb-4">
                        <select name="unit_id" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option selected disabled>Pilih Parameter</option>
                            @foreach ($units as $unit)
                                <option value="{{$unit->id}}" {{request('unit_id') == $unit->id ? 'selected' : ''}}> {{$unit->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="basis" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option selected disabled>Pilih Basis</option>
                            <option {{request('basis') == 'AR' ? 'selected' : ''}}>AR</option>
                            <option {{request('basis') == 'ADB' ? 'selected' : ''}}>ADB</option>
                        </select>
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
                        <a href="{{route('reports.executive-summary.index')}}" class="bg-pink-900 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
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
                            <p>Monitoring Perbandingan Analisa Kualitas Batu Bara <br> {{request('supplier_id') == 0 ? 'Semua Pemasok' :$pemasok->name}} <br>
                                @if (request('filter_type') == 'day')
                                {{request('bulan_tahun')}}
                                @endif
                                @if (request('filter_type') == 'month')
                                   Tahun {{request('tahun')}}
                                @endif
                                @if (request('filter_type') == 'year')
                                    {{request('start_year')}} s/d {{request('end_year')}}
                                @endif


                            </p>
                        </p>
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-auto hide-scrollbar max-w-full">
                        <table class="min-w-max" id="table">
                            @if ($filter_type == 'day')
                                    <thead>
                                        <tr>
                                            <th class="border bg-[#F5F6FA] h-[24px] text-[#8A92A6]" rowspan="2">Tanggal Bongkar</th>
                                            <th class="border bg-[#F5F6FA] h-[24px] text-[#8A92A6]" rowspan="2">Nama Kapal</th>
                                            <th class="border bg-[#F5F6FA] h-[24px] text-[#8A92A6]" rowspan="2">Nomor Kontrak</th>
                                            <th class="border bg-[#F5F6FA] h-[24px] text-[#8A92A6]" rowspan="2">Pemasok</th>
                                            <th class="border bg-[#F5F6FA] h-[24px] text-[#8A92A6]" rowspan="2">Terima ( TUG 3 ) ( Kg )</th>
                                            <th class="border bg-[#F5F6FA] h-[24px] text-[#8A92A6]" rowspan="2">Asal Barang</th>
                                            <th class="border bg-[#F5F6FA] h-[24px] text-[#8A92A6]" colspan="3"> {{$parameter->name}} ( {{request('basis')}} ) </th>
                                        </tr>
                                        <tr>
                                            @foreach ($analytic as $item)
                                                <th class="border bg-[#F5F6FA] h-[24px] text-[#8A92A6] capitalize">{{$item}}</th>
                                            @endforeach

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coals as $coal)
                                            <tr>

                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{date('d-m-Y H:i:s', strtotime($coal->unloading_date))}}</td>
                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->ship->name}}</td>
                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->contract->contract_number}}</td>
                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->supplier->name}}</td>
                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{number_format($coal->tug_3_accept)}}</td>
                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal->origin}}</td>
                                                @if (in_array('unloading',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{number_format($coal->unloading,2)}}</td>
                                                @endif
                                                @if (in_array('loading',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{number_format($coal->loading,2)}}</td>
                                                @endif
                                                @if (in_array('labor',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{number_format($coal->labor,2)}}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="5">Total</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="{{count($analytic) + 1}}">{{ number_format($coals->sum('tug_3_accept')) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan=6">Rata Rata Tertimbang</td>

                                            @if (in_array('unloading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->avg('unloading'),2) }}</td>
                                            @endif

                                            @if (in_array('loading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->avg('loading'),2) }}</td>
                                            @endif

                                            @if (in_array('labor', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->avg('labor'),2) }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="6">Hasil Analisa Tertinggi</td>

                                            @if (in_array('unloading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->max('unloading'),2) }}</td>
                                            @endif

                                            @if (in_array('loading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->max('loading'),2) }}</td>
                                            @endif

                                            @if (in_array('labor', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->max('labor'),2) }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="6">Hasil Analisa Terendah</td>

                                            @if (in_array('unloading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->min('unloading'),2) }}</td>
                                            @endif

                                            @if (in_array('loading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->min('loading'),2) }}</td>
                                            @endif

                                            @if (in_array('labor', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->min('labor'),2) }}</td>
                                            @endif
                                        </tr>
                                    </tbody>
                                @else
                                    <thead>
                                        <tr>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Tanggal</th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Terima ( TUG 3 ) ( Kg )</th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="{{count($analytic)}}"> {{$parameter->name}} ( {{request('basis')}} ) </th>
                                        </tr>
                                        <tr>
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
                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{number_format($coal['unloading'],2)}}</td>
                                                @endif
                                                @if (in_array('loading',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{number_format($coal['loading'],2)}}</td>
                                                @endif
                                                @if (in_array('labor',$analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2">{{number_format($coal['labor'],2)}}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">Total</td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="{{count($analytic) + 1}}">{{ number_format($coalsCollection->sum('tug_3_accept')) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="2">Rata Rata Tertimbang</td>

                                            @if (in_array('unloading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->avg('unloading'),2) }}</td>
                                            @endif

                                            @if (in_array('loading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->avg('loading'),2) }}</td>
                                            @endif

                                            @if (in_array('labor', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->avg('labor'),2) }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="2">Hasil Analisa Tertinggi</td>

                                            @if (in_array('unloading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->max('unloading'),2) }}</td>
                                            @endif

                                            @if (in_array('loading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->max('loading'),2) }}</td>
                                            @endif

                                            @if (in_array('labor', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->max('labor'),2) }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="2">Hasil Analisa Terendah</td>

                                            @if (in_array('unloading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->min('unloading'),2) }}</td>
                                            @endif

                                            @if (in_array('loading', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->min('loading'),2) }}</td>
                                            @endif

                                            @if (in_array('labor', $analytic))
                                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coalsCollection->min('labor'),2) }}</td>
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

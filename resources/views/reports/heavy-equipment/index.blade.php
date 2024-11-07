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
                        Laporan Pemakaian @if($type_bbm == 'solar')HSD @elseif($type_bbm == 'residu')MFO @endif @if($type == 'heavy_equipment') Albes @elseif ($type == "unit") Unit @elseif($type == 'other') Lainnya @endif
                    </div>
                    {{-- <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Analisa</span>
                    </div> --}}
                </div>
            </div>
            <div class="w-full flex justify-center mb-6">
                <form method="POST" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
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
                        <div class="w-full mb-2 lg:mb-0">
                            <select id="tahun" name="tahun" class="w-full mb-4 h-[44px] rounded-md border px-2" autofocus>
                                <option selected disabled>Pilih Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option {{request()->tahun == $i ? 'selected' :''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div id="year-fields" class="filter-field" style="display: none;">
                        <div class="w-full mb-4">
                            <div class="w-full mb-2 lg:mb-0">
                                <select id="start_year" name="start_year" class="w-full h-[44px] rounded-md border px-2" autofocus>
                                    <option selected disabled>Pilih Tahun Awal</option>
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option {{request()->start_year == $i || $i == 2021 ? 'selected' :''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="w-full mb-4">
                            <div class="w-full mb-2 lg:mb-0">
                                <select id="end_year" name="end_year" class="w-full h-[44px] rounded-md border px-2" autofocus>
                                    <option selected disabled>Pilih Tahun Akhir</option>
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option {{request()->end_year == $i || $i == date('Y') ? 'selected' :''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="w-full flex justify-end gap-4">
                        <button type="button" class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="ExportToExcel('xlsx')">Download</button>
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                    </div>
                </form>
            </div>

            @if($filter_type != null)
            <div class="bg-white rounded-lg p-6" id="my-pdf">
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
                                @foreach ($bbm_usage as $index => $item)
                                @php
                                    $total = count($item);
                                @endphp
                                @break
                                @endforeach
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Albes</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="{{ $total+1 }}">@if($filter_type == 'day')Tanggal @elseif($filter_type == 'month')Bulan @elseif($filter_type == 'year') Tahun @endif</th>
                            </tr>
                            <tr>
                                @php
                                    $i=1;
                                    $totalData = array_fill(0, $total, 0.0);
                                @endphp
                                @foreach ($bbm_usage as $index => $item)
                                @foreach ($item as $index1 => $item1)
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">@if($filter_type == 'day'){{ $i }} @elseif($filter_type == 'month'){{ date('M', mktime(0, 0, 0, $i, 10)) }} @elseif($filter_type == 'year') {{ $start_year+($i-1) }} @endif</th>
                                    @php
                                        $i  = $i + 1;
                                    @endphp
                                @endforeach
                                @break
                                @endforeach
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bbm_usage as $index => $item)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $index }}</td>
                                @foreach ($item as $index1 => $item1)
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format($item1, 0, '.', ',') }}</td>
                                @php
                                    if(isset($totalData[$index1])){
                                        $totalData[$index1] = $totalData[$index1] + $item1;
                                    }else{
                                        $totalData[$index1] =  $item1;
                                    }
                                @endphp
                                @endforeach
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format(array_sum($item), 0, '.', ',') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold">Jumlah</td>
                                @foreach ($totalData as $index1 => $item1)
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold">{{ number_format($item1, 0, '.', ',') }}</td>
                                @endforeach
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold">{{ number_format(array_sum($totalData), 0, '.', ',') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
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

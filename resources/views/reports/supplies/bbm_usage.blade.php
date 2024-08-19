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
                        Laporan Pemakaian @if($type_bbm == 'solar')HSD @elseif($type_bbm == 'residu')MFO @endif
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

                    <div class="w-full flex justify-end gap-4">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                    </div>
                </form>
            </div>


            <div class="bg-white rounded-lg p-6" id="my-pdf">
                 <div class="flex justify-between items-center mb-4">
                    <div>
                        <img src="{{asset('logo.png')}}" alt="" width="200">
                        <p class="text-right">UBP SURALAYA</p>
                    </div>
                    <div class="text-center text-[20px] font-bold">
                        <p>Laporan Pemakaian @if($type_bbm == 'solar')HSD @elseif($type_bbm == 'residu')MFO @endif</p>
                        {{-- <p>No: {{$tug->bpb_number}}/IBPB/UBPSLA/PBB/{{date('Y')}}</p> --}}
                    </div>
                    <div></div>
                </div>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                @foreach ($bbm_usage as $index => $item)
                                @php
                                    $total = count($item['unit']);
                                @endphp
                                @break
                                @endforeach
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">@if($filter_type == 'day') Tanggal @elseif($filter_type == 'month') Bulan @elseif($filter_type == 'year') Tahun @endif</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Penerimaan (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="{{ $total+3 }}">Pemakaian @if($type_bbm == 'solar')HSD @elseif($type_bbm == 'residu')MFO @endif Sesuai TUG 9 (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2">Persediaan (Liter)</th>
                            </tr>
                            <tr>
                                @php
                                    $i=1;
                                @endphp
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Albes</th>
                                @foreach ($bbm_usage as $index => $item)
                                @foreach ($item['unit'] as $index1 => $item1)
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">{{ $index1 }}</th>
                                    @php
                                        $i  = $i + 1;
                                    @endphp
                                @endforeach
                                @break
                                @endforeach
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Lainnya</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Jumlah</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Kumulatif</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Efektif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bbm_usage as $index => $item)
                            @php
                                $sum = 0;
                            @endphp
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'day') {{ $index+1 }}-{{ $bulan }}-{{ $tahun }} @elseif($filter_type == 'month') {{ date('M', mktime(0, 0, 0, $index+1, 1)) }} @elseif($filter_type == 'year') {{ $start_year + $index }} @endif</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $bbm_receipt[$index] }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item['heavy_equipment'] }}</td>
                                @foreach ($item['unit'] as $index1 => $item1)
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item1 }}</td>
                                @php
                                    $sum = $sum + $item1;
                                @endphp
                                @endforeach
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item['other'] }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $sum + $item['other'] + $item['heavy_equipment'] }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">0.0</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">0.0</td>
                            </tr>
                            @endforeach
                            {{-- <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold">Jumlah</td>
                                @foreach ($totalData as $index1 => $item1)
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold">{{ $item1 }}</td>
                                @endforeach
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold">{{array_sum($totalData) }}</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
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

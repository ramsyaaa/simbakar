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
                        <div class="w-full mb-2 lg:mb-0">
                            <select id="tahun" name="tahun" class="w-full h-[44px] rounded-md border px-2" autofocus>
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
                                        <option {{request()->start_year == $i ? 'selected' :''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="w-full mb-4">
                            <div class="w-full mb-2 lg:mb-0">
                                <select id="end_year" name="end_year" class="w-full h-[44px] rounded-md border px-2" autofocus>
                                    <option selected disabled>Pilih Tahun Akhir</option>
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option {{request()->end_year == $i ? 'selected' :''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="w-full flex justify-end gap-4">
                        <a href="{{ route('reports.supplies.index') }}" class="bg-red-500 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
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
                        <p>Laporan Pemakaian @if($type_bbm == 'solar')HSD @elseif($type_bbm == 'residu')MFO @endif</p>
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
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format($bbm_receipt[$index], 0, '.', ',') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format($item['heavy_equipment'], 0, '.', ',') }}</td>
                                @foreach ($item['unit'] as $index1 => $item1)
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format($item1, 0, '.', ',') }}</td>
                                @php
                                    $sum = $sum + $item1;
                                @endphp
                                @endforeach
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format($item['other'], 0, '.', ',') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format(($sum + $item['other'] + $item['heavy_equipment']), 0, '.', ',') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">0.0</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">0.0</td>
                            </tr>
                            @endforeach
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

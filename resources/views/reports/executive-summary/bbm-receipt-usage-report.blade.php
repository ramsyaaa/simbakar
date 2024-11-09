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
                        Filter Monitoring Penerimaan, Pemakaian, dan Persediaan @if($type_bbm == 'solar')HSD @elseif($type_bbm == 'residu')MFO @endif
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
                                    <option {{request()->end_year == $i  || $i == date('Y') ? 'selected' :''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="w-full flex justify-end gap-2">
                        <a href="{{ route('reports.executive-summary.index') }}" class="bg-red-500 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
                        <button type="button" class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="ExportToExcel('xlsx')">Download</button>
                        <button type="button"
                                class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg"
                                onclick="handlePrint()">Print</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                    </div>
                </form>
            </div>

            @if($filter_type != null)
            <div class="bg-white rounded-lg p-6" id="my-pdf">
                <div class="overflow-auto max-w-full">
                    <table class="w-full" id="table">
                        <thead>
                            <tr>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">@if($filter_type == 'day')Tanggal @elseif($filter_type == 'month') Bulan @elseif($filter_type == 'year') Tahun @endif</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2">Stock Awal</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2">Penerimaan</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2">Pemakaian</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2">Stock Kumulatif</th>
                            </tr>
                            <tr>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Realisasi (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Realisasi (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Realisasi (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Realisasi (Liter)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bbm_usage as $index => $item)
                            <tr>
                                @if($filter_type == 'day')
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $index+1 }}-{{ $bulan }}-{{ $tahun }}</td>
                                @endif
                                @if($filter_type == 'month')
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ DateTime::createFromFormat('!m', $index+1)->format('M') }}</td>
                                @endif
                                @if($filter_type == 'year')
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $index }}</td>
                                @endif

                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'year') {{ number_format($item['cumulative'], 0) }} @else @if($index == 0) {{ number_format($start_year_data_actual ?? 0, 0) }} @else {{ number_format($cumulative[$index - 1], 0) }} @endif @endif</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'year') {{ number_format($item['cumulative'], 0) }} @else @if($index == 0) {{ number_format($start_year_data_actual ?? 0, 0) }} @else {{ number_format($cumulative[$index - 1], 0) }} @endif @endif</td>

                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'year') {{ number_format(isset($item['bbm_receipt_plan']['total_planning']) ? $item['bbm_receipt_plan']['total_planning'] : 0, 0) }} @else {{ number_format(isset($bbm_receipt_plan->planning) ? $bbm_receipt_plan->planning : 0, 0) }} @endif</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'year') {{  number_format($item['bbm_receipt'], 0) }} @else {{ number_format($bbm_receipt[$index], 0) }} @endif</td>

                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'year') {{ number_format(isset($item['bbm_usage_plan']['total_planning']) ? $item['bbm_usage_plan']['total_planning'] : 0, 0) }} @else {{ number_format(isset($usage_plan->planning) ? $usage_plan->planning : 0, 0) }} @endif</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'year') {{ number_format($item['bbm_usage'], 0) }} @else{{ number_format($bbm_usage[$index], 0) }} @endif</td>

                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'year') {{ number_format($item['cumulative'], 0) }} @else {{ number_format($cumulative[$index], 0) }} @endif</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'year') {{ number_format($item['cumulative'], 0) }} @else {{ number_format($cumulative[$index], 0) }} @endif</td>

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

    function handlePrint() {
        printPDF()
    }
</script>

@endsection

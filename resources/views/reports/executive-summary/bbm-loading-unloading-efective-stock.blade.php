@extends('layouts.app')
@php
    function formatNumber($val)
    {
        return number_format($val, 0);
    }

    function getTotalUnit($item)
    {
        if ($item) {
            return $item['unit_1'] +
                $item['unit_2'] +
                $item['unit_3'] +
                $item['unit_4'] +
                $item['unit_5'] +
                $item['unit_6'] +
                $item['unit_7'];
        }
        return 0;
    }

    function getTotalSumUnit($datas)
    {
        if (isset($datas)) {
            $data = collect($datas);
            $unit_1 = $data->pluck('unit_1')->sum();
            $unit_2 = $data->pluck('unit_2')->sum();
            $unit_3 = $data->pluck('unit_3')->sum();
            $unit_4 = $data->pluck('unit_4')->sum();
            $unit_5 = $data->pluck('unit_5')->sum();
            $unit_6 = $data->pluck('unit_6')->sum();
            $unit_7 = $data->pluck('unit_7')->sum();
            return $unit_1 + $unit_2 + $unit_3 + $unit_4 + $unit_5 + $unit_6 + $unit_7;
        }
        return 0;
    }

    $label = 'Tanggal';
    if (isset($_GET['type'])) {
        switch ($_GET['type']) {
            case 'month':
                $label = 'Bulan';
                break;
            case 'year':
                $label = 'Tahun';
                break;
            default:
                $label = 'Tanggal';
                break;
        }
    }
@endphp
@section('content')
    <div x-data="{ sidebar: true }" class="w-screen min-h-screen flex bg-[#E9ECEF]">
        @include('components.sidebar')
        <div :class="sidebar ? 'w-10/12' : 'w-full'">
            @include('components.header')
            <div class="w-full py-10 px-8">
                <div class="flex items-end justify-between mb-2">
                    <div>
                        <div class="text-[#135F9C] text-[40px] font-bold">
                            Realisasi Penerimaan, Pemakaian dan Persediaan Efektif Batubara
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-center mb-6">
                    <form method="POST" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                        @csrf

                        <div class="flex items-center gap-4">
                            <label for="day" class="flex items-center gap-2">
                                <input id="day" @if ((isset($_GET['type']) && $_GET['type'] == 'day') || !isset($_GET['type'])) checked @endif name="type"
                                    type="radio" value="day">
                                Hari
                            </label>
                            <label for="month" class="flex items-center gap-2">
                                <input id="month" @if (isset($_GET['type']) && $_GET['type'] == 'month') checked @endif name="type"
                                    type="radio" value="month">
                                Bulan
                            </label>
                            <label for="year" class="flex items-center gap-2">
                                <input @if (isset($_GET['type']) && $_GET['type'] == 'year') checked @endif id="year" name="type"
                                    type="radio" value="year">
                                Tahun
                            </label>
                        </div>

                        @if ((isset($_GET['type']) && $_GET['type'] == 'day') || !isset($_GET['type']))
                            <div id="month-fields" class="filter-field">
                                <div class="w-full mb-4">
                                    <label for="month-input">Bulan:</label>
                                    <input type="text" name="type" value="day" hidden>
                                    <input type="month" id="month-input" name="month"
                                        class="border h-[40px] w-full rounded-lg px-3"
                                        value="{{ request('month', $month) }}" min="2000" max="2100">
                                </div>
                            </div>
                        @endif

                        @if (isset($_GET['type']) && $_GET['type'] == 'month')
                            <div id="year-fields" class="filter-field">
                                <div class="w-full mb-4">
                                    <label for="year-input">Tahun:</label>
                                    <input type="text" name="type" value="month" hidden>
                                    <input type="number" id="year-input" name="year"
                                        class="border h-[40px] w-full rounded-lg px-3" value="{{ request('year', $year) }}"
                                        min="2000" max="2100">
                                </div>
                            </div>
                        @endif

                        @if (isset($_GET['type']) && $_GET['type'] == 'year')
                            <div id="start_year-fields" class="filter-field">
                                <input type="text" name="type" value="year" hidden>
                                <div class="w-full mb-4">
                                    <label for="start_year-input">Tahun Awal:</label>
                                    <input type="number" id="start_year-input" name="start_year"
                                        class="border h-[40px] w-full rounded-lg px-3"
                                        value="{{ request('start_year', $start_year) }}" min="2000" max="2100">
                                </div>
                                <div class="w-full mb-4">
                                    <label for="end_year-input">Tahun Akhir:</label>
                                    <input type="number" id="end_year-input" name="end_year"
                                        class="border h-[40px] w-full rounded-lg px-3"
                                        value="{{ request('end_year', $end_year) }}" min="2000" max="2100">
                                </div>
                            </div>
                        @endif


                        <div class="w-full flex justify-end gap-2">
                            <button type="button"
                                class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg"
                                onclick="handlePrint()">Print</button>
                            <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg"
                                type="submit">Filter</button>
                        </div>
                    </form>
                </div>


            </div>

            @if ($type)
                <div class="px-8 -mt-8 mb-4" id="my-pdf">
                    <style>
                        table {
                            width: 100% !important;
                            border-collapse: collapse !important;
                            page-break-inside: auto !important;
                        }

                        tr {
                            page-break-inside: avoid !important;
                            page-break-after: auto !important;
                        }

                        th,
                        td {
                            text-align: center !important;
                            font-size: 12px !important
                        }

                        thead {
                            display: table-header-group !important;
                        }

                        tfoot {
                            display: table-footer-group !important;
                        }
                    </style>

                    <div class="bg-white display-table rounded-lg p-6">
                        <div class="overflow-auto hide-scrollbar max-w-full">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">No</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">
                                            {{ $label }}</th>
                                        {{-- @if (isset($_GET['type']) && $_GET['type'] == 'month')
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Stock
                                        </th>
                                    @endif --}}
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Realisasi
                                            Penerimaan (Kg)
                                        </th>
                                        @if ($type == 'year' || $type == 'month')
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Realisasi
                                                Pemakaian (Kg)
                                            </th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">
                                                Persediaan Awal Tahun (Kg)
                                            </th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">
                                                Persediaan Akhir Tahun (Kg)
                                            </th>
                                        @endif

                                    </tr>
                                    <tr>
                                        @if (isset($type) && $type == 'day')
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="1">
                                                Realisasi
                                                Pemakaian
                                            </th>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="1">Stock
                                                Efektif
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($bbm_unloading as $day => $item)
                                        @php
                                            $i++;
                                        @endphp
                                        <tr>
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{ $i }}
                                            </td>
                                            <td class="h-[36px] text-[16px] font-normal border px-2">{{ $day }}
                                            </td>
                                            {{-- @if (isset($_GET['type']) && $_GET['type'] == 'month')
                                            <td class="h-[36px] text-[16px] font-normal border px-2">
                                                {{ isset($item['stock']) ? formatNumber($item['stock']) : '-' }}
                                            </td>
                                        @endif --}}
                                            <td class="h-[36px] text-[16px] font-normal border px-2">
                                                {{ isset($item['tug']) ? formatNumber($item['tug']) : '-' }}
                                            </td>
                                            @if ($type == 'year' || $type == 'month')
                                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                                    {{ formatNumber(getTotalUnit($item)) }}
                                                </td>
                                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                                    {{ isset($item['stock']) ? formatNumber($item['stock']) : '-' }}
                                                </td>
                                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                                    {{ isset($item['tug']) ? formatNumber($item['tug'] - getTotalUnit($item)) : '-' }}
                                                </td>
                                            @endif
                                            @if (isset($type) && $type == 'day')
                                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                                    {{ formatNumber(getTotalUnit($item)) }}
                                                </td>
                                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                                    {{ isset($item['stock']) ? formatNumber($item['stock'] - getTotalUnit($item)) : '-' }}
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                                @if (count($bbm_unloading) > 0)
                                    <tfoot>
                                        <tr>
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2">Total
                                            </th>
                                            {{-- @if (isset($_GET['type']) && $_GET['type'] == 'month')
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                {{ formatNumber(collect($bbm_unloading)->pluck('stock')->sum()) }}
                                            </th>
                                        @endif --}}
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum()) }}</th>
                                            @if ($type == 'year' || $type == 'month')
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(getTotalSumUnit($bbm_unloading)) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(collect($bbm_unloading)->pluck('stock')->sum()) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum() - getTotalSumUnit($bbm_unloading)) }}
                                                </th>
                                            @endif
                                            @if (isset($type) && $type == 'day')
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(getTotalSumUnit($bbm_unloading)) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(getTotalSumUnit($bbm_unloading)) }}
                                                </th>
                                            @endif
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('[name="type"]').change(function() {
                let val = $(this).val();
                let isChecked = this.checked;
                console.log(isChecked)
                if (isChecked) {
                    let url =
                        `{{ route('reports.executive-summary.bbm-loading-unloading-efective-stock') }}?type=${val}`
                    window.location.href = url;
                }
            })
        })


        function handlePrint() {
            printPDF()
        }
    </script>
@endsection

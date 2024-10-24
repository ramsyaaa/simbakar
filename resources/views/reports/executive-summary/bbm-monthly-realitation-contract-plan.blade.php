@extends('layouts.app')
@php
    function formatNumber($val)
    {
        return number_format($val, 0);
    }
@endphp
@section('content')
    <div x-data="{ sidebar: true }" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
        @include('components.sidebar')
        <div class="max-h-screen overflow-y-scroll" :class="sidebar ? 'w-10/12' : 'w-full'">
            @include('components.header')
            <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
                <div class="flex items-end justify-between mb-2">
                    <div>
                        <div class="text-[#135F9C] text-[40px] font-bold">
                            Rencana Realisasi Kontrak Batubara Bulanan
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-center mb-6">
                    <form method="POST" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                        @csrf
                        <div id="suppliers-fields" class="filter-field">
                            <div class="w-full mb-4 flex items-start gap-0 flex-col">
                                <label for="suppliers">Pemasok :</label>
                                <select name="supplier" id="suppliers" class="select-2 w-full">
                                    <option value="">Pilih Semua Pemasok</option>
                                    @foreach ($suppliers as $item)
                                        <option @if ($supplier == $item->id) selected @endif
                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="number" id="suppliers" name="suppliers"
                                    class="border h-[40px] w-full rounded-lg px-3" value="{{ request('suppliers', $suppliers) }}"
                                    min="2000" max="2100"> --}}
                            </div>
                        </div>
                        <div id="year-fields" class="filter-field">
                            <div class="w-full mb-4 flex flex-col gap-2">
                                <label for="year">Tahun:</label>
                                <div class="w-full mb-2 lg:mb-0">
                                    <select id="year" name="year" class="w-full h-[44px] rounded-md border px-2"
                                        autofocus>
                                        <option selected disabled>Pilih Tahun</option>
                                        @for ($i = date('Y'); $i >= 2000; $i--)
                                            <option {{ request()->year == $i ? 'selected' : '' }}>{{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="contract-fields" class="filter-field">
                            <div class="w-full mb-4 flex items-start gap-0 flex-col">
                                <label for="contract">Kontrak :</label>
                                <select name="contract" id="contract" class="select-2 w-full">
                                    <option value="">Pilih Semua Kontrak</option>
                                    @foreach ($contracts as $item)
                                        <option @if ($contract == $item['id']) selected @endif
                                            value="{{ $item['id'] }}">{{ $item['type_contract'] }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="number" id="contract" name="contract"
                                    class="border h-[40px] w-full rounded-lg px-3" value="{{ request('contract', $contract) }}"
                                    min="2000" max="2100"> --}}
                            </div>
                        </div>
                        {{-- <div class="flex items-center gap-4">
                            <label for="grafik" class="flex items-center gap-2">
                                <input id="grafik" checked name="display" type="checkbox" value="grafik">
                                Grafik
                            </label>
                            <label for="table" class="flex items-center gap-2">
                                <input id="table" checked name="display" type="checkbox" value="table">
                                Tabel
                            </label>
                        </div> --}}

                        <div class="w-full flex justify-end gap-2">
                            <a href="{{ route('reports.executive-summary.index') }}"
                                class="bg-red-500 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
                            <button type="button"
                                class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg"
                                onclick="ExportToExcel('xlsx')">Download</button>
                            <button type="button"
                                class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg"
                                onclick="handlePrint()">Print</button>
                            <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg"
                                type="submit">Filter</button>
                        </div>
                    </form>
                </div>


            </div>
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
                        <table class="w-full" id="table">
                            <thead>
                                <tr>
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Bulan</th>
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2" rowspan="1">
                                        Rencana</th>
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Realisasi (Kg)
                                    </th>
                                    <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="4" rowspan="1">
                                        Deviasi</th>

                                </tr>
                                <tr>
                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">Kontrak Awal (Kg)</th>
                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">Rakor (Kg)</th>

                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">Kontrak Awal (Kg)</th>
                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">%</th>

                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">Rakor (Kg)</th>
                                    <th class="border bg-[#F5F6FA]  text-[#8A92A6]">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($bbm_unloading as $month => $item)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">{{ $month }}</td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['tug']) ? formatNumber($item['tug']) : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['tug']) ? formatNumber($item['tug']) : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['tug']) ? formatNumber($item['tug']) : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{-- {{ isset($item['tug']) ? formatNumber($item['tug'] + $item['rakor']) : '-' }} --}}
                                            -
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            -
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            {{ isset($item['tug']) ? formatNumber($item['tug']) : '-' }}
                                        </td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2">
                                            -
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @if (count($bbm_unloading) > 0)
                                <tfoot>
                                    <tr>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">Rata-rata
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum() / collect($bbm_unloading)->pluck('tug')->count()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum() / collect($bbm_unloading)->pluck('tug')->count()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum() / collect($bbm_unloading)->pluck('tug')->count()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{-- {{ formatNumber((collect($bbm_unloading)->pluck('tug')->sum() + collect($bbm_unloading)->pluck('rakor')->sum()) / collect($bbm_unloading)->pluck('rakor')->count()) }} --}}
                                            -
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            0
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum() / collect($bbm_unloading)->pluck('tug')->count()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            -
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">Total</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum()) }}</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum()) }}</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{-- {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum() + collect($bbm_unloading)->pluck('tug')->sum()) }} --}}
                                            -
                                        </th>

                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{-- {{ formatNumber(collect($bbm_unloading)->pluck('ds_bl')->sum()) }} --}}-
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum()) }}
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                            -
                                        </th>
                                    </tr>
                                </tfoot>
                            @endif

                        </table>
                    </div>
                </div>
                @if ($year)
                    {{-- <div class="mt-4 pb-10 display-grafik" style="page-break-after: always">
                        <div class="bg-white rounded-xl p-4 flex flex-col gap-4">

                            <div class="text-[#135F9C] text-xl text-center  font-bold">
                                Rencana Realisasi Kontrak Batubara Bulanan Tahun
                                {{ request('year', $year) }}
                            </div>
                            <div class="chart">
                                <canvas id="chart" class="h-[300px]"></canvas>
                            </div>
                        </div>
                    </div> --}}

                    <script>
                        const ctx = document.getElementById('chart').getContext('2d');
                        let bl = {!! json_encode(collect($bbm_unloading)->pluck('bl')->toArray()) !!};
                        let ds = {!! json_encode(collect($bbm_unloading)->pluck('ds')->toArray()) !!};
                        let bw = {!! json_encode(collect($bbm_unloading)->pluck('bw')->toArray()) !!};

                        bl = bl.map((item) => item ? parseInt(item) : 0)
                        ds = ds.map((item) => item ? parseInt(item) : 0)
                        bw = bw.map((item) => item ? parseInt(item) : 0)

                        const myBarChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: {!! json_encode(collect($bbm_unloading)->keys()->toArray()) !!},
                                datasets: [{
                                        label: 'BL',
                                        data: bl,
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'DS',
                                        data: ds,
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'BW',
                                        data: bw,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                scales: {
                                    x: {
                                        stacked: false
                                    },
                                    y: {
                                        stacked: false
                                    }
                                }
                            }
                        });
                    </script>
                @endif
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('[name="display"]').change(function() {
                let val = $(this).val();
                let isChecked = this.checked;
                console.log(val)
                if (isChecked) {
                    $(`.display-${val}`).show()
                } else {
                    $(`.display-${val}`).hide()
                }
            })
        })

        function handlePrint() {
            let canvas = $('.display-grafik canvas')[0];
            let chartContainer = $('.chart');
            var dataUrl = canvas.toDataURL(); // Convert canvas to data URL
            chartContainer.find('canvas').hide()
            let el = chartContainer.append(`<img class="w-full" src="${dataUrl}" />`)
            setTimeout(() => {
                printPDF()
            }, 1000);
            setTimeout(() => {
                chartContainer.find('canvas').show()
                el.hide()
            }, 3000);
        }
    </script>
@endsection

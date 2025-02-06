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
        <div class="max-h-screen overflow-hidden" :class="sidebar ? 'w-10/12' : 'w-full'">
            @include('components.header')
            <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
                <div class="h-screen overflow-y-auto">
                    <div class="flex items-end justify-between mb-2">
                        <div>
                            <div class="text-[#135F9C] text-[40px] font-bold">
                                Realisasi Pembongkaran Batubara Bulanan
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex justify-center mb-6">
                        <form method="POST" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                            @csrf

                            <div id="year-fields" class="filter-field">
                                <div class="w-full mb-4">
                                    <label for="year_month">Tahun:</label>
                                    <input type="month" id="year_month" name="year_month"
                                        class="border h-[40px] w-full rounded-lg px-3"
                                        value="{{ request('year_month', $year_month) }}">
                                </div>
                            </div>


                            <div class="flex items-center gap-4">
                                <label for="grafik" class="flex items-center gap-2">
                                    <input id="grafik" checked name="display" type="checkbox" value="grafik">
                                    Grafik
                                </label>
                                <label for="table" class="flex items-center gap-2">
                                    <input id="table" checked name="display" type="checkbox" value="table">
                                    Tabel
                                </label>
                            </div>

                            <div class="w-full flex justify-end gap-2">
                                <a href="{{ route('reports.executive-summary.index') }}"
                                    class="bg-red-500 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
                                <button type="button"
                                    class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg"
                                    onclick="ExportToExcel('xlsx')">Download</button>
                                <button type="button"
                                    class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg"
                                    onclick="printPDF()">Print</button>
                                <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg"
                                    type="submit">Filter</button>
                            </div>

                        </form>
                    </div>


                    <div id="my-pdf" class="bg-white rounded-lg p-6">
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

                            <div class="overflow-auto max-w-full">
                                <table class="w-full" id="table">
                                    <thead>
                                        <tr>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">No</th>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">Nama Kapal</th>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">Tanggal Terima
                                            </th>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">Pemasok</th>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">Lama
                                                Bongkar<br>(Jam)
                                            </th>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">Lama
                                                Standard<br>(Jam)
                                            </th>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">Lama
                                                Kapal<br>(Jam)
                                            </th>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">Waktu
                                                Tunggu<br>(Jam)
                                            </th>

                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">B/L<br>(Ton)</th>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">D/S<br>(Ton)</th>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">B/W<br>(Ton)</th>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">Diterima
                                                [TUG3](Ton)</th>
                                            <th class="border text-white bg-[#047A96] h-[52px] w-max">Nama Dermaga</th>

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
                                                <td class="h-[36px] !min-w-[50px] text-[16px] font-normal border px-2">
                                                    {{ $i }}
                                                </td>
                                                <td class="h-[36px] !min-w-[200px] text-[16px] font-normal border px-2">
                                                    {{ $item['ship_name'] }}
                                                </td>
                                                <td class="h-[36px] !min-w-[150px] text-[16px] font-normal border px-2">
                                                    {{ \Carbon\Carbon::createFromFormat('d M Y', $item['receipt_date'])->format('d-m-Y') ?? '-' }}
                                                </td>
                                                <td class="h-[36px] !min-w-[200px] text-[16px] font-normal border px-2">
                                                    {{ $item['company_name'] ?? '-' }}
                                                </td>
                                                <td class="h-[36px] !min-w-[100px] text-[16px] font-normal border px-2">
                                                    {{ number_format($item['unloading_duration'], 2) ?? '-' }}
                                                </td>
                                                <td class="h-[36px] !min-w-[100px] text-[16px] font-normal border px-2">
                                                    {{ number_format($item['standard_duration'], 2) ?? '-' }}
                                                </td>
                                                <td class="h-[36px] !min-w-[100px] text-[16px] font-normal border px-2">
                                                    {{ number_format($item['ship_duration'], 2) ?? '-' }}
                                                </td>
                                                <td class="h-[36px] !min-w-[100px] text-[16px] font-normal border px-2">
                                                    {{ number_format($item['waiting_time'], 2) ?? '-' }}
                                                </td>
                                                <td class="h-[36px] !min-w-[150px] text-[16px] font-normal border px-2">
                                                    {{ number_format($item['bl']) ?? '-' }}
                                                </td>
                                                <td class="h-[36px] !min-w-[150px] text-[16px] font-normal border px-2">
                                                    {{ number_format($item['ds']) ?? '-' }}
                                                </td>
                                                <td class="h-[36px] !min-w-[150px] text-[16px] font-normal border px-2">
                                                    {{ number_format($item['bw']) ?? '-' }}
                                                </td>
                                                <td class="h-[36px] !min-w-[150px] text-[16px] font-normal border px-2">
                                                    {{ number_format($item['tug']) ?? '-' }}
                                                </td>
                                                <td class="h-[36px] !min-w-[150px] text-[16px] font-normal border px-2">
                                                    {{ $item['dock_name'] ?? '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    @if (count($bbm_unloading) > 0)
                                        <tfoot>
                                            <tr>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="4">
                                                    Rata-rata
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ number_format(collect($bbm_unloading)->pluck('unloading_duration')->sum() / collect($bbm_unloading)->pluck('unloading_duration')->count(), 2) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ number_format(collect($bbm_unloading)->pluck('standard_duration')->sum() / collect($bbm_unloading)->pluck('standard_duration')->count(), 2) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ number_format(collect($bbm_unloading)->pluck('ship_duration')->sum() / collect($bbm_unloading)->pluck('ship_duration')->count(), 2) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ number_format(collect($bbm_unloading)->pluck('waiting_time')->sum() / collect($bbm_unloading)->pluck('standard_duration')->count(), 2) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(collect($bbm_unloading)->pluck('bl')->sum() / collect($bbm_unloading)->pluck('bl')->count()) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(collect($bbm_unloading)->pluck('ds')->sum() / collect($bbm_unloading)->pluck('ds')->count()) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(collect($bbm_unloading)->pluck('bw')->sum() / collect($bbm_unloading)->pluck('bw')->count()) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(collect($bbm_unloading)->pluck('tug')->sum() / collect($bbm_unloading)->pluck('tug')->count()) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    -
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="4">Total
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ number_format(collect($bbm_unloading)->pluck('unloading_duration')->sum(), 2) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ number_format(collect($bbm_unloading)->pluck('standard_duration')->sum(), 2) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ number_format(collect($bbm_unloading)->pluck('ship_duration')->sum(), 2) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ number_format(collect($bbm_unloading)->pluck('waiting_time')->sum(), 2) }}
                                                </th>

                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(collect($bbm_unloading)->pluck('bl')->sum()) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(collect($bbm_unloading)->pluck('ds')->sum()) }}
                                                </th>
                                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="1">
                                                    {{ formatNumber(collect($bbm_unloading)->pluck('bw')->sum()) }}
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
                        <div class="mt-4 pb-10 display-grafik" style="page-break-after: always">
                            <div class="bg-white rounded-xl p-4 flex flex-col gap-4">

                                <div class="text-[#135F9C] text-xl text-center  font-bold">
                                    Grafik Realisasi Pembongkaran Batubara Bulanan <br>
                                    {{-- Per {{ request('year_month', $year_month) }} --}}
                                </div>
                                <div class="chart">
                                    <canvas id="chart" class="h-[300px]"></canvas>
                                </div>
                            </div>
                        </div>
                        <script>
                            const ctx = document.getElementById('chart').getContext('2d');
                            let tug = {!! json_encode(collect($bbm_unloading)->pluck('tug')->toArray()) !!};

                            tug = tug.map((item) => item ? parseInt(item) : 0)

                            const myBarChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: {!! json_encode(collect($bbm_unloading)->pluck('ship_name')->toArray()) !!},
                                    datasets: [{
                                        label: 'Diterima [TUG3](Ton)',
                                        data: tug,
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1
                                    }, ]
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
                    </div>
                </div>
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

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
                        <div class="overflow-auto max-w-full">
                            <table class="w-full" id="table">
                                <thead>
                                    <tr>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">No</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">Nama Kapal</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">Tanggal Terima</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">Pemasok</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">Lama Bongkar<br>(Jam)
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">Lama Standard<br>(Jam)
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">Lama Kapal<br>(Jam)
                                        </th>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">Waktu Tunggu<br>(Jam)
                                        </th>

                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">B/L<br>(Ton)</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">D/S<br>(Ton)</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">B/W<br>(Ton)</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">Diterima
                                            [TUG3](Ton)</th>
                                        <th class="border bg-[#F5F6FA] h-[52px] w-max text-[#8A92A6]">Nama Dermaga</th>

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
                                                {{ $item['bl'] ?? '-' }}
                                            </td>
                                            <td class="h-[36px] !min-w-[150px] text-[16px] font-normal border px-2">
                                                {{ $item['ds'] ?? '-' }}
                                            </td>
                                            <td class="h-[36px] !min-w-[150px] text-[16px] font-normal border px-2">
                                                {{ $item['bw'] ?? '-' }}
                                            </td>
                                            <td class="h-[36px] !min-w-[150px] text-[16px] font-normal border px-2">
                                                {{ $item['tug'] ?? '-' }}
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
                                            <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="4">Rata-rata
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
                </div>
            </div>

        </div>
    </div>
@endsection

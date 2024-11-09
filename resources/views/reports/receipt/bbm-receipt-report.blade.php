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
                        Rekapitulasi Penerimaan @if($type_bbm == 'solar')HSD @elseif($type_bbm == 'residu')MFO @endif
                    </div>
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
                        </select>
                    </div>

                    <div id="day-fields" class="filter-field mb-6" style="display: none;">
                        <input type="month" id="bulan_tahun" name="bulan_tahun" class="border h-[40px] w-full rounded-lg px-3" value="{{ request('bulan_tahun', date($tahun . '-' . $bulan)) }}">
                    </div>

                    <div id="month-fields" class="filter-field" style="display: none;">
                        <div class="w-full mb-2">
                            <select id="tahun" name="tahun" class="w-full h-[44px] rounded-md border px-2" autofocus>
                                <option selected disabled>Pilih Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option {{request()->tahun == $i ? 'selected' :''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="w-full flex justify-end gap-2">
                        <a href="{{ route('reports.receipt.index') }}" class="bg-red-500 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
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
                                @if($filter_type == 'day')
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Pengangkut</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" rowspan="2">Nomor Faktur</th>
                                @endif
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2">Volume Observe</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2">Volume Liter 15&deg;C</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]" colspan="2">Selisih</th>
                            </tr>
                            <tr>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Faktur (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">TUG-3 (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Faktur (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">TUG-3 (Liter)</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Liter Obs.</th>
                                <th class="border bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Selisih %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = [0,0,0,0];
                            @endphp
                            @foreach ($bbm_receipt as $index => $item)
                            <tr>
                                @if($filter_type == 'day')
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ date('d-m-Y', strtotime($item->date_receipt)) }}</td>
                                @endif
                                @if($filter_type == 'month')
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ DateTime::createFromFormat('!m', $index)->format('F') }}</td>
                                @endif
                                @if($filter_type == 'day')
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    @if($item->shipment_type == 'car')
                                    {{ $item->car_type }} ({{ $item->police_number }})
                                    @elseif($item->shipment_type == "ship")
                                    {{ isset($item->ship) ? $item->ship->name : "" }}
                                    @endif
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->faktur_number }}</td>
                                @endif
                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'day'){{ number_format($item->faktur_obs, 0, '.', ',') }}@elseif($filter_type == 'month') {{ number_format($item['total_faktur_obs'], 0, '.', ',') }} @endif</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    @if($filter_type == 'day'){{ number_format($item->amount_receipt, 0, '.', ',') }} @elseif($filter_type == 'month') {{ number_format($item['amount_receipt'], 0, '.', ',') }} @endif
                                </td>

                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'day'){{ number_format($item->faktur_ltr15, 0, '.', ',') }} @elseif($filter_type == 'month') {{ number_format($item['total_faktur_ltr15'], 0, '.', ',') }} @endif</td>

                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'day'){{ number_format($item->liter_15_tug3, 0, '.', ',') }}@elseif($filter_type == 'month') {{ number_format($item['total_liter_15_tug3'], 0, '.', ',') }} @endif</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($filter_type == 'day'){{ number_format(($item->amount_receipt - intval($item->faktur_obs)), 0, '.', ',') }} @elseif($filter_type == 'month') {{ number_format(($item['amount_receipt'] - $item['total_faktur_obs']), 0, '.', ',') }} @endif</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    @if($filter_type == 'day')
                                    @php
                                        $selisih = (intval($item->faktur_obs) != 0 ? ((intval($item->amount_receipt) - intval($item->faktur_obs)) / intval($item->faktur_obs)) * 100 : 0);
                                    @endphp
                                    {{ number_format($selisih, 2) }} 
                                    @elseif($filter_type == 'month') 
                                    {{ number_format((intval($item['total_faktur_obs']) != 0 ? ((intval($item['amount_receipt']) - intval($item['total_faktur_obs']))/intval($item['total_faktur_obs']))*100 : 0), 2, '.', ',') }}
                                    @endif
                                </td>
                                @php
                                if($filter_type == 'day'){
                                    $total[0] = $total[0] + intval($item->faktur_obs);
                                    $total[1] = $total[1] + intval($item->amount_receipt);
                                    $total[2] = $total[2] + intval($item->faktur_ltr15);
                                    $total[3] = $total[3] + intval($item->liter_15_tug3);
                                }elseif($filter_type == 'month'){
                                    $total[0] = $total[0] + intval($item['total_faktur_obs']);
                                    $total[1] = $total[1] + intval($item['amount_receipt']);
                                    $total[2] = $total[2] + intval($item['total_faktur_ltr15']);
                                    $total[3] = $total[3] + intval($item['total_liter_15_tug3']);
                                }
                                @endphp
                            </tr>
                            @endforeach
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold text-right" @if($filter_type == 'day')colspan="3"@endif>Jumlah</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold text-right">{{ number_format($total[0], 0, '.', ',') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold text-right">{{ number_format($total[1], 0, '.', ',') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold text-right">{{ number_format($total[2], 0, '.', ',') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold text-right">{{ number_format($total[3], 0, '.', ',') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold text-right">{{ number_format(($total[1] - $total[0]), 0, '.', ',') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 font-bold text-right"></td>
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

        function updateFields() {
            const filterType = filterTypeSelect.value;

            // Sembunyikan semua input terlebih dahulu
            dayFields.style.display = 'none';
            monthFields.style.display = 'none';
            // Tampilkan input yang sesuai dengan filter_type
            if (filterType === 'day') {
                dayFields.style.display = 'block';
            } else if (filterType === 'month') {
                monthFields.style.display = 'block';
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

@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="flex items-end justify-between mb-2">
            </div>
            <div class="w-full flex justify-center mb-6">
                <form method="get" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                    <div class="flex gap-3">
                        <div class="w-full mb-4">
                            <label for="start_year">Tahun Awal:</label>
                            <select name="start_year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md" required>
                                <option value="">Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option {{request()->start_year == $i || $i == 2021 ? 'selected' :''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="w-full mb-4">
                            <label for="end_year">Tahun Akhir:</label>
                            <select name="end_year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md" required>
                                <option value="">Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option {{request()->end_year == $i || $i == date('Y') ? 'selected' :''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <select name="type" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md" required>
                            <option value="0" {{request('type') == 0 ? 'selected' : ''}}>Semua Kontrak</option>
                            <option {{request('type') == 'Jangka Panjang' ? 'selected' : ''}}>Jangka Panjang</option>
                            <option {{request('type') == 'Jangka Menengah' ? 'selected' : ''}}>Jangka Menengah</option>
                            <option {{request('type') == 'Spot' ? 'selected' : ''}}>Spot</option>
                        </select>
                    </div>

                    <div class="w-full flex justify-end gap-4">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button type="button" class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="ExportToExcel('xlsx')">Download</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                        <a href="{{route('reports.contracts.index')}}" class="bg-pink-900 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
                    </div>
                </form>
            </div>
            @isset($contracts)

                <div id="my-pdf">

                    <div class="bg-white rounded-lg p-6 body">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <img src="{{asset('logo.png')}}" alt="" width="200">
                                <p class="text-right">UBP SURALAYA</p>
                            </div>
                            <div class="text-center text-[20px] font-bold">
                                <p>RENCANA DAN REALISASI KONTRAK BATUBARA TAHUN {{ request('start_year' ?? '')}} s/d {{request('end_year') ?? ''}}</p>
                            </div>
                            <div></div>
                        </div>
                            <div class="overflow-x-auto max-w-full">
                                <table class="min-w-max" id="table">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="border border-gray-400 p-2">No</th>
                                            <th rowspan="2" class="border border-gray-400 p-2">Pemasok</th>
                                            <th rowspan="2" class="border border-gray-400 p-2">Kontrak</th>
                                            <th rowspan="2" class="border border-gray-400 p-2">Jumlah ( Ton )</th>
                                            <th rowspan="2" class="border border-gray-400 p-2">Batas Kontrak</th>
                                            <th rowspan="2" class="border border-gray-400 p-2">Perpanjangan Waktu</th>
                                            <th rowspan="2" class="border border-gray-400 p-2">Posisi</th>
                                            @php
                                                $countYear = $start_year == $end_year ? 1 : ( $end_year - $start_year + 1);
                                            @endphp
                                            <th colspan="{{$countYear}}" class="border border-gray-400 p-2">Tahun</th>
                                            <th rowspan="2" class="border border-gray-400 p-2">Realisasi ( Ton )</th>
                                            <th colspan="2" class="border border-gray-400 p-2">Deviasi ( Ton )</th>
                                        </tr>
                                        <tr>
                                            @for ($i = $start_year ; $i <= $end_year; $i++)
                                                <th class="border border-gray-400 p-2">{{$i}}</th>
                                            @endfor
                                            <th class="border border-gray-400 p-2">Ton</th>
                                            <th class="border border-gray-400 p-2">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contracts as $contract)
                                            <tr>
                                                <td class="border border-gray-400 p-2" rowspan="4">{{$loop->iteration}}</td>
                                                <td class="border border-gray-400 p-2" rowspan="4">{{$contract->name}}</td>
                                                <td class="border border-gray-400 p-2" rowspan="4">{{$contract->contract_number}}</td>
                                                <td class="border border-gray-400 p-2" rowspan="4">{{number_format($contract->total_volume)}}</td>
                                                <td class="border border-gray-400 p-2" rowspan="4">{{ date('d-m-Y', strtotime($contract->contract_end_date))}}</td>
                                                <td class="border border-gray-400 p-2" rowspan="4"></td>
                                                <td class="border border-gray-400 p-2">K</td>
                                                @foreach ($contract->data['k'] as $k)
                                                    <td class="border border-gray-400 p-2">{{number_format($k)}}</td>
                                                @endforeach
                                                <td class="border border-gray-400 p-2" rowspan="4">{{number_format($contract->realization)}}</td>
                                                <td class="border border-gray-400 p-2" rowspan="4">{{number_format($contract->deviasi_ton)}}</td>
                                                <td class="border border-gray-400 p-2" rowspan="4">{{number_format($contract->deviasi_percentage)}}</td>
                                            </tr>
                                            <tr>
                                                <td class="border border-gray-400 p-2">R</td>
                                                @foreach ($contract->data['r'] as $r)
                                                    <td class="border border-gray-400 p-2">{{number_format($r)}}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td class="border border-gray-400 p-2">%</td>
                                                @foreach ($contract->data['%'] as $percentage)
                                                    <td class="border border-gray-400 p-2">{{$percentage}}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td class="border border-gray-400 p-2">D</td>
                                                @foreach ($contract->data['d'] as $d)
                                                    <td class="border border-gray-400 p-2">{{number_format($d)}}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endisset

        </div>
    </div>
</div>
@endsection

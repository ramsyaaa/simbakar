@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen min-h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
            </div>
            <div class="w-full flex justify-center mb-6">
                <form method="get" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                    <div class="mb-4">
                        <select name="year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option value="">Tahun</option>
                            @for ($i = date('Y'); $i >= 2000; $i--)
                                <option {{request()->year == $i ? 'selected' :''}}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="type" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option value="0" {{request('type') == 0 ? 'selected' : ''}}>Semua Kontrak</option>
                            <option {{request('type') == 'Jangka Panjang' ? 'selected' : ''}}>Jangka Panjang</option>
                            <option {{request('type') == 'Jangka Menengah' ? 'selected' : ''}}>Jangka Menengah</option>
                            <option {{request('type') == 'Spot' ? 'selected' : ''}}>Spot</option>
                        </select>
                    </div>

                    <div class="w-full flex justify-end gap-4">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                    </div>
                </form>
            </div>

            <div id="my-pdf">
                <div class="body bg-white rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <div>
                        <img src="{{asset('logo.png')}}" alt="" width="200">
                        <p class="text-right">UBP SURALAYA</p>
                    </div>
                    <div class="text-center text-[20px] font-bold">
                        <p>RENCANA DAN REALISASI KONTRAK BATUBARA TAHUN {{ request('year' ?? '')}}</p>
                    </div>
                    <div></div>
                </div>
                @isset($contracts)
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th rowspan="2" class="border border-gray-400 p-2">No</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Pemasok</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Kontrak</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Volume Kontrak ( Ton )</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Real s/d des {{$beforeYear}}</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Rencana {{$year}} ( Ton )</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Posisi</th>
                                <th colspan="12" class="border border-gray-400 p-2">Tahun {{request('year') ?? ''}}</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Realisasi {{$year}} ( Ton )</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Deviasi {{$year}} ( Ton )</th>
                                <th rowspan="2" class="border border-gray-400 p-2">Deviasi Kontrak {{$year}} ( Ton )</th>
                            </tr>
                            <tr>
                                <th class="border border-gray-400 p-2">Januari</th>
                                <th class="border border-gray-400 p-2">Febuari</th>
                                <th class="border border-gray-400 p-2">Maret</th>
                                <th class="border border-gray-400 p-2">April</th>
                                <th class="border border-gray-400 p-2">Mei</th>
                                <th class="border border-gray-400 p-2">Juni</th>
                                <th class="border border-gray-400 p-2">Juli</th>
                                <th class="border border-gray-400 p-2">Agustus</th>
                                <th class="border border-gray-400 p-2">September</th>
                                <th class="border border-gray-400 p-2">Oktober</th>
                                <th class="border border-gray-400 p-2">November</th>
                                <th class="border border-gray-400 p-2">Desember</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($contracts as $contract)
                                <tr>
                                    <td class="border border-gray-400 p-2" rowspan="2">{{$loop->iteration}}</td>
                                    <td class="border border-gray-400 p-2" rowspan="2">{{$contract->name}}</td>
                                    <td class="border border-gray-400 p-2" rowspan="2">{{$contract->contract_number}}</td>
                                    <td class="border border-gray-400 p-2" rowspan="2">{{number_format($contract->total_volume)}}</td>
                                    <td class="border border-gray-400 p-2" rowspan="2">{{number_format($contract->counting)}}</td>
                                    <td class="border border-gray-400 p-2" rowspan="2">{{number_format($contract->plan)}}</td>
                                    <td class="border border-gray-400 p-2">K</td>
                                    @foreach ($contract->data['k'] as $k)
                                    <td class="border border-gray-400 p-2">{{number_format($k)}}</td>
                                    @endforeach
                                    
                                    <td class="border border-gray-400 p-2" rowspan="2">{{number_format($contract->realization)}}</td>
                                    <td class="border border-gray-400 p-2" rowspan="2">{{number_format($contract->deviasi)}}</td>
                                    <td class="border border-gray-400 p-2" rowspan="2">{{number_format($contract->deviasi_contract)}}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 p-2">R</td>
                                    @foreach ($contract->data['r'] as $r)
                                    <td class="border border-gray-400 p-2">{{number_format($r)}}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

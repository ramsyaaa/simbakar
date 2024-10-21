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
                    <div class="mb-4">
                        <label for="month" class="font-bold text-[#232D42] text-[16px]">Tanggal</label>
                        <div class="relative">
                            <input required type="month" name="month" value="{{ $month }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                        </div>
                    </div>

                    <div class="w-full flex justify-end gap-4">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button type="button" class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="ExportToExcel('xlsx')">Download</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                        <a href="{{route('reports.unloading.index')}}" class="bg-pink-900 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
                    </div>
                </form>
            </div>
            @isset($bbm_receipts)

            <div id="my-pdf">

                <div class="bg-white rounded-lg p-6 body">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <img src="{{asset('logo.png')}}" alt="" width="200">
                            <p class="text-right">UBP SURALAYA</p>
                        </div>
                        <div class="text-center text-[20px] font-bold">
                            <p>Rekapitulasi Bahan Bakar Solar dengan mobil</p>
                            <p>Bulan {{date('F Y', strtotime($month))}}</p>
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-max" id="table">
                            <thead>
                                <tr>
                                    <th class="border border-gray-400 p-2" rowspan="2">No</th>
                                    <th class="border border-gray-400 p-2" rowspan="2">Tanggal Penerimaan</th>
                                    <th class="border border-gray-400 p-2" rowspan="2">No Polisi</th>
                                    <th class="border border-gray-400 p-2" rowspan="2">No Faktur</th>
                                    <th class="border border-gray-400 p-2" colspan="2">Volume</th>
                                </tr>
                                <tr>
                                    <th class="border border-gray-400 p-2">Volume Faktur (Liter)</th>
                                    <th class="border border-gray-400 p-2">Terima TUG3 (Liter)</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bbm_receipts as $item)
                                    <tr>
                                        <td class="border border-gray-400 p-2">{{$loop->iteration}}</td>
                                        <td class="border border-gray-400 p-2">{{\Carbon\Carbon::parse($item->date_receipt)->format('d-m-Y')}}</td>
                                        <td class="border border-gray-400 p-2">{{$item->police_number}}</td>
                                        <td class="border border-gray-400 p-2">{{$item->faktur_number}}</td>
                                        <td class="border border-gray-400 p-2">{{number_format($item->faktur_obs)}}</td>
                                        <td class="border border-gray-400 p-2">{{number_format($item->amount_receipt)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        </div>
                    </div>
                </div>
            </div>
            @endisset
    </div>
</div>
@endsection
@section('scripts')

@endsection

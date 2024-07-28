@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        Analisa Kualitas
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{route('coals.receipts.index')}}" class="cursor-pointer">Penerimaan Batu Bara</a>/ <span class="text-[#2E46BA] cursor-pointer">Analisa Kualitas</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 h-full">
              <div class="desc border border-slate-300  rounded shadow w-full lg:w-1/2 p-5 mb-4">
                <span> Kapal : {{$receipt->ship->name}}</span> <br/>
                <span> Tanggal Bongkar  : {{$receipt->unloading_date}}</span><br/>
                <span> BL(Kg) : {{number_format($receipt->bl)}}</span>
              </div>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Nomor Analisa</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Detail</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">Loading Port : {{ $receipt->loading->analysis_number ?? ''}}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">
                                    @if ($receipt->loading)
                                        <div class="lg:flex gap-3">
                                            <a href="#" class="text-sky-700 hover:text-sky-800">[ Detail ]</a>
                                            <a href="#" class="text-sky-700 hover:text-sky-800">[ Hasil Perbandingan Kontrak ]</a>
                                        </div>
                                    @else
                                        <span class="text-red-700"> Belum Ada</span>
                                    @endif
                                </td>
                                <td class="h-[108px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    @if ($receipt->loading)
                                        <a href="{{ route('inputs.analysis.loadings.edit', ['id' => $receipt->loading->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                            Edit
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">Unloading Port : {{ $receipt->unloading->analysis_number ?? '' }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">
                                    @if ($receipt->unloading)
                                        <div class="lg:flex gap-3">
                                            <a href="#" class="text-sky-700 hover:text-sky-800">[ Detail ]</a>
                                            <a href="#" class="text-sky-700 hover:text-sky-800">[ Hasil Perbandingan Kontrak ]</a>
                                        </div>
                                    @else
                                        <span class="text-red-700"> Belum Ada</span>
                                    @endif
                                </td>
                                <td class="h-[108px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    @if ($receipt->unloading)
                                        <a href="{{ route('inputs.analysis.loadings.edit', ['id' => $receipt->unloading->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                            Edit
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">Labor Port : {{ $receipt->labor->analysis_number ?? '' }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">
                                    @if ($receipt->labor)
                                        <div class="lg:flex gap-3">
                                            <a href="#" class="text-sky-700 hover:text-sky-800">[ Detail ]</a>
                                            <a href="#" class="text-sky-700 hover:text-sky-800">[ Hasil Perbandingan Kontrak ]</a>
                                        </div>
                                    @else
                                        <span class="text-red-700"> Belum Ada</span>
                                    @endif
                                </td>
                                <td class="h-[108px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    @if ($receipt->labor)
                                        <a href="{{ route('inputs.analysis.labors.edit', ['id' => $receipt->labor->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                            Edit
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

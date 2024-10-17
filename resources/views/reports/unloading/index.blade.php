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
                        Monitoring & Laporan
                    </div>
                    <div class="text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Laporan</span> / <span class="text-[#2E46BA] cursor-pointer">Pembongkaran</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full max-w-[600px] flex flex-col gap-4 my-4 mt-4 px-8">
            @php
                $dataReport = [
                    ['text' => 'Realisasi Pembongkaran Batubara','url' => '#'],
                    ['text' => 'Rekapitulasi Pembongkaran HSD dengan Mobil Tangki - Bulanan','url' => '#'],
                    ['text' => 'Kegiatan Operasional DUKS','url' => route('reports.unloading.operational-duks')],
                    // ['text' => 'Rekapitulasi Jasa Tambat Dermaga PLTU Suralaya','url' => '#'],
                    // ['text' => 'Rincian Jasa Tambat','url' => '#'],
                    // ['text' => 'Rincian Jasa Dermaga','url' => '#'],
                    // ['text' => 'Rekap Jasa Tambat dan Dermaga','url' => '#'],
                    // ['text' => 'Rekap Tagihan Jasa Dermaga','url' => '#'],
                    ['text' => 'Data Gangguan','url' => route('reports.unloading.disruption-data')],
                    // ['text' => 'Rekap Pemakaian Listrik FDE','url' => '#'],
                    // ['text' => 'Tagihan Pemakaian Ship Unloader (SU)','url' => '#'],
                ]
            @endphp
            @foreach ($dataReport as $index => $report)
                <a href="{{ $report['url'] }}" class="px-3 font-bold rounded-lg text-white py-2 bg-[#035B71] hover:scale-110 duration-500 w-full">
                    {{ $report['text'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection

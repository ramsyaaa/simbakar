@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen min-h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        Monitoring & Laporan
                    </div>
                    <div class="text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Laporan</span> / <span class="text-[#2E46BA] cursor-pointer">Kontrak</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full flex flex-col gap-4 my-4 mt-4 px-8">
            @php
                $dataReport = [
                    ['text' => 'Rencana Realisasi Kontrak (Panjang, Menengah, Spot) - Bulanan','url' => '#'],
                    ['text' => 'Rencana Realisasi Kontrak Spot Bulanan (awal s/d selesai kontrak)','url' => '#'],
                    ['text' => 'Rencana Realisasi Semua Kontrak - Tahunan','url' => '#'],
                    ['text' => 'Monitoring Kontrak Batubara s.d Tahun Tertentu','url' => '#'],
                    ['text' => 'Evaluasi Kualitas Pre-Loading, Loading, Un-Loading Batubara thd. Kontrak','url' => '#'],
                    ['text' => 'Rekap Realisasi Kontrak Batubara per Pemasok','url' => '#'],
                    ['text' => 'Penerimaan, Pemakaian dan Persediaan Efektif MFO','url' => '#'],
                    ['text' => 'Rekapitulasi Penerimaan Batubara','url' => '#'],
                ]
            @endphp
            @foreach ($dataReport as $index => $report)
                <a href="{{ $report['url'] }}" class="px-3 font-bold rounded-lg underline w-fit">
                    {{ $index+1 }}. {{ $report['text'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection

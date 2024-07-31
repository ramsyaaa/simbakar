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
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Laporan</span> / <span class="text-[#2E46BA] cursor-pointer">Executive Summary</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full flex flex-col gap-4 my-4 mt-4 px-8">
            @php
                $dataReport = [
                    ['text' => 'Rencana Realisasi Kontrak Batubara Bulanan','url' => '#'],
                    ['text' => 'Perbandingan Spesifikasi Kontrak Pemasok dengan Design Boiler','url' => '#'],
                    ['text' => 'Rencana Realisasi Pemakaian Batubara & Produksi Listrik Bulanan','url' => '#'],
                    ['text' => 'Realisasi Persediaan Kumulatif Batubara','url' => '#'],
                    ['text' => 'Realisasi Penerimaan, Pemakaian dan Persediaan Efektif Batubara','url' => '#'],
                    ['text' => 'Penerimaan, Pemakaian dan Oersediaan Efektif HSD','url' => '#'],
                    ['text' => 'Penerimaan, Pemakaian dan Persediaan Efektif MFO','url' => '#'],
                    ['text' => 'Pemakaian HSD Unit Bulanan','url' => '#'],
                    ['text' => 'Pemakaian dan Biaya HSD Albes Bulanan','url' => '#'],
                    ['text' => 'Perbandingan Analisa Kualitas per Pemasok (Loading, Unloading, dan Labor)','url' => '#'],
                    ['text' => 'Perbandingan Analisa Kualitas per Waktu (Loading, Unloading, dan Labor)','url' => '#'],
                    ['text' => 'Perbandingan Penerimaan Batubara Bulanan (B/L, D/S, B/W, TUG, 3)','url' => '#'],
                    ['text' => 'Realisasi Pembongkaran Batubara Bulanan','url' => '#'],
                    ['text' => 'Rencana dan Realisasi Pengapalan','url' => '#'],
                    ['text' => 'Losses Batubara per Tahun','url' => '#'],
                    ['text' => 'Rekapitulasi Losses Batubara','url' => '#'],
                    ['text' => 'Jasa Tambat Bulanan','url' => '#'],
                    ['text' => 'Jasa Dermaga Bulanan','url' => '#'],
                    ['text' => 'Jasa Bongkar Bulanan','url' => '#'],

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

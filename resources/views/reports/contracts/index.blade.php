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
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Laporan</span> / <span class="text-[#2E46BA] cursor-pointer">Kontrak</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full max-w-[600px] flex flex-col gap-4 my-4 mt-4 px-8">
            @php
                $dataReport = [
                    ['text' => 'Rencana Realisasi Kontrak (Panjang, Menengah, Spot) - Bulanan','url' => route('reports.contracts.coal-monthly')],
                    ['text' => 'Rencana Realisasi Kontrak Spot Bulanan (awal s/d selesai kontrak)','url' => route('reports.contracts.coal-monthly-spot')],
                    ['text' => 'Rencana Realisasi Semua Kontrak - Tahunan','url' => route('reports.contracts.coal-all')],
                    ['text' => 'Monitoring Kontrak Batubara s.d Tahun Tertentu','url' => route('reports.contracts.coal-monitoring')],
                    ['text' => 'Evaluasi Kualitas Pre-Loading, Loading, Un-Loading Batubara thd. Kontrak','url' => route('reports.contracts.coal-evaluation')],
                    ['text' => 'Rekap Realisasi Kontrak Batubara per Pemasok','url' => route('reports.contracts.coal-recapitulation')],
                    ['text' => 'Rekapitulasi Penerimaan Batubara','url' => route('reports.contracts.coal-receipt')],
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

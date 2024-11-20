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
                        List Pemesanan BBM
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Pemesanan BBM</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('contracts.bbm-book-contracts.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('contracts.bbm-book-contracts.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <div class="w-full mb-2 lg:mb-0">
                            <label for="date">Pemesanan bulan dan tahun</label>
                            <input id="date" type="month" name="date" class="w-[350px] h-[44px] rounded-md border px-2" autofocus value="{{request()->date ?? ''}}">
                        </div>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Tanggal Pemesanan</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Nomor Pemesanan</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Jumlah ( L )</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Armada Pengangkut</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bbms as $bbm)
                            <tr>
                                {{-- @if($bbm->fleet_type == 'Mobil') @dd($bbm) @endif --}}
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ date('d-m-Y', strtotime($bbm->order_date)) }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $bbm->order_number }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format($bbm->total, 0, '.', ',') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $bbm->fleet_type }} : @if($bbm->ship != null){{$bbm->ship->name ?? ''}} @elseif($bbm->type_ship != null) {{ $bbm->type_ship->name }} @endif</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('contracts.bbm-book-contracts.edit', ['uuid' => $bbm->uuid]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('contracts.bbm-book-contracts.destroy', ['uuid' => $bbm->uuid]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="bg-[#C03221] text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $bbms->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

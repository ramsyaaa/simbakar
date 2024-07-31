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
                        List Transfer BBM
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Transfer BBM</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('contracts.bbm-transfers.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('contracts.bbm-transfers.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <div class="w-full mb-2 lg:mb-0">
                            <label for="date">Tranfer BBM bulan dan tahun</label>
                            <input id="date" type="month" name="date" class="w-[350px] h-[44px] rounded-md border px-2" autofocus value="{{request()->date ?? ''}}">
                        </div>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Tanggal Transfer</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Jenis Bbm</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Volume</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Nomor Berita Acara</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Sumber</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Tujuan</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bbms as $bbm)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $bbm->transfer_date}}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $bbm->kind_bbm}}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $bbm->volume}}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $bbm->ba_number }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    <span> Bunker Sumber : {{$bbm->bunkerSource->name ?? ''}}</span><br>
                                    <span> Level Awal : {{$bbm->start_level_source ?? ''}}</span><br>
                                    <span> Level Akhir : {{$bbm->end_level_source ?? ''}}</span><br>
                                    <span> Sounding Awal : {{$bbm->start_sounding_source ?? ''}}</span><br>
                                    <span> Sounding Akhir : {{$bbm->end_sounding_source ?? ''}}</span>
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    <span> Bunker Tujuan : {{$bbm->bunkerDestination->name ?? ''}}</span><br>
                                    <span> Level Awal : {{$bbm->start_level_destination ?? ''}}</span><br>
                                    <span> Level Akhir : {{$bbm->end_level_destination ?? ''}}</span><br>
                                    <span> Sounding Awal : {{$bbm->start_sounding_destination ?? ''}}</span><br>
                                    <span> Sounding Akhir : {{$bbm->end_sounding_destination ?? ''}}</span>
                                </td>
                                <td class="h-[150px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('contracts.bbm-transfers.edit', ['id' => $bbm->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('contracts.bbm-transfers.destroy', ['id' => $bbm->id]) }}" method="POST">
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

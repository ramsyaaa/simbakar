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
                        List Kapal
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Kapal</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('master-data.ships.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                    <a href="{{ route('master-data.ships.type-ship.index') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#135F9C] rounded-md text-[12px] lg:text-[19px] text-center">
                        Jenis Kapal
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('master-data.ships.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <div class="w-full mb-2 lg:mb-0">
                            <input name="find" type="text" value="{{ $find }}" class="w-full h-[44px] rounded-md border px-2" placeholder="Cari Data" autofocus>
                        </div>
                        <div class="mb-2 lg:mb-0">
                            <select name="type_ship" id="" class="w-full lg:w-[200px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Jenis Kapal</option>
                                @foreach ($type_ships as $type_ship)
                                <option @if($type_ship->uuid == $type_ship_uuid) selected @endif value="{{ $type_ship->uuid }}">{{ $type_ship->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2 lg:mb-0">
                            <select name="load_type" id="" class="w-full lg:w-[200px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Jenis Muatan</option>
                                @foreach ($load_types as $load_type)
                                <option @if($load_type->uuid == $load_type_uuid) selected @endif value="{{ $load_type->uuid }}">{{ $load_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Nama</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Jenis Kapal</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Benndera</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Jenis Muatan</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Identitas</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ships as $ship)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $ship->name }} @if($ship->acronym != null) ({{ $ship->acronym }}) @endif <br> Tahun Pembuatan : {{ $ship->year_created }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $ship->typeShip->name }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $ship->flag }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $ship->loadType->name }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">GRT : {{ $ship->grt }} <br>DWT : {{ $ship->dwt }} <br>LOA : {{ $ship->loa }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('master-data.ships.edit', ['uuid' => $ship->uuid]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('master-data.ships.destroy', ['uuid' => $ship->uuid]) }}" method="POST">
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
                    {{ $ships->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

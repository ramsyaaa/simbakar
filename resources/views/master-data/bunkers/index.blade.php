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
                        List Bunker
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Bunker</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('master-data.bunkers.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('master-data.bunkers.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <div class="w-full mb-2 lg:mb-0">
                            <input name="find" type="text" value="{{ $find }}" class="w-full h-[44px] rounded-md border px-2" placeholder="Cari Data" autofocus>
                        </div>
                        <div class="mb-2 lg:mb-0">
                            <select name="bunker_type" id="" class="w-full lg:w-[200px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Jenis Bunker</option>
                                <option value="hsd-solar">HSD/Solar</option>
                                <option value="mfo-residu">MFO/Residu</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Nama</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Kapasitas (Liter)</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Bunker Jenis Bahan Bakar</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bunkers as $bunker)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $bunker->name }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $bunker->capacity }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ ($bunker->bunker_type == 'hsd-solar' ? 'HSD/Solar' : "") }} {{ ($bunker->bunker_type == 'mfo-residu' ? 'MFO/Residu' : '') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('master-data.bunkers.soundings.index', ['bunker_uuid' => $bunker->uuid]) }}" class="bg-[#FFF212] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Lihat
                                    </a>
                                    <a href="{{ route('master-data.bunkers.edit', ['uuid' => $bunker->uuid]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('master-data.bunkers.destroy', ['uuid' => $bunker->uuid]) }}" method="POST">
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
                    {{ $bunkers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

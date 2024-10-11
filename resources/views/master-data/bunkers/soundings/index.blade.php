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
                        List Data {{ $bunker_name }}
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('master-data.bunkers.index') }}" class="cursor-pointer">Bunker</a> / <span class="text-[#2E46BA] cursor-pointer">Sounding</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('master-data.bunkers.soundings.create', ['bunker_uuid' => $bunker_uuid]) }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Meter</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Centimeter</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Milimeter</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Volume (Liter)</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($soundings as $sounding)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $sounding->meter }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $sounding->centimeter }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $sounding->milimeter }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $sounding->volume }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('master-data.bunkers.soundings.edit', ['bunker_uuid' => $bunker_uuid, 'uuid' => $sounding->uuid]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('master-data.bunkers.soundings.destroy', ['bunker_uuid' => $bunker_uuid, 'uuid' => $sounding->uuid]) }}" method="POST">
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
                    {{ $soundings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

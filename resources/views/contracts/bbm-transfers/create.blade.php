@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen h-screen flex bg-[#E9ECEF] overflow-auto hide-scrollbar">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        Tambah Transfer BBM 
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('contracts.bbm-transfers.index') }}" class="cursor-pointer">Transfer BBM </a>  / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Transfer BBM ?')" action="{{ route('contracts.bbm-transfers.store') }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="w-full">
                            <div class="w-full">
                                <label for="kind_bbm" class="font-bold text-[#232D42] text-[16px]">Jenis BBM</label>
                                <div class="relative">
                                    <select name="kind_bbm" id="kind_bbm" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option value="">Pilih</option>
                                        <option value="solar" {{ old('kind_bbm') == "solar" ? 'selected' : '' }}>Solar / HSD</option>
                                        <option value="residu" {{ old('kind_bbm') == 'residu' ? 'selected' : '' }}> Residu</option>
                                    </select>
                                    @error('kind_bbm')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex gap-4">
                            <div class="source">
                                <div class="w-full">
                                    <label for="bunker_source_id" class="font-bold text-[#232D42] text-[16px]">Bunker Sumber</label>
                                    <div class="relative">
                                        <select id="bunker_source_id" name="bunker_source_id" class="w-full lg:w-96 h-[44px] rounded-md border px-2">
                                            <option selected disabled>Pilih Bunker</option>
                                            @foreach ($bunkers as $bunker)
                                            <option value="{{$bunker->id}}">{{$bunker->name}}</option>
                                            @endforeach
                                        </select> 
                                        @error('bunker_source_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="start_level_source" class="font-bold text-[#232D42] text-[16px]">Level Awal</label>
                                    <div class="relative">
                                        <input type="number" name="start_level_source" value="{{ old('start_level_source') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('start_level_source')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="end_level_source" class="font-bold text-[#232D42] text-[16px]">Level Akhir</label>
                                    <div class="relative">
                                        <input type="number" name="end_level_source" value="{{ old('end_level_source') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('end_level_source')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="start_sounding_source" class="font-bold text-[#232D42] text-[16px]">Sounding Awal</label>
                                    <div class="relative">
                                        <input type="number" name="start_sounding_source" value="{{ old('start_sounding_source') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('start_sounding_source')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="end_sounding_source" class="font-bold text-[#232D42] text-[16px]">Sounding Akhir</label>
                                    <div class="relative">
                                        <input type="number" name="end_sounding_source" value="{{ old('end_sounding_source') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('end_sounding_source')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                                <div class="destination">
                                    <div class="w-full">
                                        <label for="bunker_destination_id" class="font-bold text-[#232D42] text-[16px]">Bunker Sumber</label>
                                        <div class="relative">
                                            <select id="bunker_destination_id" name="bunker_destination_id" class="w-96 h-[44px] rounded-md border px-2">
                                                <option selected disabled>Pilih Bunker</option>
                                                @foreach ($bunkers as $bunker)
                                                <option value="{{$bunker->id}}">{{$bunker->name}}</option>
                                                @endforeach
                                            </select> 
                                            @error('bunker_destination_id')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="start_level_destination" class="font-bold text-[#232D42] text-[16px]">Level Awal</label>
                                        <div class="relative">
                                            <input type="number" name="start_level_destination" value="{{ old('start_level_destination') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('start_level_destination')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="end_level_destination" class="font-bold text-[#232D42] text-[16px]">Level Akhir</label>
                                        <div class="relative">
                                            <input type="number" name="end_level_destination" value="{{ old('end_level_destination') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('end_level_destination')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="start_sounding_destination" class="font-bold text-[#232D42] text-[16px]">Sounding Awal</label>
                                        <div class="relative">
                                            <input type="number" name="start_sounding_destination" value="{{ old('start_sounding_destination') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('start_sounding_destination')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="end_sounding_destination" class="font-bold text-[#232D42] text-[16px]">Sounding Akhir</label>
                                        <div class="relative">
                                            <input type="number" name="end_sounding_destination" value="{{ old('end_sounding_destination') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('end_sounding_destination')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="ba_number" class="font-bold text-[#232D42] text-[16px]">Nomor Berita Acara</label>
                                    <div class="relative">
                                        <input type="number" name="ba_number" value="{{ old('ba_number') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('ba_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="transfer_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Transfer</label>
                                    <div class="relative">
                                        <input type="date" name="transfer_date" value="{{ old('transfer_date') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('transfer_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="volume" class="font-bold text-[#232D42] text-[16px]">Volume</label>
                                    <div class="relative">
                                        <select name="volume" id="volume" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option value="">Pilih</option>
                                            <option>1. Selisih Level Bunker Sumber</option>
                                        </select>
                                        @error('volume')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                        <a href="{{ route('contracts.bbm-transfers.index') }}" class="bg-[#C03221] w-full lg:w-96 py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah Transfer BBM </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

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
                        Edit Kapal
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('master-data.ships.index') }}" class="cursor-pointer">Kapal</a> / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Update Kapal?')" action="{{ route('master-data.ships.update', ['uuid' => $ship->uuid]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="name" class="font-bold text-[#232D42] text-[16px]">Nama Kapal</label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') ? old('name') : $ship->name }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('name')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="type_ship_uuid" class="font-bold text-[#232D42] text-[16px]">Jenis Kapal</label>
                                <div class="relative">
                                    <select name="type_ship_uuid" id="type_ship_uuid" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option value="">Jenis Kapal</option>
                                        @foreach ($type_ships as $type_ship)
                                            <option @if($ship->type_ship_uuid == $type_ship->uuid) selected @endif value="{{ $type_ship->uuid }}">{{ $type_ship->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('type_ship_uuid')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="year_created" class="font-bold text-[#232D42] text-[16px]">Tahun Pembuatan</label>
                                <div class="relative">
                                    <input type="number" placeholder="YYYY" min="1900" max="{{ date('Y') }}" name="year_created" value="{{ old('year_created') ? old('year_created') : $ship->year_created }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('year_created')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="load_type_uuid" class="font-bold text-[#232D42] text-[16px]">Jenis Muatan</label>
                                <div class="relative">
                                    <select name="load_type_uuid" id="load_type_uuid" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option value="">Jenis Muatan</option>
                                        @foreach ($load_types as $load_type)
                                            <option @if($ship->load_type_uuid == $load_type->uuid) selected @endif value="{{ $load_type->uuid }}">{{ $load_type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('load_type_uuid')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="flag" class="font-bold text-[#232D42] text-[16px]">Bendera</label>
                                <div class="relative">
                                    <input type="text" name="flag" value="{{ old('flag') ? old('flag') : $ship->flag }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('flag')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="grt" class="font-bold text-[#232D42] text-[16px]">GRT</label>
                                <div class="relative">
                                    <input type="text" name="grt" value="{{ old('grt') ? old('grt') : $ship->grt }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('grt')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full px-4">
                                <label for="dwt" class="font-bold text-[#232D42] text-[16px]">DWT</label>
                                <div class="relative">
                                    <input type="text" name="dwt" value="{{ old('dwt') ? old('dwt') : $ship->dwt }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('dwt')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full px-4 lg:-ml-6">
                                <label for="loa" class="font-bold text-[#232D42] text-[16px]">LOA</label>
                                <div class="relative">
                                    <input type="text" name="loa" value="{{ old('loa') ? old('loa') : $ship->loa }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('loa')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full px-4">
                                <label for="acronym" class="font-bold text-[#232D42] text-[16px]">Singkatan</label>
                                <div class="relative">
                                    <input type="text" name="acronym" value="{{ old('acronym') ? old('acronym') : $ship->acronym }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('acronym')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <a href="{{route('master-data.ships.index')}}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Update Kapal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

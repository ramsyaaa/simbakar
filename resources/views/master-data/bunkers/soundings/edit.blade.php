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
                        Edit Sounding
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('master-data.bunkers.index') }}" class="cursor-pointer">Bunker</a> / <a href="{{ route('master-data.bunkers.soundings.index', ['bunker_uuid' => $bunker_uuid]) }}" class="cursor-pointer">Sounding</a> / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Update Sounding?')" action="{{ route('master-data.bunkers.soundings.update', ['bunker_uuid' => $bunker_uuid, 'uuid' =>$sounding->uuid]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="meter" class="font-bold text-[#232D42] text-[16px]">Meter</label>
                                <div class="relative">
                                    <input type="text" name="meter" value="{{ old('meter') ? old('meter') : $sounding->meter }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('meter')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="centimeter" class="font-bold text-[#232D42] text-[16px]">Centimeter</label>
                                <div class="relative">
                                    <input type="text" name="centimeter" value="{{ old('centimeter') ? old('centimeter') : $sounding->centimeter }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('centimeter')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="milimeter" class="font-bold text-[#232D42] text-[16px]">Milimeter</label>
                                <div class="relative">
                                    <input type="text" name="milimeter" value="{{ old('milimeter') ? old('milimeter') : $sounding->milimeter }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('milimeter')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="volume" class="font-bold text-[#232D42] text-[16px]">Volume (Liter)</label>
                                <div class="relative">
                                    <input type="text" name="volume" value="{{ old('volume') ? old('volume') : $sounding->volume }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('volume')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{route('master-data.bunkers.soundings.index', ['bunker_uuid', $bunker_uuid])}}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Update Sounding</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

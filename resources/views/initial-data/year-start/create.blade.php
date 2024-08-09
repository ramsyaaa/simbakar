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
                        Tambah Data Awal Tahun
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('initial-data.year-start.index') }}" class="cursor-pointer">Data Awal Tahun</a> / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambah Data Awal Tahun?')" action="{{ route('initial-data.year-start.store') }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between gap-3">
                            <div class="w-full">
                                <label for="year" class="font-bold text-[#232D42] text-[16px]">Tahun</label>
                                <div class="relative">
                                    <input required type="number" name="year" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('year')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="type" class="font-bold text-[#232D42] text-[16px]">Jenis</label>
                                <div class="relative">
                                    <select name="type" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option value="batubara">Batubara</option>
                                        <option value="solar">Solar / HSD</option>
                                        <option value="residu">Residu / MFO</option>
                                    </select>
                                    @error('type')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="planning" class="font-bold text-[#232D42] text-[16px]">Rencana Persediaan Awal </label>
                                <div class="relative">
                                    <input type="text" name="planning" value="{{ old('planning') }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('planning')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="actual" class="font-bold text-[#232D42] text-[16px]">Realisasi Persediaan Awal </label>
                                <div class="relative">
                                    <input type="text" name="actual" value="{{ old('actual') }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('actual')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{route('initial-data.year-start.index')}}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

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
                        Tambah BA Dibeli Perusahaan Lain
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('coals.usages.adjusment-outcomes.index') }}" class="cursor-pointer">Dibeli Perusahaan Lain</a> / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan BA Dibeli Perusahaan Lain ?')" action="{{ route('coals.usages.adjusment-outcomes.store') }}" method="POST">
                    @csrf
                        <div class="unloadings">
                            <div class="p-4 bg-white rounded-lg w-full">
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="type_fuel" class="font-bold text-[#232D42] text-[16px]">Tanggal Pakai</label>
                                        <div class="relative">
                                            <input type="hidden" name="type_adjusment" value="outcome">
                                            <select id="type_fuel" name="type_fuel" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" autofocus>
                                                <option selected disabled>Jenis Bahan Bakar</option>
                                                <option value="batubara"> Batu Bara</option>
                                                <option value="solar"> HSD / Solar</option>
                                                <option value="residu"> MFO / Residu</option>
                                            </select>
                                            @error('type_fuel')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <label for="usage_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Pakai</label>
                                        <div class="relative">
                                            <input required type="date" name="usage_date" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('usage_date')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="usage_amount" class="font-bold text-[#232D42] text-[16px]">Jumlah Pakai</label>
                                        <div class="relative">
                                            <input required type="number" name="usage_amount" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('usage_amount')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="ba_number" class="font-bold text-[#232D42] text-[16px]">No Berita Acara</label>
                                        <div class="relative">
                                            <input required type="text" name="ba_number" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('ba_number')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="note" class="font-bold text-[#232D42] text-[16px]">Keterangan</label>
                                    <div class="relative">
                                        <input required type="text" name="note" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('note')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="tug_in_date" class="font-bold text-[#232D42] text-[16px]">Akan dimasukan pada TUG 1 dan 2</label>
                                    <div class="relative">
                                        <input required type="date" name="tug_in_date" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3"><br>
                                        <small class="text-slate-700">untuk sementara kolom bulan dan tahun tidak berpengaruh terhadap laporan</small>
                                        @error('tug_in_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                            <div class="flex gap-3">

                            <a href="{{route('coals.usages.adjusment-outcomes.index')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                            <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

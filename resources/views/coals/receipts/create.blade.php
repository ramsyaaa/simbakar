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
                        Tambah Pembongkaran Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('coals.unloadings.index') }}" class="cursor-pointer">Pembongkaran Batu Baras</a> / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Pembongkaran Batu Bara ?')" action="{{ route('coals.unloadings.store') }}" method="POST">
                    @csrf
                    <div class="lg:flex ">
                        <div class="unloadings">
                            <div class="p-4 bg-white rounded-lg w-full">
                                <div class="w-full">
                                    <label for="analysis_loading_id" class="font-bold text-[#232D42] text-[16px]">Analisis Loading</label>
                                    <div class="relative">
                                        <select name="analysis_loading_id" id="analysis_loading_id" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Analisis Loading</option>
                                            <option value="1">1</option>
                                        </select>
                                        @error('analysis_loading_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="load_company_id" class="font-bold text-[#232D42] text-[16px]">Nama PBM</label>
                                    <div class="relative">
                                        <select name="load_company_id" id="load_company_id" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Nama PBM</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('load_company_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="supplier_id" class="font-bold text-[#232D42] text-[16px]">Pemasok</label>
                                    <div class="relative">
                                        <select name="supplier_id" id="supplier_id" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Pemasok</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="dock_id" class="font-bold text-[#232D42] text-[16px]">Dermaga</label>
                                    <div class="relative">
                                        <select name="dock_id" id="dock_id" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Dermaga</option>
                                            @foreach ($docks as $dock)
                                                <option value="{{ $dock->id }}">{{ $dock->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('dock_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="ship_id" class="font-bold text-[#232D42] text-[16px]">Kapal</label>
                                    <div class="relative">
                                        <select name="ship_id" id="ship_id" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Kapal</option>
                                            @foreach ($ships as $ship)
                                                <option value="{{ $ship->id }}">{{ $ship->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('ship_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="bl" class="font-bold text-[#232D42] text-[16px]">BL</label>
                                    <div class="relative">
                                        <input required type="number" name="bl" value="{{ old('bl') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('bl')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="unloadings p-4">
                            <div class="w-full">
                                <label for="loading_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Loading</label>
                                <div class="relative">
                                    <input required type="datetime-local" name="loading_date" value="{{ old('loading_date') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('loading_date')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="arrived_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Tiba</label>
                                <div class="relative">
                                    <input required type="datetime-local" name="arrived_date" value="{{ old('arrived_date') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('arrived_date')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="dock_ship_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Sandar</label>
                                <div class="relative">
                                    <input required type="datetime-local" name="dock_ship_date" value="{{ old('dock_ship_date') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('dock_ship_date')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="unloading_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Pembongkaran</label>
                                <div class="relative">
                                    <input required type="datetime-local" name="unloading_date" value="{{ old('unloading_date') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('unloading_date')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="end_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Selesai</label>
                                <div class="relative">
                                    <input required type="datetime-local" name="end_date" value="{{ old('end_date') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('end_date')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="departure_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Berangkat</label>
                                <div class="relative">
                                    <input required type="datetime-local" name="departure_date" value="{{ old('departure_date') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('departure_date')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full py-1">
                                <label for="note" class="font-bold text-[#232D42] text-[16px]">Catatan</label>
                                <div class="relative">
                                    <textarea name="note" id="" cols="30" rows="3" class="w-full lg:w-96 border rounded-md mt-3 mb-5 px-3">

                                    </textarea>
                                    @error('note')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="flex gap-3">

                            <a href="{{session('back_url')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                            <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

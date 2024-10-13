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
                        Edit Pemasok
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('master-data.suppliers.index') }}" class="cursor-pointer">Pemasok</a>  / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Update Pemasok?')" action="{{ route('master-data.suppliers.update', ['uuid' => $supplier->uuid]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="name" class="font-bold text-[#232D42] text-[16px]">Nama Pemasok</label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') ? old('name') : $supplier->name }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('name')
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
                                            <option @if($supplier->load_type_uuid == $load_type->uuid) selected @endif value="{{ $load_type->uuid }}">{{ $load_type->name }}</option>
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
                                <label for="phone" class="font-bold text-[#232D42] text-[16px]">Telp</label>
                                <div class="relative">
                                    <input type="text" name="phone" value="{{ old('phone') ? old('phone') : $supplier->phone }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('phone')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="fax" class="font-bold text-[#232D42] text-[16px]">Fax</label>
                                <div class="relative">
                                    <input type="text" name="fax" value="{{ old('fax') ? old('fax') : $supplier->fax }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('fax')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="address" class="font-bold text-[#232D42] text-[16px]">Alamat</label>
                                <div class="relative">
                                    <textarea name="address" value="{{ old('address') }}" style="height:150px" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">{{ old('address') ? old('address') : $supplier->address }}</textarea>
                                    @error('address')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="bg_color" class="font-bold text-[#232D42] text-[16px]">Background warna (untuk jadwal, ex: #ffffff)</label>
                                <div class="relative">
                                    <input type="text" name="bg_color" value="{{ old('bg_color') ? old('bg_color') : $supplier->bg_color }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('bg_color')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="mining_authorization" class="font-bold text-[#232D42] text-[16px]">Kuasa Pertambangan</label>
                                <div class="relative">
                                    <input type="text" name="mining_authorization" value="{{ old('mining_authorization') ? old('mining_authorization') : $supplier->mining_authorization }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('mining_authorization')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="mine_name" class="font-bold text-[#232D42] text-[16px]">Nama Tambang</label>
                                <div class="relative">
                                    <input type="text" name="mine_name" value="{{ old('mine_name') ? old('mine_name') : $supplier->mine_name }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('mine_name')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="mine_location" class="font-bold text-[#232D42] text-[16px]">Lokasi Pertambangan</label>
                                <div class="relative">
                                    <input type="text" name="mine_location" value="{{ old('mine_location') ? old('mine_location') : $supplier->mine_location }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('mine_location')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="producer" class="font-bold text-[#232D42] text-[16px]">Produsen</label>
                                <div class="relative">
                                    <input type="text" name="producer" value="{{ old('producer') ? old('producer') : $supplier->producer }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('producer')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{route('master-data.suppliers.index')}}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Update Pemasok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

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
                        Tambah Agen Kapal
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('master-data.ship-agents.index') }}" class="cursor-pointer">Agen Kapal</a>  / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Agen Kapal?')" action="{{ route('master-data.ship-agents.store') }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="name" class="font-bold text-[#232D42] text-[16px]">Nama Agen Kapal</label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
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
                                            <option value="{{ $load_type->uuid }}">{{ $load_type->name }}</option>
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
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
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
                                    <input type="text" name="fax" value="{{ old('fax') }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
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
                                    <textarea name="address" value="{{ old('address') }}" style="height:150px" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3"></textarea>
                                    @error('address')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('master-data.ship-agents.index') }}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah Agen Kapal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

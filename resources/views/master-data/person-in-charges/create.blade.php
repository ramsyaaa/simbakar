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
                        Tambah Penanggung Jawab
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('master-data.person-in-charges.index') }}" class="cursor-pointer">Penanggung Jawab</a>  / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Penanggung Jawab?')" action="{{ route('master-data.person-in-charges.store') }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="name" class="font-bold text-[#232D42] text-[16px]">Nama Penanggung Jawab</label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('name')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="structural_position" class="font-bold text-[#232D42] text-[16px]">Jabatan Struktural</label>
                                <div class="relative">
                                    <input type="text" name="structural_position" value="{{ old('structural_position') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('structural_position')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="status" class="font-bold text-[#232D42] text-[16px]">Status</label>
                                <div class="relative">
                                    <select name="status" id="status" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option value="">Pilih</option>
                                        <option value="1" {{ old('status') == "1" ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}> Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="functional_role" class="font-bold text-[#232D42] text-[16px]">Jabatan Fungsional</label>
                                <div class="relative">
                                    <input type="text" name="functional_role" value="{{ old('functional_role') }}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('functional_role')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('master-data.person-in-charges.index') }}" class="bg-[#C03221] w-full lg:w-96 py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-96 py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah Penanggung Jawab</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

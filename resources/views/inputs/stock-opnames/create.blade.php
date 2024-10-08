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
                        Tambah Stock Opname
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.stock-opnames.index') }}" class="cursor-pointer">Stock Opname</a>  / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Stock Opname?')" action="{{ route('inputs.stock-opnames.store') }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="w-full">
                            <label for="measurement_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Pengukuran</label>
                            <div class="relative">
                                <input type="date" name="measurement_date" value="{{ old('measurement_date') }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                @error('measurement_date')
                                <div class="absolute -bottom-1 left-1 text-red-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full">
                            <label for="stock_opname" class="font-bold text-[#232D42] text-[16px]">Stock Opname ( Kg )</label>
                            <div class="relative">
                                <input type="number" name="stock_opname" value="{{ old('stock_opname') }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                @error('stock_opname')
                                <div class="absolute -bottom-1 left-1 text-red-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full">
                            <label for="loose_density" class="font-bold text-[#232D42] text-[16px]">Loose Density ( Ton/M<sup>3</sup> )</label>
                            <div class="relative">
                                <input type="number" name="loose_density" value="{{ old('loose_density') }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                @error('loose_density')
                                <div class="absolute -bottom-1 left-1 text-red-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full">
                            <label for="compact_density" class="font-bold text-[#232D42] text-[16px]">Compact Density ( Ton/M<sup>3</sup> )</label>
                            <div class="relative">
                                <input type="number" name="compact_density" value="{{ old('compact_density') }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                @error('compact_density')
                                <div class="absolute -bottom-1 left-1 text-red-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="w-full">
                            <label for="bedding" class="font-bold text-[#232D42] text-[16px]">Bedding ( Ton/M<sup>3</sup> )</label>
                            <div class="relative">
                                <input type="number" name="bedding" value="{{ old('bedding') }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                @error('bedding')
                                <div class="absolute -bottom-1 left-1 text-red-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <a href="{{ route('inputs.stock-opnames.index') }}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah Stock Opname</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

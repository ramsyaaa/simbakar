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
                        Ubah Penerimaan Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('coals.unloadings.index') }}" class="cursor-pointer">Penerimaan Batu Bara</a> / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Data Analisa Kualitas</div>

                 <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex lg:gap-3">
                            <div class="w-full">
                                <label for="ds" class="font-bold text-[#232D42] text-[16px]">DS</label>
                                    <div class="relative">
                                        <input type="number" name="ds" value="{{ $receipt->bl }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('ds')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="bl" class="font-bold text-[#232D42] text-[16px]">BL</label>
                                    <div class="relative">
                                        <input type="number" name="bl" value="{{ $receipt->bl }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('bl')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="bw" class="font-bold text-[#232D42] text-[16px]">BW</label>
                                    <div class="relative">
                                        <input type="number" name="bw" value="0" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('bw')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex lg:gap-3 px-4">
                            <div class="w-full">
                                <label for="tug" class="font-bold text-[#232D42] text-[16px]">Yang diterima tug 3</label>
                                    <div class="relative">
                                        <input type="text" value="{{ number_format($receipt->bl) }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('ds')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="kind_contract" class="font-bold text-[#232D42] text-[16px]">Jenis Kontrak</label>
                                    <div class="relative">
                                        <select name="kind_contract" id="kind_contract" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Jenis Kontrak</option>
                                            <option>FOB</option>
                                            <option>CIF</option>
                                        </select>
                                        @error('kind_contract')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-6 mt-5">
                            <form action="" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Tambahan Detail TUG 3</div>
                                <div class="lg:flex lg:gap-3">
                                    <div class="w-full">
                                        <label for="tug_number" class="font-bold text-[#232D42] text-[16px]">No TUG 3</label>
                                        <div class="relative">
                                            <input type="text" name="tug_number" value="{{ $receipt->tug_number }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <label class="inline-flex items-center ps-1 -mt-3">
                                                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600">
                                                <span class="ml-2 text-gray-700 text-sm">Update No TUG 3 berdasarkan tanggal penerimaan</span>
                                            </label>
                                            @error('ds')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="receipt_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Terima</label>
                                        <div class="relative">
                                            <input type="date" name="receipt_date" value="{{ $receipt->receipt_date }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('receipt')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex lg:gap-3 mt-3">
                                    <div class="w-full">
                                        <label for="form_part_number" class="font-bold text-[#232D42] text-[16px]">No Form Part</label>
                                        <div class="relative">
                                            <select name="form_part_number" id="form_part_number" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih No Form Part</option>
                                                <option {{$receipt->form_part_number == '18.01.0009' ? 'selected' : ''}}>18.01.0009</option>
                                                <option {{$receipt->form_part_number == '18.01.0008' ? 'selected' : ''}}>18.01.0008</option>
                                            </select>
                                            @error('form_part_number')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="unit" class="font-bold text-[#232D42] text-[16px]">Satuan</label>
                                        <div class="relative">
                                            <input type="text" name="unit" value="{{ $receipt->unit }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('unit')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex lg:gap-3">
                                    <div class="w-full">
                                        <label for="user_inspection" class="font-bold text-[#232D42] text-[16px]">Pemeriksa</label>
                                        <div class="relative">
                                            <select name="user_inspection" id="user_inspection" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih Pemeriksa</option>
                                                <option value="">Test</option>
                                            </select>
                                            @error('user_inspection')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="rob" class="font-bold text-[#232D42] text-[16px]">ROB</label>
                                        <div class="relative">
                                            <input type="text" name="rob" value="{{ $receipt->rob }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('rob')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex lg:gap-3">
                                    <div class="w-full">
                                        <label for="head_warehouse" class="font-bold text-[#232D42] text-[16px]">Kepala Gudang</label>
                                        <div class="relative">
                                            <select name="head_warehouse" id="head_warehouse" class="w-full lg:w-1/2 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih Kepala Gudang</option>
                                                <option value="">Test</option>
                                            </select>
                                            @error('head_warehouse')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah data TUG 3 ( saja )</button>
                                </div>
                            </div>
                            
                        </form>
                        </div>
                        
                        <div class="flex gap-3">
                            <a href="{{route('coals.unloadings.index')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                            <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah</button>
                        </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

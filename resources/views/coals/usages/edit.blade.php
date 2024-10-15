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
                        Ubah Pemakaian Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('coals.usages.index') }}" class="cursor-pointer">Pemakaian Batu Bara</a> / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Ubah Pemakaian Batu Bara ?')" action="{{ route('coals.usages.update',['id'=>$usage->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                        <div class="unloadings">
                            <div class="p-4 bg-white rounded-lg w-full">
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="tug_9_number" class="font-bold text-[#232D42] text-[16px]">No TUG 9</label>
                                        <div class="relative">
                                            <input required type="text" name="tug_9_number" value="{{ old('tug_9_number', $usage->tug_9_number ?? '')}}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('tug_9_number')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="usage_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Pakai</label>
                                        <div class="relative">
                                            <input required type="date" name="usage_date" value="{{ old('usage_date', $usage->usage_date ?? '') }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
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
                                        <label for="amount_use" class="font-bold text-[#232D42] text-[16px]">Jumlah Pakai</label>
                                        <div class="relative">
                                            <input required type="text" name="amount_use" value="{{old('amount_use', $usage->amount_use ?? '')}}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('amount_use')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="unit_id" class="font-bold text-[#232D42] text-[16px]">Untuk Unit</label>
                                        <div class="relative">
                                            <select name="unit_id" id="unit_id" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option selected disabled>Pilih Unit</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{$unit->id}}" {{old('unit_id', $usage->unit_id ?? '') == $unit->id ? 'selected' : ''}}>{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="flex gap-3">

                            <a href="{{route('coals.usages.index')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                            <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

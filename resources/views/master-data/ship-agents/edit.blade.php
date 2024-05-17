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
                        Edit Agen Kapal
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('master-data.ship-agents.index') }}" class="cursor-pointer">Agen Kapal</a>  / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Update Pemasok?')" action="{{ route('master-data.ship-agents.update', ['uuid' => $ship_agent->uuid]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="name" class="font-bold text-[#232D42] text-[16px]">Nama Agen Kapal</label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') ? old('name') : $ship_agent->name }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
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
                                            <option @if($ship_agent->load_type_uuid == $load_type->uuid) selected @endif value="{{ $load_type->uuid }}">{{ $load_type->name }}</option>
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
                                    <input type="text" name="phone" value="{{ old('phone') ? old('phone') : $ship_agent->phone }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
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
                                    <input type="text" name="fax" value="{{ old('fax') ? old('fax') : $ship_agent->fax }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
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
                                    <textarea name="address" value="{{ old('address') }}" style="height:150px" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">{{ old('address') ? old('address') : $ship_agent->address }}</textarea>
                                    @error('address')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{route('master-data.ship-agents.index')}}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Update Agen Kapal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

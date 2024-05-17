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
                        Edit BPB
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('initial-data.settings-bpb.index') }}" class="cursor-pointer">BPB</a>  / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Update BPB?')" action="{{ route('initial-data.settings-bpb.update', ['uuid' => $bpb->uuid]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="year" class="font-bold text-[#232D42] text-[16px]">Tahun</label>
                                <div class="relative">
                                    <input type="text" name="year" value="{{ old('year') ? old('year') : $bpb->year }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('year')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="last_bpb_coal" class="font-bold text-[#232D42] text-[16px]">BPB terakhir untuk batubara</label>
                                <div class="relative">
                                    <input type="text" name="last_bpb_coal" value="{{ old('last_bpb_coal') ? old('last_bpb_coal') : $bpb->last_bpb_coal }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('last_bpb_coal')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="last_bpb_solar" class="font-bold text-[#232D42] text-[16px]">BPB terakhir untuk solar</label>
                                <div class="relative">
                                    <input type="text" name="last_bpb_solar" value="{{ old('last_bpb_solar') ? old('last_bpb_solar') : $bpb->last_bpb_solar }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('last_bpb_solar')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="last_bpb_residu" class="font-bold text-[#232D42] text-[16px]">BPB terakhir untuk residu</label>
                                <div class="relative">
                                    <input type="text" name="last_bpb_residu" value="{{ old('last_bpb_residu') ? old('last_bpb_residu') : $bpb->last_bpb_residu }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('last_bpb_residu')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{route('initial-data.settings-bpb.index')}}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Update BPB</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

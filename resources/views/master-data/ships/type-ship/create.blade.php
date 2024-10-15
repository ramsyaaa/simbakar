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
                        Tambah Jenis Kapal
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('master-data.ships.index') }}" class="cursor-pointer">Kapal</a> / <a href="{{ route('master-data.ships.type-ship.index') }}" class="cursor-pointer">Jenis Kapal</a>  / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Jenis Kapal?')" action="{{ route('master-data.ships.type-ship.store') }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="name" class="font-bold text-[#232D42] text-[16px]">Jenis Kapal</label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('name')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-10">
                            <div class="w-full">
                                <label for="docks" class="font-bold text-[#232D42] text-[16px]">Dapat melakukan sandar pada dermaga :</label>
                                <div class="relative mt-3">
                                    @foreach ($docks as $dock)
                                        <input type="checkbox" id="{{ $dock->uuid }}" name="docks[]" value="{{ $dock->uuid }}">
                                        <label for="{{ $dock->uuid }}"> {{ $dock->name }}</label><br>
                                    @endforeach
                                    @error('docks')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{route('master-data.ships.type-ship.index')}}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah Jenis Kapal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

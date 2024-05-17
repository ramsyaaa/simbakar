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
                        Ubah Pemesanan BBM 
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('contracts.bbm-book-contracts.index') }}" class="cursor-pointer">Pemesanan BBM </a>  / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Ubahkan Pemesanan BBM ?')" action="{{ route('contracts.bbm-book-contracts.update',['uuid'=>$bbm->uuid]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="name" class="font-bold text-[#232D42] text-[16px]">Nomor Pemesanan</label>
                                <div class="relative">
                                    <input type="text" name="order_number" value="{{ $bbm->order_number }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('order_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="total" class="font-bold text-[#232D42] text-[16px]">Jumlah</label>
                                <div class="relative">
                                    <input type="number" name="total" value="{{ $bbm->total }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('total')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="order_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Pemesanan</label>
                                <div class="relative">
                                    <input type="date" name="order_date" value="{{ $bbm->order_date }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('order_date')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="fleet_type" class="font-bold text-[#232D42] text-[16px]">Armada</label>
                                <div class="relative">
                                    <select id="fleet_type" name="fleet_type" class="w-[600px] h-[44px] rounded-md border px-2 mb-5" autofocus>
                                        <option selected disabled>Pilih Armada</option>
                                        <option value="Mobil" {{$bbm->fleet_type == 'Mobil' ? 'selected' :''}}>Mobil</option>                                        
                                        <option value="Kapal" {{$bbm->fleet_type == 'Kapal' ? 'selected' :''}}>Kapal</option>                                        
                                    </select>    
                                    <select id="ship_uuid" name="ship_uuid" class="w-[600px] h-[44px] rounded-md border px-2" {{$bbm->fleet_type == 'Mobil' ? 'Disabled' :''}}>
                                        <option selected disabled>Pilih Kapal</option>
                                        @foreach ($ships as $ship)
                                            <option value="{{$ship->uuid}}" {{$ship->uuid == $bbm->ship_uuid ? 'selected' :''}}>{{$ship->name}}</option>
                                        @endforeach
                                    </select> 
                                    @error('fleet_type')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="alocation_date" class="font-bold text-[#232D42] text-[16px]">Bulan dan Tahun Alokasi</label>
                                <div class="relative">
                                    <input type="month" name="alocation_date" value="{{ $bbm->alocation_date}}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('alocation_date')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('contracts.bbm-book-contracts.index') }}" class="bg-[#C03221] w-full lg:w-[600px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah Pemesanan BBM </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

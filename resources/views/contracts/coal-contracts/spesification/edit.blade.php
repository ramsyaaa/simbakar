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
                        Edit Kontrak Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> <a href="{{ route('contracts.coal-contracts.index') }}" class="cursor-pointer">  <a href="{{ route('contracts.coal-contracts.index') }}"> / Kontrak Batu Bara  <a href="{{ route('contracts.coal-contracts.spesification.index',['contractId' => $contract->id]) }}"> / Spesifikasi Kontrak Batu Bara / </a> <span class="text-[#2E46BA] cursor-pointer">{{$contract->contract_number}}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Edit Spesifikasi Kontrak Baru ?')" action="{{ route('contracts.coal-contracts.spesification.update',['contractId'=>$contract->id,'id'=>$coal->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="p-4 bg-white rounded-lg w-full">
                    <small class="text-slate-700"> Untuk angka koma gunakan titik .</small>

                        <div class="w-full py-1">
                            <input type="hidden" name="contract_id" value="{{$contract->id}}">
                            <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Keterangan</div>
                            <label for="contract_number" class="font-bold text-[#232D42] text-[16px]">Identifikasi Spek</label>
                            <div class="relative">
                                <textarea name="identification_spesification" id="" cols="30" rows="3" class="w-full lg:w-full border rounded-md mt-3 mb-5 px-3">
                                    {{$coal->identification_spesification}}
                                </textarea>
                                @error('contract_number')
                                <div class="absolute -bottom-1 left-1 text-red-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>     
                        <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Harga & Nilai Kurs</div>
                        <div class="w-full py-1 flex gap-5">
                            <div class="price">
                                <label for="price" class="font-bold text-[#232D42] text-[16px]">Harga Satuan</label>
                                <div class="relative">
                                    <input type="number" name="price" value="{{ $coal->price }}" class="w-full lg:w-[720px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Harga Satuan">
                                    @error('price')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="price">
                                <label for="exchange_rate" class="font-bold text-[#232D42] text-[16px]">Nilai Kurs BI</label>
                                <div class="relative">
                                    <input type="number" name="exchange_rate" value="{{ $coal->exchange_rate }}" class="w-full lg:w-[720px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Nilai Kurs BI">
                                    @error('exchange_rate')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                        <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Keterangan</div>
                        {{-- Total Moisure --}}
                        <div class="w-full py-1 flex gap-3">
                            <div class="total_moisure">
                                <label for="total_moisure_min" class="font-bold text-[#232D42] text-[16px]">Total Moisure Min</label>
                                <div class="relative">
                                    <input type="text" name="total_moisure_min" value="{{ $coal->total_moisure_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Total Moisure Min">
                                    @error('total_moisure_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="total_moisure">
                                <label for="total_moisure_max" class="font-bold text-[#232D42] text-[16px]">Total Moisure Max</label>
                                <div class="relative">
                                    <input type="text" name="total_moisure_max" value="{{ $coal->total_moisure_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Total Moisure Max">
                                    @error('total_moisure_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="total_moisure">
                                <label for="total_moisure_typical" class="font-bold text-[#232D42] text-[16px]">Total Moisure Typical</label>
                                <div class="relative">
                                    <input type="text" name="total_moisure_typical" value="{{ $coal->total_moisure_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Total Moisure Typical">
                                    @error('total_moisure_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                        {{-- Air Dried Moisure --}}
                        <div class="w-full py-1 flex gap-3">
                            <div class="airdried_moisure">
                                <label for="air_dried_moisure_min" class="font-bold text-[#232D42] text-[16px]">Air Dried Min</label>
                                <div class="relative">
                                    <input type="text" name="air_dried_moisure_min" value="{{ $coal->air_dried_moisure_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Air Dried Min">
                                    @error('air_dried_moisure_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="air_dried_moisure">
                                <label for="air_dried_moisure_max" class="font-bold text-[#232D42] text-[16px]">Air Dried Max</label>
                                <div class="relative">
                                    <input type="text" name="air_dried_moisure_max" value="{{ $coal->air_dried_moisure_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Air Dried Max">
                                    @error('air_dried_moisure_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="air_dried_moisure">
                                <label for="air_dried_moisure_typical" class="font-bold text-[#232D42] text-[16px]">Air Dried Typical</label>
                                <div class="relative">
                                    <input type="text" name="air_dried_moisure_typical" value="{{ $coal->air_dried_moisure_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Air Dried Typical">
                                    @error('air_dried_moisure_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                         
                        {{-- Ash --}}
                        <div class="w-full py-1 flex gap-3">
                            <div class="ash">
                                <label for="ash_min" class="font-bold text-[#232D42] text-[16px]">Ash Min</label>
                                <div class="relative">
                                    <input type="text" name="ash_min" value="{{ $coal->ash_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Ash Min">
                                    @error('ash_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="ash">
                                <label for="ash" class="font-bold text-[#232D42] text-[16px]">Ash Max</label>
                                <div class="relative">
                                    <input type="text" name="ash_max" value="{{ $coal->ash_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Ash Max">
                                    @error('ash_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="ash">
                                <label for="ash" class="font-bold text-[#232D42] text-[16px]">Ash Typical</label>
                                <div class="relative">
                                    <input type="text" name="ash_typical" value="{{ $coal->ash_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Ash Typical">
                                    @error('ash_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                        {{-- Volatile Matter --}}
                        <div class="w-full py-1 flex gap-3">
                            <div class="volatile_matter">
                                <label for="volatile_matter_min" class="font-bold text-[#232D42] text-[16px]">Volatile Matter Min</label>
                                <div class="relative">
                                    <input type="text" name="volatile_matter_min" value="{{ $coal->volatile_matter_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Volatile Matter Min">
                                    @error('volatile_matter_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="volatile_matter">
                                <label for="volatile_matter_max" class="font-bold text-[#232D42] text-[16px]">Volatile Matter Max</label>
                                <div class="relative">
                                    <input type="text" name="volatile_matter_max" value="{{ $coal->volatile_matter_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Volatile Matter Max">
                                    @error('volatile_matter_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="volatile_matter">
                                <label for="volatile_matter_typical" class="font-bold text-[#232D42] text-[16px]">Volatile Matter Typical</label>
                                <div class="relative">
                                    <input type="text" name="volatile_matter_typical" value="{{ $coal->volatile_matter_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Volatile Matter Typical">
                                    @error('volatile_matter_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                         
                        {{-- Fixed Carbon --}}
                        <div class="w-full py-1 flex gap-3">
                            <div class="fixed_carbon">
                                <label for="fixed_carbon_min" class="font-bold text-[#232D42] text-[16px]">Fixed Carbon Min</label>
                                <div class="relative">
                                    <input type="text" name="fixed_carbon_min" value="{{ $coal->fixed_carbon_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Fixed Carbon Min">
                                    @error('fixed_carbon_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="fixed_carbon">
                                <label for="fixed_carbon_max" class="font-bold text-[#232D42] text-[16px]">Fixed Carbon Max</label>
                                <div class="relative">
                                    <input type="text" name="fixed_carbon_max" value="{{ $coal->fixed_carbon_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Fixed Carbon Max">
                                    @error('fixed_carbon_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="fixed_carbon">
                                <label for="fixed_carbon_typical" class="font-bold text-[#232D42] text-[16px]">Fixed Carbon Typical</label>
                                <div class="relative">
                                    <input type="text" name="fixed_carbon_typical" value="{{ $coal->fixed_carbon_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Fixed Carbon Typical">
                                    @error('fixed_carbon_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                         
                        {{-- Calorivic Value --}}
                        <div class="w-full py-1 flex gap-3">
                            <div class="calorivic_value">
                                <label for="calorivic_value_min" class="font-bold text-[#232D42] text-[16px]">Calorivic Value Min</label>
                                <div class="relative">
                                    <input type="text" name="calorivic_value_min" value="{{ $coal->calorivic_value_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Calorivic Value Min">
                                    @error('calorivic_value_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="calorivic_value">
                                <label for="calorivic_value_max" class="font-bold text-[#232D42] text-[16px]">Calorivic Value Max</label>
                                <div class="relative">
                                    <input type="text" name="calorivic_value_max" value="{{ $coal->calorivic_value_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Calorivic Value Max">
                                    @error('calorivic_value_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="calorivic_value">
                                <label for="calorivic_value_typical" class="font-bold text-[#232D42] text-[16px]">Calorivic Value Typical</label>
                                <div class="relative">
                                    <input type="text" name="calorivic_value_typical" value="{{ $coal->calorivic_value_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Calorivic Value Typical">
                                    @error('calorivic_value_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                        <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Keterangan</div>
                        {{-- Carbon --}}
                        <div class="w-full py-1 flex gap-3">
                            <div class="carbon">
                                <label for="carbon_min" class="font-bold text-[#232D42] text-[16px]">Carbon Min</label>
                                <div class="relative">
                                    <input type="text" name="carbon_min" value="{{ $coal->carbon_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Carbon Min">
                                    @error('carbon_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="carbon">
                                <label for="carbon_max" class="font-bold text-[#232D42] text-[16px]">Carbon Max</label>
                                <div class="relative">
                                    <input type="text" name="carbon_max" value="{{ $coal->carbon_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Carbon Max">
                                    @error('carbon_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="carbon">
                                <label for="carbon_typical" class="font-bold text-[#232D42] text-[16px]">Carbon Typical</label>
                                <div class="relative">
                                    <input type="text" name="carbon_typical" value="{{ $coal->carbon_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Carbon Typical">
                                    @error('carbon_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Nitrogen --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="nitrogen">
                                <label for="nitrogen_min" class="font-bold text-[#232D42] text-[16px]">Nitrogen Min</label>
                                <div class="relative">
                                    <input type="text" name="nitrogen_min" value="{{ $coal->nitrogen_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Nitrogen Min">
                                    @error('nitrogen_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="nitrogen">
                                <label for="nitrogen_max" class="font-bold text-[#232D42] text-[16px]">Nitrogen Max</label>
                                <div class="relative">
                                    <input type="text" name="nitrogen_max" value="{{ $coal->nitrogen_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Nitrogen Max">
                                    @error('nitrogen_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="nitrogen">
                                <label for="nitrogen_typical" class="font-bold text-[#232D42] text-[16px]">Nitrogen Typical</label>
                                <div class="relative">
                                    <input type="text" name="nitrogen_typical" value="{{ $coal->nitrogen_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Nitrogen Typical">
                                    @error('nitrogen_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Hidrogen --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="hidrogen">
                                <label for="hydrogen_min" class="font-bold text-[#232D42] text-[16px]">Hidrogen Min</label>
                                <div class="relative">
                                    <input type="text" name="hydrogen_min" value="{{ $coal->hydrogen_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Hidrogen Min">
                                    @error('hydrogen_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="hidrogen">
                                <label for="hydrogen_max" class="font-bold text-[#232D42] text-[16px]">Hidrogen Max</label>
                                <div class="relative">
                                    <input type="text" name="hydrogen_max" value="{{ $coal->hydrogen_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Hidrogen Max">
                                    @error('hydrogen_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="hidrogen">
                                <label for="hydrogen_typical" class="font-bold text-[#232D42] text-[16px]">Hidrogen Typical</label>
                                <div class="relative">
                                    <input type="text" name="hydrogen_typical" value="{{ $coal->hydrogen_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Hidrogen Typical">
                                    @error('hydrogen_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Oxygen --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="oxygen">
                                <label for="oxygen_min" class="font-bold text-[#232D42] text-[16px]">Oxygen Min</label>
                                <div class="relative">
                                    <input type="text" name="oxygen_min" value="{{ $coal->oxygen_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Oxygen Min">
                                    @error('oxygen_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="oxygen">
                                <label for="oxygen_max" class="font-bold text-[#232D42] text-[16px]">Oxygen Max</label>
                                <div class="relative">
                                    <input type="text" name="oxygen_max" value="{{ $coal->oxygen_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Oxygen Max">
                                    @error('oxygen_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="oxygen">
                                <label for="oxygen_typical" class="font-bold text-[#232D42] text-[16px]">Oxygen Typical</label>
                                <div class="relative">
                                    <input type="text" name="oxygen_typical" value="{{ $coal->oxygen_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Oxygen Typical">
                                    @error('oxygen_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                        <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Keterangan</div>
                          {{-- Initial Deformation --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="initial_deformation">
                                <label for="initial_deformation_min" class="font-bold text-[#232D42] text-[16px]">Initial Deformation Min</label>
                                <div class="relative">
                                    <input type="text" name="initial_deformation_min" value="{{ $coal->initial_deformation_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Initial Deformation Min">
                                    @error('initial_deformation_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="initial_deformation">
                                <label for="initial_deformation_max" class="font-bold text-[#232D42] text-[16px]">Initial Deformation Max</label>
                                <div class="relative">
                                    <input type="text" name="initial_deformation_max" value="{{ $coal->initial_deformation_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Initial Deformation Max">
                                    @error('initial_deformation_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="initial_deformation">
                                <label for="initial_deformation_typical" class="font-bold text-[#232D42] text-[16px]">Initial Deformation Typical</label>
                                <div class="relative">
                                    <input type="text" name="initial_deformation_typical" value="{{ $coal->initial_deformation_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Initial Deformation Typical">
                                    @error('initial_deformation_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Softening --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="softening">
                                <label for="softening_min" class="font-bold text-[#232D42] text-[16px]">Softening Min</label>
                                <div class="relative">
                                    <input type="text" name="softening_min" value="{{ $coal->softening_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Softening Min">
                                    @error('softening_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="softening">
                                <label for="softening_max" class="font-bold text-[#232D42] text-[16px]">Softening Max</label>
                                <div class="relative">
                                    <input type="text" name="softening_max" value="{{ $coal->softening_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Softening Max">
                                    @error('softening_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="softening">
                                <label for="softening_typical" class="font-bold text-[#232D42] text-[16px]">Softening Typical</label>
                                <div class="relative">
                                    <input type="text" name="softening_typical" value="{{ $coal->softening_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Softening Typical">
                                    @error('softening_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Hemispherical --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="hemispherical">
                                <label for="hemispherical_min" class="font-bold text-[#232D42] text-[16px]">Hemispherical Min</label>
                                <div class="relative">
                                    <input type="text" name="hemispherical_min" value="{{ $coal->hemispherical_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Hemispherical Min">
                                    @error('hemispherical_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="hemispherical">
                                <label for="hemispherical_max" class="font-bold text-[#232D42] text-[16px]">Hemispherical Max</label>
                                <div class="relative">
                                    <input type="text" name="hemispherical_max" value="{{ $coal->hemispherical_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Hemispherical Max">
                                    @error('hemispherical_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="hemispherical">
                                <label for="hemispherical_typical" class="font-bold text-[#232D42] text-[16px]">Hemispherical Typical</label>
                                <div class="relative">
                                    <input type="text" name="hemispherical_typical" value="{{ $coal->hemispherical_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Hemispherical Typical">
                                    @error('hemispherical_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Fluid --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="fluid">
                                <label for="fluid_min" class="font-bold text-[#232D42] text-[16px]">Fluid Min</label>
                                <div class="relative">
                                    <input type="text" name="fluid_min" value="{{ $coal->fluid_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Fluid Min">
                                    @error('fluid_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="fluid">
                                <label for="fluid_max" class="font-bold text-[#232D42] text-[16px]">Fluid Max</label>
                                <div class="relative">
                                    <input type="text" name="fluid_max" value="{{ $coal->fluid_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Fluid Max">
                                    @error('fluid_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="fluid">
                                <label for="fluid_typical" class="font-bold text-[#232D42] text-[16px]">Fluid Typical</label>
                                <div class="relative">
                                    <input type="text" name="fluid_typical" value="{{ $coal->fluid_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Fluid Typical">
                                    @error('fluid_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                        <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Keterangan</div>
                          {{-- SiO2 --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="sio2">
                                <label for="sio2_min" class="font-bold text-[#232D42] text-[16px]">SiO2 Min</label>
                                <div class="relative">
                                    <input type="text" name="sio2_min" value="{{ $coal->sio2_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="SiO2 Min">
                                    @error('sio2_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="sio2">
                                <label for="sio2_max" class="font-bold text-[#232D42] text-[16px]">SiO2 Max</label>
                                <div class="relative">
                                    <input type="text" name="sio2_max" value="{{ $coal->sio2_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="SiO2 Max">
                                    @error('sio2_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="sio2">
                                <label for="sio2_typical" class="font-bold text-[#232D42] text-[16px]">SiO2 Typical</label>
                                <div class="relative">
                                    <input type="text" name="sio2_typical" value="{{ $coal->sio2_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="SiO2 Typical">
                                    @error('sio2_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- AI2O3 --}}
                        <div class="w-full py-1 flex gap-3">
                            <div class="ai2o3">
                                <label for="ai2o3_min" class="font-bold text-[#232D42] text-[16px]">AI2O3 Min</label>
                                <div class="relative">
                                    <input type="text" name="ai2o3_min" value="{{ $coal->ai2o3_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="AI2O3 Min">
                                    @error('ai2o3_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="ai2o3">
                                <label for="ai2o3_max" class="font-bold text-[#232D42] text-[16px]">AI2O3 Max</label>
                                <div class="relative">
                                    <input type="text" name="ai2o3_max" value="{{ $coal->ai2o3_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="AI2O3 Max">
                                    @error('ai2o3_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="ai2o3">
                                <label for="ai2o3_typical" class="font-bold text-[#232D42] text-[16px]">AI2O3 Typical</label>
                                <div class="relative">
                                    <input type="text" name="ai2o3_typical" value="{{ $coal->ai2o3_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="AI2O3 Typical">
                                    @error('ai2o3_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Fe2O3 --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="fe2o3">
                                <label for="fe2o3_min" class="font-bold text-[#232D42] text-[16px]">Fe2O3 Min</label>
                                <div class="relative">
                                    <input type="text" name="fe2o3_min" value="{{ $coal->fe2o3_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Fe2O3 Min">
                                    @error('fe2o3_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="fe2o3">
                                <label for="fe2o3_max" class="font-bold text-[#232D42] text-[16px]">Fe2O3 Max</label>
                                <div class="relative">
                                    <input type="text" name="fe2o3_max" value="{{ $coal->fe2o3_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Fe2O3 Max">
                                    @error('fe2o3_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="fe2o3">
                                <label for="fe2o3_typical" class="font-bold text-[#232D42] text-[16px]">Fe2O3 Typical</label>
                                <div class="relative">
                                    <input type="text" name="fe2o3_typical" value="{{ $coal->fe2o3_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Fe2O3 Typical">
                                    @error('fe2o3_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- CaO --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="cao">
                                <label for="cao_min" class="font-bold text-[#232D42] text-[16px]">CaO Min</label>
                                <div class="relative">
                                    <input type="text" name="cao_min" value="{{ $coal->cao_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="CaO Min">
                                    @error('cao_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="cao">
                                <label for="cao_max" class="font-bold text-[#232D42] text-[16px]">CaO Max</label>
                                <div class="relative">
                                    <input type="text" name="cao_max" value="{{ $coal->cao_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="CaO Max">
                                    @error('cao_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="cao">
                                <label for="cao_typical" class="font-bold text-[#232D42] text-[16px]">CaO Typical</label>
                                <div class="relative">
                                    <input type="text" name="cao_typical" value="{{ $coal->cao_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="CaO Typical">
                                    @error('cao_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- MgO --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="mgo">
                                <label for="mgo_min" class="font-bold text-[#232D42] text-[16px]">MgO Min</label>
                                <div class="relative">
                                    <input type="text" name="mgo_min" value="{{ $coal->mgo_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="MgO Min">
                                    @error('mgo_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mgo">
                                <label for="mgo_max" class="font-bold text-[#232D42] text-[16px]">MgO Max</label>
                                <div class="relative">
                                    <input type="text" name="mgo_max" value="{{ $coal->mgo_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="MgO Max">
                                    @error('mgo_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mgo">
                                <label for="mgo_typical" class="font-bold text-[#232D42] text-[16px]">MgO Typical</label>
                                <div class="relative">
                                    <input type="text" name="mgo_typical" value="{{ $coal->mgo_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="MgO Typical">
                                    @error('mgo_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Na2O --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="na2o">
                                <label for="na2o_min" class="font-bold text-[#232D42] text-[16px]">Na2O Min</label>
                                <div class="relative">
                                    <input type="text" name="na2o_min" value="{{ $coal->na2o_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Na2O Min">
                                    @error('na2o_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="na2o">
                                <label for="na2o_max" class="font-bold text-[#232D42] text-[16px]">Na2O Max</label>
                                <div class="relative">
                                    <input type="text" name="na2o_max" value="{{ $coal->na2o_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Na2O Max">
                                    @error('na2o_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="na2o">
                                <label for="na2o_typical" class="font-bold text-[#232D42] text-[16px]">Na2O Typical</label>
                                <div class="relative">
                                    <input type="text" name="na2o_typical" value="{{ $coal->na2o_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Na2O Typical">
                                    @error('na2o_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- K2O --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="k2o">
                                <label for="k2o_min" class="font-bold text-[#232D42] text-[16px]">K2O Min</label>
                                <div class="relative">
                                    <input type="text" name="k2o_min" value="{{ $coal->k2o_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="K2O Min">
                                    @error('k2o_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="k2o">
                                <label for="k2o_max" class="font-bold text-[#232D42] text-[16px]">K2O Max</label>
                                <div class="relative">
                                    <input type="text" name="k2o_max" value="{{ $coal->k2o_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="K2O Max">
                                    @error('k2o_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="k2o">
                                <label for="k2o_typical" class="font-bold text-[#232D42] text-[16px]">K2O Typical</label>
                                <div class="relative">
                                    <input type="text" name="k2o_typical" value="{{ $coal->k2o_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="K2O Typical">
                                    @error('k2o_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- TiO2 --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="tio2">
                                <label for="tio2_min" class="font-bold text-[#232D42] text-[16px]">TiO2 Min</label>
                                <div class="relative">
                                    <input type="text" name="tio2_min" value="{{ $coal->tio2_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="TiO2 Min">
                                    @error('tio2_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="tio2">
                                <label for="tio2_max" class="font-bold text-[#232D42] text-[16px]">TiO2 Max</label>
                                <div class="relative">
                                    <input type="text" name="tio2_max" value="{{ $coal->tio2_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="TiO2 Max">
                                    @error('tio2_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="tio2">
                                <label for="tio2_typical" class="font-bold text-[#232D42] text-[16px]">TiO2 Typical</label>
                                <div class="relative">
                                    <input type="text" name="tio2_typical" value="{{ $coal->tio2_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="TiO2 Typical">
                                    @error('tio2_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- SO3 --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="so3">
                                <label for="so3_min" class="font-bold text-[#232D42] text-[16px]">SO3 Min</label>
                                <div class="relative">
                                    <input type="text" name="so3_min" value="{{ $coal->so3_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="SO3 Min">
                                    @error('so3_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="so3">
                                <label for="so3_max" class="font-bold text-[#232D42] text-[16px]">SO3 Max</label>
                                <div class="relative">
                                    <input type="text" name="so3_max" value="{{ $coal->so3_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="SO3 Max">
                                    @error('so3_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="so3">
                                <label for="so3_typical" class="font-bold text-[#232D42] text-[16px]">SO3 Typical</label>
                                <div class="relative">
                                    <input type="text" name="so3_typical" value="{{ $coal->so3_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="SO3 Typical">
                                    @error('so3_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- P2O5 --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="p2o5">
                                <label for="p2o5_min" class="font-bold text-[#232D42] text-[16px]">P2O5 Min</label>
                                <div class="relative">
                                    <input type="text" name="p2o5_min" value="{{ $coal->p2o5_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="P2O5 Min">
                                    @error('p2o5_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="p2o5">
                                <label for="p2o5_max" class="font-bold text-[#232D42] text-[16px]">P2O5 Max</label>
                                <div class="relative">
                                    <input type="text" name="p2o5_max" value="{{ $coal->p2o5_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="P2O5 Max">
                                    @error('p2o5_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="p2o5">
                                <label for="p2o5_typical" class="font-bold text-[#232D42] text-[16px]">P2O5 Typical</label>
                                <div class="relative">
                                    <input type="text" name="p2o5_typical" value="{{ $coal->p2o5_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="P2O5 Typical">
                                    @error('p2o5_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- MnO4 --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="mno4">
                                <label for="mno4_min" class="font-bold text-[#232D42] text-[16px]">MnO4 Min</label>
                                <div class="relative">
                                    <input type="text" name="mno4_min" value="{{ $coal->mno4_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="MnO4 Min">
                                    @error('mno4_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mno4">
                                <label for="mno4_max" class="font-bold text-[#232D42] text-[16px]">MnO4 Max</label>
                                <div class="relative">
                                    <input type="text" name="mno4_max" value="{{ $coal->mno4_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="MnO4 Max">
                                    @error('mno4_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mno4">
                                <label for="mno4_typical" class="font-bold text-[#232D42] text-[16px]">MnO4 Typical</label>
                                <div class="relative">
                                    <input type="text" name="mno4_typical" value="{{ $coal->mno4_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="MnO4 Typical">
                                    @error('mno4_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                        <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Butiran</div>
                          {{-- Butiran > 70 mm --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="butiran_70">
                                <label for="butiran_70_min" class="font-bold text-[#232D42] text-[16px]">Butiran > 70 mm Min</label>
                                <div class="relative">
                                    <input type="text" name="butiran_70_min" value="{{ $coal->butiran_70_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran > 70 mm Min">
                                    @error('butiran_70_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="butiran_70">
                                <label for="butiran_70_max" class="font-bold text-[#232D42] text-[16px]">Butiran > 70 mm Max</label>
                                <div class="relative">
                                    <input type="text" name="butiran_70_max" value="{{ $coal->butiran_70_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran > 70 mm Max">
                                    @error('butiran_70_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="butiran_70">
                                <label for="butiran_70_typical" class="font-bold text-[#232D42] text-[16px]">Butiran > 70 mm Typical</label>
                                <div class="relative">
                                    <input type="text" name="butiran_70_typical" value="{{ $coal->butiran_70_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran > 70 mm Typical">
                                    @error('butiran_70_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Calorivic Value --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="calorivic_value">
                                <label for="calorivic_value_min" class="font-bold text-[#232D42] text-[16px]">Calorivic Value Min</label>
                                <div class="relative">
                                    <input type="text" name="calorivic_value_min" value="{{ $coal->calorivic_value_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Calorivic Value Min">
                                    @error('calorivic_value_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="calorivic_value">
                                <label for="calorivic_value_max" class="font-bold text-[#232D42] text-[16px]">Calorivic Value Max</label>
                                <div class="relative">
                                    <input type="text" name="calorivic_value_max" value="{{ $coal->calorivic_value_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Calorivic Value Max">
                                    @error('calorivic_value_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="calorivic_value">
                                <label for="calorivic_value_typical" class="font-bold text-[#232D42] text-[16px]">Calorivic Value Typical</label>
                                <div class="relative">
                                    <input type="text" name="calorivic_value_typical" value="{{ $coal->calorivic_value_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Calorivic Value Typical">
                                    @error('calorivic_value_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                           {{-- Butiran > 50 mm --}}
                        <div class="w-full py-1 flex gap-3">
                            <div class="butiran_50">
                                <label for="butiran_50_min" class="font-bold text-[#232D42] text-[16px]">Butiran > 50 mm Min</label>
                                <div class="relative">
                                    <input type="text" name="butiran_50_min" value="{{ $coal->butiran_50_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran > 50 mm Min">
                                    @error('butiran_50_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="butiran_50">
                                <label for="butiran_50_max" class="font-bold text-[#232D42] text-[16px]">Butiran > 50 mm Max</label>
                                <div class="relative">
                                    <input type="text" name="butiran_50_max" value="{{ $coal->butiran_50_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran > 50 mm Max">
                                    @error('butiran_50_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="butiran_50">
                                <label for="butiran_50_typical" class="font-bold text-[#232D42] text-[16px]">Butiran > 50 mm Typical</label>
                                <div class="relative">
                                    <input type="text" name="butiran_50_typical" value="{{ $coal->butiran_50_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran > 50 mm Typical">
                                    @error('butiran_50_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Butiran 32-50 mm --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="butiran_32_50">
                                <label for="butiran_32_50_min" class="font-bold text-[#232D42] text-[16px]">Butiran 32-50 mm Min</label>
                                <div class="relative">
                                    <input type="text" name="butiran_32_50_min" value="{{ $coal->butiran_32_50_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran 32-50 mm Min">
                                    @error('butiran_32_50_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="butiran_32_50">
                                <label for="butiran_32_50_max" class="font-bold text-[#232D42] text-[16px]">Butiran 32-50 mm Max</label>
                                <div class="relative">
                                    <input type="text" name="butiran_32_50_max" value="{{ $coal->butiran_32_50_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran 32-50 mm Max">
                                    @error('butiran_32_50_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="butiran_32_50">
                                <label for="butiran_32_50_typical" class="font-bold text-[#232D42] text-[16px]">Butiran 32-50 mm Typical</label>
                                <div class="relative">
                                    <input type="text" name="butiran_32_50_typical" value="{{ $coal->butiran_32_50_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran 32-50 mm Typical">
                                    @error('butiran_32_50_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Butiran 32 mm --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="butiran_32">
                                <label for="butiran_32_min" class="font-bold text-[#232D42] text-[16px]">Butiran 32 mm Min</label>
                                <div class="relative">
                                    <input type="text" name="butiran_32_min" value="{{ $coal->butiran_32_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran 32 mm Min">
                                    @error('butiran_32_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="butiran_32">
                                <label for="butiran_32_max" class="font-bold text-[#232D42] text-[16px]">Butiran 32 mm Max</label>
                                <div class="relative">
                                    <input type="text" name="butiran_32_max" value="{{ $coal->butiran_32_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran 32 mm Max">
                                    @error('butiran_32_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="butiran_32">
                                <label for="butiran_32_typical" class="font-bold text-[#232D42] text-[16px]">Butiran 32 mm Typical</label>
                                <div class="relative">
                                    <input type="text" name="butiran_32_typical" value="{{ $coal->butiran_32_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran 32 mm Typical">
                                    @error('butiran_32_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Butiran < 2,8 mm --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="butiran_238">
                                <label for="butiran_238_min" class="font-bold text-[#232D42] text-[16px]">Butiran < 2,8 mm Min</label>
                                <div class="relative">
                                    <input type="text" name="butiran_238_min" value="{{ $coal->butiran_238_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran < 2,8 mm Min">
                                    @error('butiran_238_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="butiran_238">
                                <label for="butiran_238_max" class="font-bold text-[#232D42] text-[16px]">Butiran < 2,8 mm Max</label>
                                <div class="relative">
                                    <input type="text" name="butiran_238_max" value="{{ $coal->butiran_238_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran < 2,8 mm Max">
                                    @error('butiran_238_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="butiran_238">
                                <label for="butiran_238_typical" class="font-bold text-[#232D42] text-[16px]">Butiran < 2,8 mm Typical</label>
                                <div class="relative">
                                    <input type="text" name="butiran_238_typical" value="{{ $coal->butiran_238_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Butiran < 2,8 mm Typical">
                                    @error('butiran_238_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- HGI --}}
                          <div class="bg-sky-600 py-1 text-center text-xl text-white mb-3 rounded">Lain Lain</div>
                          <div class="w-full py-1 flex gap-3">
                            <div class="hgi">
                                <label for="hgi_min" class="font-bold text-[#232D42] text-[16px]">HGI Min</label>
                                <div class="relative">
                                    <input type="text" name="hgi_min" value="{{ $coal->hgi_min }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="HGI Min">
                                    @error('hgi_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="hgi">
                                <label for="hgi_max" class="font-bold text-[#232D42] text-[16px]">HGI Max</label>
                                <div class="relative">
                                    <input type="text" name="hgi_max" value="{{ $coal->hgi_max }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="HGI Max">
                                    @error('hgi_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="hgi">
                                <label for="hgi_typical" class="font-bold text-[#232D42] text-[16px]">HGI Typical</label>
                                <div class="relative">
                                    <input type="text" name="hgi_typical" value="{{ $coal->hgi_typical }}" class="input-number w-full lg:w-[480px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="HGI Typical">
                                    @error('hgi_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 

                          {{-- Staging Potensial --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="staging">
                                <label for="stagging_min" class="font-bold text-[#232D42] text-[16px]">Stagging Potensial</label>
                                <div class="relative">
                                    <select name="stagging_potensial" id="" class="w-full mt-3 lg:w-[720px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                        <option selected disabled>Pilih Level</option>
                                        <option>Low</option>
                                        <option>Medium</option>
                                        <option>High</option>
                                        <option>Severe</option>
                                    </select>
                                    @error('stagging_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="staging">
                                <label for="stagging_index" class="font-bold text-[#232D42] text-[16px]">Stagging Index</label>
                                <div class="relative">
                                    <input type="text" name="stagging_index" value="{{ $coal->stagging_index }}" class="input-number w-full lg:w-[720px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Staging Potensial Max">
                                    @error('stagging_index')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                          {{-- fouling Potensial --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="fouling">
                                <label for="fouling_min" class="font-bold text-[#232D42] text-[16px]">Fouling Potensial</label>
                                <div class="relative">
                                    <select name="fouling_potensial" id="" class="w-full mt-3 lg:w-[720px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                        <option selected disabled>Pilih Level</option>
                                        <option>Low</option>
                                        <option>Medium</option>
                                        <option>High</option>
                                        <option>Severe</option>
                                    </select>
                                    @error('fouling_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="fouling">
                                <label for="fouling_index" class="font-bold text-[#232D42] text-[16px]">Fouling Index</label>
                                <div class="relative">
                                    <input type="text" name="fouling_index" value="{{ $coal->fouling_index }}" class="input-number w-full lg:w-[720px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="fouling Potensial Max">
                                    @error('fouling_index')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>       
                        <div class="flex gap-3">
                            <a href="{{route('contracts.coal-contracts.spesification.index',['contractId'=>$contract->id])}}" class="bg-[#C03221] w-full h-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3 text-center">Back</a>
                            <button class="bg-[#2E46BA] h-full w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah</button>
                        </div>     
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

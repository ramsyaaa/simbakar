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
                        Ubah Kontrak Biomassa
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> <a href="{{ route('contracts.biomassa-contracts.index') }}" class="cursor-pointer">  <a href="{{ route('contracts.biomassa-contracts.index') }}"> / Kontrak Biomassa  <a href="{{ route('contracts.biomassa-contracts.spesification.index',['contractId' => $contract->id]) }}"> / Spesifikasi Kontrak Biomassa / </a> <span class="text-[#2E46BA] cursor-pointer">{{$contract->contract_number}}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Spesifikasi Kontrak Baru ?')" action="{{ route('contracts.biomassa-contracts.spesification.update',['contractId'=>$contract->id,'id'=>$biomassa->id]) }}" method="POST">
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
                                    {{$biomassa->identification_spesification}}
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
                                    <input type="number" name="price" value="{{$biomassa->price}}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Harga Satuan">
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
                                    <input type="number" name="exchange_rate" value="{{$biomassa->exchange_rate}}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Nilai Kurs BI">
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
                                    <input type="text" name="total_moisure_min" value="{{$biomassa->total_moisure_min}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Total Moisure Min">
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
                                    <input type="text" name="total_moisure_max" value="{{$biomassa->total_moisure_max}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Total Moisure Max">
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
                                    <input type="text" name="total_moisure_typical" value="{{$biomassa->total_moisure_typical}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Total Moisure Typical">
                                    @error('total_moisure_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                        {{-- Moisure In Analysis --}}
                        <div class="w-full py-1 flex gap-3">
                            <div class="airdried_moisure">
                                <label for="moisure_in_analysis_min" class="font-bold text-[#232D42] text-[16px]">Moisure in Analysis Min</label>
                                <div class="relative">
                                    <input type="text" name="moisure_in_analysis_min" value="{{$biomassa->moisure_in_analysis_min}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Moisure in Analysis Min">
                                    @error('moisure_in_analysis_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="moisure_in_analysis">
                                <label for="moisure_in_analysis_max" class="font-bold text-[#232D42] text-[16px]">Moisure in Analysis Max</label>
                                <div class="relative">
                                    <input type="text" name="moisure_in_analysis_max" value="{{$biomassa->moisure_in_analysis_max}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Moisure in Analysis Max">
                                    @error('moisure_in_analysis_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="moisure_in_analysis">
                                <label for="moisure_in_analysis_typical" class="font-bold text-[#232D42] text-[16px]">Moisure in Analysis Typical</label>
                                <div class="relative">
                                    <input type="text" name="moisure_in_analysis_typical" value="{{$biomassa->moisure_in_analysis_typical}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Moisure in Analysis Typical">
                                    @error('moisure_in_analysis_typical')
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
                                <label for="calorivic_value_min" class="font-bold text-[#232D42] text-[16px]">Calorivic Value Min</label>
                                <div class="relative">
                                    <input type="text" name="calorivic_value_min" value="{{$biomassa->calorivic_value_min}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Calorivic Value Min">
                                    @error('calorivic_value_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="ash">
                                <label for="ash" class="font-bold text-[#232D42] text-[16px]">Calorivic Value Max</label>
                                <div class="relative">
                                    <input type="text" name="calorivic_value_max" value="{{$biomassa->calorivic_value_max}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Calorivic Value Max">
                                    @error('calorivic_value_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="ash">
                                <label for="ash" class="font-bold text-[#232D42] text-[16px]">Calorivic Value Typical</label>
                                <div class="relative">
                                    <input type="text" name="calorivic_value_typical" value="{{$biomassa->calorivic_value_typical}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Calorivic Value Typical">
                                    @error('calorivic_value_typical')
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
                                <label for="size_distribution_min" class="font-bold text-[#232D42] text-[16px]">Size Distribution Min</label>
                                <div class="relative">
                                    <input type="text" name="size_distribution_min" value="{{$biomassa->size_distribution_min}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Size Distribution Min">
                                    @error('size_distribution_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="size_distribution">
                                <label for="size_distribution_max" class="font-bold text-[#232D42] text-[16px]">Size Distribution Max</label>
                                <div class="relative">
                                    <input type="text" name="size_distribution_max" value="{{$biomassa->size_distribution_max}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Size Distribution Max">
                                    @error('size_distribution_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="size_distribution">
                                <label for="size_distribution_typical" class="font-bold text-[#232D42] text-[16px]">Size Distribution Max</label>
                                <div class="relative">
                                    <input type="text" name="size_distribution_typical" value="{{$biomassa->size_distribution_typical}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Size Distribution Max">
                                    @error('size_distribution_typical')
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
                            <div class="retained_5">
                                <label for="retained_5_min" class="font-bold text-[#232D42] text-[16px]">Retained 5 Min</label>
                                <div class="relative">
                                    <input type="text" name="retained_5_min" value="{{$biomassa->retained_5_min}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Retained 5 Min">
                                    @error('retained_5_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="retained_5">
                                <label for="retained_5_max" class="font-bold text-[#232D42] text-[16px]">Retained 5 Max</label>
                                <div class="relative">
                                    <input type="text" name="retained_5_max" value="{{$biomassa->retained_5_max}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Retained 5 Max">
                                    @error('retained_5_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="retained_5">
                                <label for="retained_5_typical" class="font-bold text-[#232D42] text-[16px]">Retained 5 Typical</label>
                                <div class="relative">
                                    <input type="text" name="retained_5_typical" value="{{$biomassa->retained_5_typical}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Retained 5 Typical">
                                    @error('retained_5_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                        <div class="w-full py-1 flex gap-3">
                            <div class="retained_238">
                                <label for="retained_238_min" class="font-bold text-[#232D42] text-[16px]">Retained 2.38 Min</label>
                                <div class="relative">
                                    <input type="text" name="retained_238_min" value="{{$biomassa->retained_238_min}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Retained 2.38 Min">
                                    @error('retained_238_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="retained_238">
                                <label for="retained_238_max" class="font-bold text-[#232D42] text-[16px]">Retained 2.38 Max</label>
                                <div class="relative">
                                    <input type="text" name="retained_238_max" value="{{$biomassa->retained_238_max}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Retained 2.38 Max">
                                    @error('retained_238_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="retained_238">
                                <label for="retained_238_typical" class="font-bold text-[#232D42] text-[16px]">Retained 2.38 Typical</label>
                                <div class="relative">
                                    <input type="text" name="retained_238_typical" value="{{$biomassa->retained_238_typical}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Retained 2.38 Typical">
                                    @error('retained_238_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                        <div class="w-full py-1 flex gap-3">
                            <div class="passing_238">
                                <label for="passing_238_min" class="font-bold text-[#232D42] text-[16px]">Passing 2.38 Min</label>
                                <div class="relative">
                                    <input type="text" name="passing_238_min" value="{{$biomassa->passing_238_min}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Passing 2.38 Min">
                                    @error('passing_238_min')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="passing_238">
                                <label for="passing_238_max" class="font-bold text-[#232D42] text-[16px]">Passing 2.38 Max</label>
                                <div class="relative">
                                    <input type="text" name="passing_238_max" value="{{$biomassa->passing_238_max}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Passing 2.38 Max">
                                    @error('passing_238_max')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="passing_238">
                                <label for="passing_238_typical" class="font-bold text-[#232D42] text-[16px]">Passing 2.38 Typical</label>
                                <div class="relative">
                                    <input type="text" name="passing_238_typical" value="{{$biomassa->passing_238_typical}}" class="input-number w-full lg:w-72 border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Passing 5 Typical">
                                    @error('passing_238_typical')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div> 
                       
                         
                        <div class="flex gap-3">
                            <a href="{{route('contracts.biomassa-contracts.spesification.index',['contractId'=>$contract->id])}}" class="bg-[#C03221] w-full h-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3 text-center">Back</a>
                            <button class="bg-[#2E46BA] h-full w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah</button>
                        </div>     
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

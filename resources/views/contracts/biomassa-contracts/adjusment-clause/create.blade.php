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
                        Tambah Klausul Penyesuaian Kontrak Biomassa
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> <a href="{{ route('contracts.biomassa-contracts.index') }}" class="cursor-pointer">  <a href="{{ route('contracts.biomassa-contracts.index') }}"> / Kontrak Biomassa  <a href="{{ route('contracts.biomassa-contracts.adjusment-clause.index',['contractId' => $contract->id]) }}"> / Klausul Penyesuaian Kontrak Biomassa / </a> <span class="text-[#2E46BA] cursor-pointer">{{$contract->contract_number}}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <div class="desc border border-slate-300  rounded shadow w-full lg:w-1/2 p-5 mb-4">
                    <span> Masa Kontrak : {{$contract->contract_start_date}} s/d {{$contract->contract_end_date}}</span> <br/>
                    <span> Perpanjangan Kontrak ( Adendum )  :</span><br/>
                    <span> Volume Total : {{number_format($contract->total_volume)}}</span>
                </div>
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Klausul Penyesuaian Kontrak Baru ?')" action="{{ route('contracts.biomassa-contracts.adjusment-clause.store',['contractId'=>$contract->id]) }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                    <small class="text-slate-700"> Untuk angka koma gunakan titik .</small>
                        <div class="w-full py-1 flex gap-3">
                            <div class="delivery">
                                <label for="price_coal_will_text" class="font-bold text-[#232D42] text-[16px]">Harga Biomassa Akan</label>
                                <div class="relative">
                                    <select name="price_coal_will_text" id="" class="w-full mt-3 lg:w-64 h-[40px] text-[19px] text-[#8A92A6] border rounded-md">
                                        <option>Bertambah</option>
                                        <option>Berkurang</option>
                                    </select>

                                    @error('price_coal_will_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                            <div class="delivery">
                                <label for="price_coal_will_number" class="font-bold text-[#232D42] text-[16px]">Sebesar</label>
                                <div class="relative">
                                    <input type="text" name="price_coal_will_number" value="{{ old('price_coal_will_number') }}" class="input-number w-full lg:w-64 border rounded-md mt-3 mb-5 h-[40px] px-3">

                                    @error('price_coal_will_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                            <div class="delivery">
                                <label for="price_coal_will_text" class="font-bold text-[#232D42] text-[16px]">Tipe Angka</label>
                                <div class="relative">
                                    <select name="price_coal_will_type_number" id="" class="w-full mt-3 lg:w-64 h-[40px] text-[19px] text-[#8A92A6] border rounded-md">
                                        <option value="percentage">% ( Persentase ) </option>
                                        <option value="rupiah">Rupiah</option>
                                    </select>

                                    @error('price_coal_will_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full py-1 flex gap-3">
                            <input type="hidden" value="{{$contract->id}}" name="contract_id">
                            <div class="delivery">
                                <label for="for_will_text" class="font-bold text-[#232D42] text-[16px]">Untuk setiap</label>
                                <div class="relative">
                                    <select name="for_will_text" id="" class="w-full mt-3 lg:w-64 h-[40px] text-[19px] text-[#8A92A6] border rounded-md">
                                        <option>Penambahan</option>
                                        <option>Pengurangan</option>
                                    </select>

                                    @error('for_will_text')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                            <div class="delivery">
                                <label for="unit_penalty_id" class="font-bold text-[#232D42] text-[16px]">Parameter</label>
                                <div class="relative">
                                    <select name="unit_penalty_id" id="" class="select-2 w-full mt-3 lg:w-64 h-[40px] text-[19px] text-[#8A92A6] border rounded-md">
                                        @foreach ($units as $unit)
                                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_penalty_id')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                            <div class="delivery">
                                <label for="for_will_number" class="font-bold text-[#232D42] text-[16px]">Sebesar</label>
                                <div class="relative">
                                    <input type="text" name="for_will_number" value="{{ old('for_will_number') }}" class="input-number w-full lg:w-64 border rounded-md mt-3 mb-5 h-[40px] px-3">

                                    @error('for_will_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                            <div class="delivery">
                                <label for="for_will_type_number" class="font-bold text-[#232D42] text-[16px]">Tipe Angka</label>
                                <div class="relative">
                                    <select name="for_will_type_number" id="" class="w-full mt-3 lg:w-64 h-[40px] text-[19px] text-[#8A92A6] border rounded-md">
                                        <option value="percentage">% ( Persentase ) </option>
                                        <option value="rupiah">Rupiah</option>
                                    </select>

                                    @error('for_will_type_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full py-1 flex gap-3">
                            <div class="delivery">
                                <label for="with_limit_text" class="font-bold text-[#232D42] text-[16px]">Dengan Batas</label>
                                <div class="relative">
                                    <select name="with_limit_text" id="" class="w-full mt-3 lg:w-64 h-[40px] text-[19px] text-[#8A92A6] border rounded-md">
                                        <option>Diatas</option>
                                        <option>Dibawah</option>
                                    </select>

                                    @error('price_coal_will_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                            <div class="delivery">
                                <label for="with_limit_number" class="font-bold text-[#232D42] text-[16px]">Sebesar</label>
                                <div class="relative">
                                    <input type="text" name="with_limit_number" value="{{ old('with_limit_number') }}" class="input-number w-full lg:w-64 border rounded-md mt-3 mb-5 h-[40px] px-3">

                                    @error('with_limit_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{route('contracts.biomassa-contracts.adjusment-clause.index',['contractId'=>$contract->id])}}" class="bg-[#C03221] w-full h-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3 text-center">Back</a>
                            <button class="bg-[#2E46BA] h-full w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

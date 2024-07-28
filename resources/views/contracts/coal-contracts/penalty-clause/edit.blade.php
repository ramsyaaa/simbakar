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
                        Ubah Denda Penolakan Kontrak Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> <a href="{{ route('contracts.coal-contracts.index') }}" class="cursor-pointer">  <a href="{{ route('contracts.coal-contracts.index') }}"> / Kontrak Batu Bara  <a href="{{ route('contracts.coal-contracts.penalty-clause.index',['contractId' => $contract->id]) }}"> / Denda Penolakan Kontrak Batu Bara / </a> <span class="text-[#2E46BA] cursor-pointer">{{$contract->contract_number}}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <div class="desc border border-slate-300  rounded shadow w-full lg:w-1/2 p-5 mb-4">
                    <span> Masa Kontrak : {{$contract->contract_start_date}} s/d {{$contract->contract_end_date}}</span> <br/>
                    <span> Perpanjangan Kontrak ( Adendum )  :</span><br/>
                    <span> Volume Total : {{number_format($contract->total_volume)}}</span>
                </div>
                <form onsubmit="return confirmSubmit(this, 'Ubah Denda Penolakan Kontrak Baru ?')" action="{{ route('contracts.coal-contracts.penalty-clause.update',['contractId'=>$contract->id,'id'=>$penalty->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="p-4 bg-white rounded-lg w-full">
                    <small class="text-slate-700"> Untuk angka koma gunakan titik .</small>
                        <div class="w-full py-1 flex gap-3">
                            <div class="delivery">
                                <label for="penalty_will_get_if_parameter" class="font-bold text-[#232D42] text-[16px]">Denda akan di berlakukan apabila</label>
                                <div class="relative">
                                    <select name="penalty_will_get_if_parameter" id="" class="w-full mt-3 lg:w-64 h-[40px] text-[19px] text-[#8A92A6] border rounded-md">
                                        <option {{$penalty->penalty_will_get_if_parameter == 'Ash' ? 'selected' : ''}}>Ash</option>
                                    </select>
                                    
                                    @error('price_coal_will_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                            <div class="delivery">
                                <label for="price_coal_will_text" class="font-bold text-[#232D42] text-[16px]">Tanda</label>
                                <div class="relative">
                                    <select name="penalty_will_get_if_sign" id="" class="w-full mt-3 lg:w-64 h-[40px] text-[19px] text-[#8A92A6] border rounded-md">
                                        <option value=">" {{$penalty->penalty_will_get_if_sign == '>' ? 'selected' : ''}}>Lebih besar </option>
                                        <option value=">=" {{$penalty->penalty_will_get_if_sign == '>=' ? 'selected' : ''}}>Lebih besar sama dengan</option>
                                        <option value="<" {{$penalty->penalty_will_get_if_sign == '<' ? 'selected' : ''}}>Kurang dari</option>
                                        <option value="<=" {{$penalty->penalty_will_get_if_sign == '<=' ? 'selected' : ''}}>Kurang dari sama dengan </option>
                                        <option value="==" {{$penalty->penalty_will_get_if_sign == '==' ? 'selected' : ''}}>Sama dengan</option>
                                    </select>
                                    
                                    @error('price_coal_will_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                            <div class="delivery">
                                <label for="penalty_will_get_if_number" class="font-bold text-[#232D42] text-[16px]">Sebesar</label>
                                <div class="relative">
                                    <input type="text" name="penalty_will_get_if_number" value="{{ $penalty->penalty_will_get_if_number }}" class="input-number w-full lg:w-64 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    
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
                                <label for="penalty_price_number" class="font-bold text-[#232D42] text-[16px]">Dengan menurankan harga sebesar</label>
                                <div class="relative">
                                    <input type="text" name="penalty_price_number" value="{{ $penalty->penalty_price_number }}" class="input-number w-full lg:w-64 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    
                                    @error('penalty_price_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                            <div class="delivery">
                                <label for="penalty_price_type_number" class="font-bold text-[#232D42] text-[16px]">Tipe Angka</label>
                                <div class="relative">
                                    <select name="penalty_price_type_number" id="" class="w-full mt-3 lg:w-64 h-[40px] text-[19px] text-[#8A92A6] border rounded-md">
                                        <option value="percentage" {{$penalty->penalty_price_type_number == 'percentage' ? 'selected' : ''}}>% ( Persentase ) </option>
                                        <option value="number" {{$penalty->penalty_price_type_number == 'number' ? 'selected' : ''}}>Angka</option>
                                    </select>
                                    
                                    @error('penalty_price_type_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                     </div>
                                     @enderror
                                </div>
                            </div>
                        </div> 
                        <div class="flex gap-3">
                            <a href="{{route('contracts.coal-contracts.penalty-clause.index',['contractId'=>$contract->id])}}" class="bg-[#C03221] w-full h-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3 text-center">Back</a>
                            <button class="bg-[#2E46BA] h-full w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah</button>
                        </div>     
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

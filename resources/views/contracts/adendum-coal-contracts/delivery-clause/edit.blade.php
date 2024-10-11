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
                        Ubah Kontrak Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> <a href="{{ route('contracts.adendum-coal-contracts.index',['contractId' => $adendum->contract_id]) }}" class="cursor-pointer">  <a href="{{ route('contracts.adendum-coal-contracts.index',['contractId' => $adendum->contract_id]) }}"> / Kontrak Batu Bara  <a href="{{ route('contracts.adendum-coal-contracts.delivery-clause.index',['adendumId' => $adendum->id]) }}"> / Klausul Pengiriman Kontrak Batu Bara / </a> <span class="text-[#2E46BA] cursor-pointer">{{$contract->contract_number}}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <div class="desc border border-slate-300  rounded shadow w-full lg:w-1/2 p-5 mb-4">
                    <span> Masa Kontrak : {{$contract->contract_start_date}} s/d {{$contract->contract_end_date}}</span> <br/>
                    <span> Perpanjangan Kontrak ( Adendum )  :</span><br/>
                    <span> Volume Total : {{number_format($contract->total_volume)}}</span>
                </div>
                <form onsubmit="return confirmSubmit(this, 'Ubah Klausul Pengiriman Kontrak Baru ?')" action="{{ route('contracts.adendum-coal-contracts.delivery-clause.update',['adendumId'=>$adendum->id,'id'=>$delivery->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="p-4 bg-white rounded-lg w-full">
                    <small class="text-slate-700"> Untuk angka koma gunakan titik .</small>

                          {{-- delivery Potensial --}}
                          <div class="w-full py-1 flex gap-3">
                            <div class="delivery">
                                <label for="delivery_date" class="font-bold text-[#232D42] text-[16px]">Bulan dan Tahun</label>
                                <div class="relative">
                                    <input type="month" name="delivery_date" value="{{ $delivery->year }}-{{$delivery->month}}" class="input-number w-full lg:w-[720px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="delivery Potensial Max">
                                    @error('delivery_date')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                          {{-- fouling Potensial --}}
                            <div class="load">
                                <label for="load" class="font-bold text-[#232D42] text-[16px]">Muatan</label>
                                <div class="relative">
                                    <input type="number" name="load" value="{{ $delivery->load }}" class="input-number w-full lg:w-[720px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Muatan">
                                    @error('load')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="rakor">
                                <label for="rakor" class="font-bold text-[#232D42] text-[16px]">Rakor</label>
                                <div class="relative">
                                    <input type="text" name="rakor" value="{{ $delivery->rakor }}" class="input-number w-full lg:w-[720px] border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="Rakor">
                                    @error('rakor')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        <div class="flex gap-3">
                            <a href="{{route('contracts.adendum-coal-contracts.delivery-clause.index',['adendumId'=>$adendum->id])}}" class="bg-[#C03221] w-full h-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3 text-center">Back</a>
                            <button class="bg-[#2E46BA] h-full w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

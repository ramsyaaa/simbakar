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
                        Tambah Sub Supplier Kontrak Biomassa
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> <a href="{{ route('contracts.biomassa-contracts.index') }}" class="cursor-pointer">  <a href="{{ route('contracts.biomassa-contracts.index') }}"> / Kontrak Biomassa  <a href="{{ route('contracts.biomassa-contracts.sub-supplier.index',['contractId' => $contract->id]) }}"> / Sub Supplier Kontrak Biomassa / </a> <span class="text-[#2E46BA] cursor-pointer">{{$contract->contract_number}}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <div class="desc border border-slate-300  rounded shadow w-full lg:w-1/2 p-5 mb-4">
                    <span> Masa Kontrak : {{$contract->contract_start_date}} s/d {{$contract->contract_end_date}}</span> <br/>
                    <span> Perpanjangan Kontrak ( Adendum )  :</span><br/>
                    <span> Volume Total : {{number_format($contract->total_volume)}}</span>
                </div>
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Sub Supplier Kontrak Baru ?')" action="{{ route('contracts.biomassa-contracts.sub-supplier.store',['contractId'=>$contract->id]) }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">

                    <div class="w-full py-1">
                        <label for="supplier_id" class="font-bold text-[#232D42] text-[16px]">Nama Supplier</label>
                        <div class="relative">
                            <select name="supplier_id" id="" class="select-2 w-full lg:w-[600px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option selected disabled>Pilih Supplier</option>
                                @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                            <div class="absolute -bottom-1 left-1 text-red-500">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div> 
                        <div class="flex gap-3">
                            <a href="{{route('contracts.biomassa-contracts.sub-supplier.index',['contractId'=>$contract->id])}}" class="bg-[#C03221] w-full h-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3 text-center">Back</a>
                            <button class="bg-[#2E46BA] h-full w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah</button>
                        </div>     
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

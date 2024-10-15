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
                        Tambah Adendum Kontrak Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('contracts.adendum-coal-contracts.index',['contractId'=>$contract->id]) }}" class="cursor-pointer">Adendum Kontrak Batu Bara</a> / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Data Kontrak Batubara?')" action="{{ route('contracts.adendum-coal-contracts.storeContract',['contractId' => $contract->id,'adendumId' => $adendum->id]) }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="flex gap-5">
                            <div class="left">
                                <div class="w-full py-1">
                                    <label for="contract_number" class="font-bold text-[#232D42] text-[16px]">Nomor Kontrak</label>
                                    <div class="relative">
                                        <input disabled type="text" value="{{ $contract->contract_number }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('contract_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="supplier_id" class="font-bold text-[#232D42] text-[16px]">Nama Supplier</label>
                                    <div class="relative">
                                        <select id="" class="w-full lg:w-[600px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                            <option selected disabled>Pilih Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                            <option {{$contract->supplier_id == $supplier->id ? 'selected' :''}} value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="contract_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Kontrak</label>
                                    <div class="relative">
                                        <input disabled type="date" value="{{ $contract->contract_date }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('contract_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="type_contract" class="font-bold text-[#232D42] text-[16px]">Tipe Kontrak</label>
                                    <div class="relative">
                                        <select id="" class="w-full lg:w-[600px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                            <option selected disabled>Pilih Tipe Kontrak</option>
                                            <option {{$contract->type_contract == 'Jangka Panjang' ? 'selected' :''}}>Jangka Panjang</option>
                                            <option {{$contract->type_contract == 'Jangka Menengah' ? 'selected' :''}}>Jangka Menengah</option>
                                            <option {{$contract->type_contract == 'Spot' ? 'selected' :''}}>Spot</option>
                                        </select>
                                        @error('type_contract')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="kind_contract" class="font-bold text-[#232D42] text-[16px]">Jenis Kontrak</label>
                                    <div class="relative">
                                        <select id="" class="w-full lg:w-[600px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                            <option selected disabled>Pilih Jenis Kontrak</option>
                                            <option {{$contract->kind_contract == 'FOB' ? 'selected' :''}}>FOB</option>
                                            <option {{$contract->kind_contract == 'CIF' ? 'selected' :''}}>CIF</option>
                                        </select>
                                        @error('kind_contract')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="total_volume" class="font-bold text-[#232D42] text-[16px]">Volume Total</label>
                                    <div class="relative">
                                        <input disabled type="text" value="{{ $contract->total_volume }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('total_volume')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="price" class="font-bold text-[#232D42] text-[16px]">Harga Satuan per Kg</label>
                                    <div class="relative">
                                        <input disabled type="text" value="{{ $contract->price }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('price')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="contract_start_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Mulai Kontrak</label>
                                    <div class="relative">
                                        <input disabled type="date" value="{{ $contract->contract_start_date }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('contract_start_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="contract_end_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Selesai Kontrak</label>
                                    <div class="relative">
                                        <input disabled type="date" value="{{ $contract->contract_end_date }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('contract_end_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="right">
                                <div class="w-full py-1">
                                    <label for="contract_number" class="font-bold text-[#232D42] text-[16px]">Nomor Kontrak</label>
                                    <div class="relative">
                                        <input readonly name="contract_number" type="text" value="{{ $contract->contract_number }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('contract_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="supplier_id" class="font-bold text-[#232D42] text-[16px]">Nama Supplier</label>
                                    <div class="relative">
                                        <select readonly id="" name="supplier_id" class="w-full lg:w-[600px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                            <option selected disabled>Pilih Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                            <option {{$contract->supplier_id == $supplier->id ? 'selected' :'disabled'}} value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="contract_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Kontrak</label>
                                    <div class="relative">
                                        <input name="contract_date" type="date" value="{{ $coal->contract_date ?? '' }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('contract_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="type_contract" class="font-bold text-[#232D42] text-[16px]">Tipe Kontrak</label>
                                    <div class="relative">
                                        <select name="type_contract" id="" class="w-full lg:w-[600px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                            <option selected disabled>Pilih Tipe Kontrak</option>
                                            @if ($coal)
                                                <option {{$coal->type_contract == 'Jangka Panjang' ? 'selected' :''}}>Jangka Panjang</option>
                                                <option {{$coal->type_contract == 'Jangka Menengah' ? 'selected' :''}}>Jangka Menengah</option>
                                                <option {{$coal->type_contract == 'Spot' ? 'selected' :''}}>Spot</option>
                                            @else
                                                <option>Jangka Panjang</option>
                                                <option>Jangka Menengah</option>
                                                <option>Spot</option>
                                            @endif


                                        </select>
                                        @error('type_contract')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="kind_contract" class="font-bold text-[#232D42] text-[16px]">Jenis Kontrak</label>
                                    <div class="relative">
                                        <select name="kind_contract" id="" class="w-full lg:w-[600px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                            <option selected disabled>Pilih Jenis Kontrak</option>
                                            @if ($coal)
                                                <option {{$coal->kind_contract == 'FOB' ? 'selected' :''}}>FOB</option>
                                                <option {{$coal->kind_contract == 'CIF' ? 'selected' :''}}>CIF</option>
                                            @else
                                                <option>FOB</option>
                                                <option>CIF</option>
                                            @endif

                                        </select>
                                        @error('kind_contract')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="total_volume" class="font-bold text-[#232D42] text-[16px]">Volume Total</label>
                                    <div class="relative">
                                        <input type="text" name="total_volume" value="{{ $coal->total_volume ?? '' }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('total_volume')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="price" class="font-bold text-[#232D42] text-[16px]">Harga Satuan per Kg</label>
                                    <div class="relative">
                                        <input type="text" name="price" value="{{ $coal->price ?? '' }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('price')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="contract_start_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Mulai Kontrak</label>
                                    <div class="relative">
                                        <input type="date" name="contract_start_date" value="{{ $coal->contract_start_date  ?? ''}}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('contract_start_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full py-1">
                                    <label for="contract_end_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Selesai Kontrak</label>
                                    <div class="relative">
                                        <input type="date" name="contract_end_date" value="{{ $coal->contract_end_date ?? ''}}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('contract_end_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>


                        <a href="{{ route('contracts.adendum-coal-contracts.index',['contractId'=>$contract->id]) }}" class="bg-[#C03221] w-full lg:w-[600px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

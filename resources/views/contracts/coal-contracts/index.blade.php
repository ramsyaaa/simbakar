@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        List Kontrak Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Kontrak Batu Bara</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('contracts.coal-contracts.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('contracts.coal-contracts.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <div class="mb-2 lg:mb-0">
                            <select name="supplier_id" id="" class="w-full lg:w-[600px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option selected disabled>Pilih Supplier</option>
                                @foreach ($suppliers as $supplier)
                                <option @if($supplier->id == request()->supplier_id ) selected @endif value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">No</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Nomor Kontrak</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]"></th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]"></th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coals as $coal)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">
                                    <a href="{{ route('contracts.coal-contracts.edit',['uuid'=>$coal->uuid]) }}" class="text-sky-700">
                                        {{ $coal->contract_number }}
                                    </a>
                                    <br/>
                                    <span>Jenis : {{$coal->kind_contract}}</span>
                                    <br/>
                                    [Ada Adendum]
                                    <br/>
                                    <span>Jenis Kontrak Baru : {{$coal->kind_contract}}</span>
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">
                                    <ul class="text-center">
                                        <li>
                                            <a href="{{route('contracts.coal-contracts.spesification.index',['contractId' => $coal->id])}}" class="text-sky-700 hover:text-sky-900">
                                                Spesifikasi Batubara ( {{$coal->spesifications->count()}} )
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('contracts.coal-contracts.delivery-clause.index',['contractId' => $coal->id])}}" class="text-sky-700 hover:text-sky-900">
                                                Klausul Pengiriman
                                            </a>
                                           
                                        </li>
                                        <li>
                                            <a href="{{route('contracts.coal-contracts.adjusment-clause.index',['contractId' => $coal->id])}}" class="text-sky-700 hover:text-sky-900">
                                                Klausul Penyesuaian
                                            </a>
                                           
                                        </li>
                                    </ul>
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">
                                    <ul class="text-center">
                                        <li>
                                            <a href="{{route('contracts.coal-contracts.penalty-clause.index',['contractId' => $coal->id])}}" class="text-sky-700 hover:text-sky-900">
                                                Klausul Denda Penolakan
                                            </a>
                                            
                                        </li>
                                    </ul>
                                </td>

                                <td class="h-[36px] text-[16px] font-normal border px-2 ">
                                    <div class="flex items-center justify-center gap-2">
{{-- 
                                        <a href="{{ route('contracts.coal-contracts.edit', ['uuid' => $coal->uuid]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                            Edit
                                        </a> --}}
                                        <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('contracts.coal-contracts.destroy', ['uuid' => $coal->uuid]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="bg-[#C03221] text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $coals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

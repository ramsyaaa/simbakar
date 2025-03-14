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
                        Penerimaan Biomassa
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Penerimaan Biomassa</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('inputs.biomassa_receipts.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('inputs.biomassa_receipts.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <div class="w-full mb-2 lg:mb-0">
                            <select id="year" name="year" class="w-[350px] h-[44px] rounded-md border px-2" autofocus>
                                <option selected disabled>Pilih Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option {{request()->year == $i ? 'selected' :''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border text-white bg-[#047A96] h-[52px] text-center">No</th>
                                <th class="border text-white bg-[#047A96] h-[52px] text-center">Pemasok</th>
                                <th class="border text-white bg-[#047A96] h-[52px] text-center">Tanggal Penerimaan</th>
                                <th class="border text-white bg-[#047A96] h-[52px] text-center">No TUG 3</th>
                                <th class="border text-white bg-[#047A96] h-[52px] text-center">Total Penerimaan</th>
                                <th class="border text-white bg-[#047A96] h-[52px]"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($receipts as $item)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->supplier != null ? $item->supplier->name : '-' }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ isset($item->detailReceipt[0]) ? date('d-m-Y', strtotime($item->detailReceipt[0]->end_date_unloading)) : '' }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->tug3_number }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format($item->total_volume) }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('inputs.biomassa_receipts.edit', ['id' => $item->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('inputs.biomassa_receipts.destroy', ['id' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="bg-[#C03221] text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $receipts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

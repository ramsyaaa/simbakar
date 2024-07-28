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
                        Penerimaan BBM
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Penerimaan BBM</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('inputs.bbm_receipts.create', ['shipment_type' => $shipment_type]) }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="w-full flex gap-4 items-center my-4">
                <a href="{{ route('inputs.bbm_receipts.index', ['shipment_type' => "ship"]) }}" class="w-3/12 px-3 py-2 @if($shipment_type == 'ship') bg-[#2E46BA] @else bg-[#6C757D] @endif text-white text-center font-bold rounded-lg">
                    Penerimaan Melalui Kapal
                </a>
                <a href="{{ route('inputs.bbm_receipts.index', ['shipment_type' => "car"]) }}" class="w-3/12 px-3 py-2 @if($shipment_type == 'car') bg-[#2E46BA] @else bg-[#6C757D] @endif text-white text-center font-bold rounded-lg">
                    Penerimaan Melalui Mobil
                </a>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('inputs.bbm_receipts.index', ['shipment_type' => $shipment_type]) }}" method="GET" id="filterForm">
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
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Tanggal</th>
                                @if($shipment_type == 'ship')
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Pemasok, Kapal</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Dermaga</th>
                                @endif
                                @if($shipment_type == 'car')
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Mobil</th>
                                @endif
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Detail</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loadings as $item)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">@if($shipment_type == 'ship') {{ \Carbon\Carbon::parse($item->load_date)->format('d F Y') }} - @endif {{ \Carbon\Carbon::parse($item->unload_date)->format('d F Y') }}</td>
                                @if($shipment_type == 'ship')
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->supplier != null ? $item->supplier->name : '-' }} <br> {{ $item->ship != null ? $item->ship->name : '-' }} </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->dock != null ? $item->dock->name : '-' }}</td>
                                @endif
                                @if($shipment_type == 'car')
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->car_type }}</td>
                                @endif
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('inputs.bbm_receipts.edit', ['shipment_type' => $shipment_type, 'id' => $item->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('inputs.bbm_receipts.destroy', ['shipment_type' => $shipment_type, 'id' => $item->id]) }}" method="POST">
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
                    {{ $loadings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

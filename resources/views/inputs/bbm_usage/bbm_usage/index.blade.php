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
                        Pemakaian BBM
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Pemakaian BBM</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('inputs.bbm_usage.create', ['bbm_use_for' => $bbm_use_for]) }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="w-full flex gap-4 items-center my-4">
                <a href="{{ route('inputs.bbm_usage.index', ['bbm_use_for' => "unit"]) }}" class="w-3/12 px-3 py-2 @if($bbm_use_for == 'unit') bg-[#2E46BA] @else bg-[#6C757D] @endif text-white text-center font-bold rounded-lg">
                    Pemakaian BBM untuk Unit
                </a>
                <a href="{{ route('inputs.bbm_usage.index', ['bbm_use_for' => "heavy_equipment"]) }}" class="w-3/12 px-3 py-2 @if($bbm_use_for == 'heavy_equipment') bg-[#2E46BA] @else bg-[#6C757D] @endif text-white text-center font-bold rounded-lg">
                    Pemakaian BBM untuk Albes
                </a>
                <a href="{{ route('inputs.bbm_usage.index', ['bbm_use_for' => "other"]) }}" class="w-3/12 px-3 py-2 @if($bbm_use_for == 'other') bg-[#2E46BA] @else bg-[#6C757D] @endif text-white text-center font-bold rounded-lg">
                    Pemakaian BBM untuk Lainnya
                </a>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('inputs.bbm_usage.index', ['bbm_use_for' => $bbm_use_for]) }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <div class="w-full mb-2 lg:mb-0">
                            <input name="date" type="date" value="{{ $date }}" class="w-[350px] h-[44px] rounded-md border px-2">
                        </div>
                        @if($bbm_use_for == 'unit')
                        <div class="w-full mb-2 lg:mb-0 flex gap-4 items-center">
                            <div class="font-bold">
                                Unit :
                            </div>
                            <select name="unit_uuid" class="w-[350px] h-[44px] rounded-md border px-2">
                                <option value="">Pilih</option>
                                @foreach ($units as $unit)
                                    <option {{ isset($unit_uuid) && $unit_uuid == $unit->uuid ? 'selected' : '' }} value="{{ $unit->uuid }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Tanggal</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">No TUG9</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Pemakaian</th>
                                @if($bbm_use_for == 'unit')
                                <th class="border text-white bg-[#047A96] h-[52px]">Unit</th>
                                @endif
                                @if($bbm_use_for == 'heavy_equipment')
                                <th class="border text-white bg-[#047A96] h-[52px]">Albes</th>
                                @endif
                                @if($bbm_use_for == 'other')
                                <th class="border text-white bg-[#047A96] h-[52px]">Keterangan</th>
                                @endif
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bbm_usages as $item)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ \Carbon\Carbon::parse($item->use_date)->format('d/m/Y') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->tug9_number }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ number_format($item->amount) }}</td>
                                @if($bbm_use_for == 'unit')
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->unit != null ? $item->unit->name : '-' }}</td>
                                @endif
                                @if($bbm_use_for == 'heavy_equipment')
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->heavyEquipment != null ? $item->heavyEquipment->name : '-' }}</td>
                                @endif
                                @if($bbm_use_for == 'other')
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->description }}</td>
                                @endif
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('inputs.bbm_usage.edit', ['bbm_use_for' => $bbm_use_for, 'id' => $item->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('inputs.bbm_usage.destroy', ['bbm_use_for' => $bbm_use_for, 'id' => $item->id]) }}" method="POST">
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
                    {{ $bbm_usages->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

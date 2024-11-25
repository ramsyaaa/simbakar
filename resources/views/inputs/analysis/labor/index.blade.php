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
                        Labor
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Analisa</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('inputs.analysis.labors.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="w-full flex gap-4 items-center my-4">
                <a href="{{ route('inputs.analysis.preloadings.index') }}" class="w-3/12 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    Preloading
                </a>
                <a href="{{ route('inputs.analysis.loadings.index') }}" class="w-3/12 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    Loading
                </a>
                <a href="{{ route('inputs.analysis.labors.index') }}" class="w-3/12 px-3 py-2 bg-[#2E46BA] text-white text-center font-bold rounded-lg">
                    Labour
                </a>
                <a href="{{ route('inputs.analysis.unloadings.index') }}" class="w-3/12 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    Unloading
                </a>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('inputs.analysis.labors.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <div class="w-full mb-4">
                            <label for="ship_uuid" class="w-4/12 font-bold text-[#232D42] text-[16px] mr-5">Tanggal Analisa</label>
                            <input type="month" name="month"
                                class="border h-[40px] w-9/16 rounded-lg px-3"
                                value="{{ request('month') }}" min="2000" max="2100">
                        </div>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Tanggal Bongkar</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Nama Kapal</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">No Analisa</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($labors as $item)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ \Carbon\Carbon::parse($item->start_unloading)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($item->end_unloading)->format('d-m-Y') }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->ship != null ? $item->ship->name : '-' }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $item->analysis_number }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('inputs.analysis.labors.edit', ['id' => $item->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('inputs.analysis.labors.destroy', ['id' => $item->id]) }}" method="POST">
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
                    {{ $labors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

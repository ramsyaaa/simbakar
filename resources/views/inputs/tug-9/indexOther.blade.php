@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="w-full flex gap-4 items-center my-4">
                <a href="{{ route('inputs.tug-3.index') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    TUG 3
                </a>
                <a href="#" class="w-1/2 px-3 py-2 bg-[#2E46BA] text-white text-center font-bold rounded-lg">
                    TUG 9
                </a>
                <a href="{{ route('inputs.tug-12.index') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    TUG 12
                </a>
                <a href="{{ route('inputs.tug-11.index') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    TUG 11
                </a>
                <a href="{{ route('inputs.tug-4.index') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    TUG 4
                </a>
            </div>
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        List TUG 9
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="cursor-pointer">TUG 9</span>
                    </div>
                </div>
            </div>
            <div class="w-full flex gap-4 items-center my-4">
                <a href="{{ route('inputs.tug-9.index-coal') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    Batu Bara
                </a>
                <a href="{{ route('inputs.tug-9.index-unit') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                   BBM untuk Unit
                </a>
                <a href="{{ route('inputs.tug-9.index-heavy') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    BBM untuk Albes
                </a>
                <a href="#" class="w-1/2 px-3 py-2 bg-[#2E46BA] text-white text-center font-bold rounded-lg">
                    BBM lain lain
                </a>
            </div>
            <div class="bg-white rounded-lg p-6 h-full">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('inputs.tug-9.index-other') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center gap-5 w-full mb-3">
                        <label for="" class="font-bold text-[#232D42] text-[16px]">Tanggal </label>
                        <input name="date" type="month" value="{{ request()->date ?? '' }}" class="w-full lg:w-3/12 h-[44px] rounded-md border px-2" placeholder="Cari Data" autofocus>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>

                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Tanggal</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">No Tug 9</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Jumlah Pemakaian</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Jenis BBM</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tugs as $tug)
                            <tr>
                                <td class="text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="text-[16px] font-normal border px-2 text-center">{{ $tug->use_date }}</td>
                                <td class="text-[16px] font-normal border px-2 text-center">{{ $tug->tug9_number }}</td>
                                <td class="text-[16px] font-normal border px-2 text-center">{{ number_format($tug->amount_use) }}</td>
                                <td class="text-[16px] font-normal border px-2 text-center">{{ $tug->bbm_type }}</td>
                                <td class="text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{route('inputs.tug-9.detail-other',['id'=>$tug->id])}}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $tugs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

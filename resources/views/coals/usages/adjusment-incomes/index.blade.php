@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="w-full flex gap-4 items-center my-4">
                <a href="#" class="w-1/2 px-3 py-2 bg-[#2E46BA] text-white text-center font-bold rounded-lg">
                    BA Penyesuaian Persediaan Bahan Bakar
                </a>
                <a href="{{ route('coals.usages.adjusment-outcomes.index') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    BA Penyesuaian ( Dibeli ) Perusahaan Lain
                </a>
            </div>
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        List BA Penyesuaian Persediaan Bahan Bakar
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="cursor-pointer">BA Penyesuaian Persediaan Bahan Bakar </span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('coals.usages.adjusment-incomes.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>

            </div>

            <div class="bg-white rounded-lg p-6 h-full">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('coals.usages.adjusment-incomes.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center gap-5 w-full mb-3">
                        <label for="" class="font-bold text-[#232D42] text-[16px]">BA Penyesuaian Persediaan Bahan Bakar </label>
                        <input name="date" type="month" value="{{ request()->date ?? '' }}" class="w-full lg:w-3/12 h-[44px] rounded-md border px-2" placeholder="Cari Data" autofocus>
                        <select id="day" name="day" class="w-[350px] h-[44px] rounded-md border px-2" autofocus>
                            <option selected disabled>Pilih Index Tanggal</option>
                            @for ($i = 1; $i <= 31; $i++)
                                <option {{request()->day == $i ? 'selected' :''}}>{{ $i }}</option>
                            @endfor
                        </select>
                        <select id="fuel" name="fuel" class="w-[350px] h-[44px] rounded-md border px-2" autofocus>
                            <option selected disabled>Jenis Bahan Bakar</option>
                            <option> Batu Bara</option>
                            <option> HSD / Solar</option>
                            <option> MFO / Residu</option>
                        </select>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>

                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Tanggal</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">No BA</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Jumlah Pemakaian</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adjusments as $adjusment)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $adjusment->usage_date }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $adjusment->ba_number }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ number_format($adjusment->usage_amount) }}</td>
                                <td class="h-[108px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('coals.usages.adjusment-incomes.edit', ['id' => $adjusment->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('coals.usages.adjusment-incomes.destroy', ['id' => $adjusment->id]) }}" method="POST">
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
                    {{ $adjusments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

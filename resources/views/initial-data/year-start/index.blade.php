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
                        Data Awal Tahun
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Data Awal Tahun</span>
                    </div>
                </div>
            </div>
            <div x-data="{ selectedFuel: 'batubara', batubara: true, solar: false, residu: false }" class="bg-white rounded-lg p-6">
                <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                    <div class="mb-2 lg:mb-0">
                        <select x-model="selectedFuel" @change="batubara = selectedFuel === 'batubara'; solar = selectedFuel === 'solar'; residu = selectedFuel === 'residu';" name="year" id="" class="w-full lg:w-[200px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option value="batubara">Batubara</option>
                            <option value="solar">Solar</option>
                            <option value="residu">Residu</option>
                        </select>
                    </div>
                </div>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table x-cloak x-show="batubara" class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Tahun</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana Perencanaan Awal (Kg)</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Realisasi Persediaan Awal (Kg)</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($start_years['batubara'] as $start_data)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $start_data->settingBpb->year }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $start_data->planning }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $start_data->actual }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('initial-data.year-start.edit', ['uuid' => $start_data->uuid]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table x-cloak x-show="solar" class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Tahun</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana Perencanaan Awal (Liter)</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Realisasi Persediaan Awal (Liter)</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($start_years['solar'] as $start_data)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $start_data->settingBpb->year }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $start_data->planning }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $start_data->actual }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('initial-data.year-start.edit', ['uuid' => $start_data->uuid]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table x-cloak x-show="residu" class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Tahun</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana Perencanaan Awal (Liter)</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Realisasi Persediaan Awal (Liter)</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($start_years['residu'] as $start_data)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $start_data->settingBpb->year }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $start_data->planning }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $start_data->actual }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('initial-data.year-start.edit', ['uuid' => $start_data->uuid]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

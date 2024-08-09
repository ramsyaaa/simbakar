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
                        Rencana Pemakaian
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Rencana Pemakaian</span>
                    </div>
                </div>
            </div>
            <div x-data="{ selectedFuel: 'batubara', batubara: true, solar: false, residu: false }" class="bg-white rounded-lg p-6">
                <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                    <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('initial-data.consuption-plan.index') }}" method="GET" id="filterForm">
                        <div class="mb-2 lg:mb-0">
                            <select name="year" id="" class="w-full lg:w-[200px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Tahun</option>
                                @foreach ($years as $year)
                                <option @if($year->uuid == $bpb->uuid) selected @endif value="{{ $year->uuid }}">{{ $year->year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <div class="mb-2 lg:mb-0">
                        <select x-model="selectedFuel" @change="batubara = selectedFuel === 'batubara'; solar = selectedFuel === 'solar'; residu = selectedFuel === 'residu';" name="year" id="" class="w-full lg:w-[200px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option value="batubara">Batubara</option>
                            <option value="solar">Solar</option>
                            <option value="residu">Residu</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2 mb-3">
                    <a href="{{ route('initial-data.settings-bpb.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table x-cloak x-show="batubara" class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Bulan</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana Pemakaian Batubara (Kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consumption_plans['batubara'] as $plan)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Januari</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_january }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Februari</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_february }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Maret</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_march }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">April</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_april }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Mei</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_may }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Juni</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_june }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Juli</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_july }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Agustus</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_august }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">September</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_september }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Oktober</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_october }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">November</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_november }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Desember</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_december }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-bold border px-2">Total</td>
                                <td class="h-[36px] text-[16px] font-bold border px-2">
                                    {{
                                        $plan->planning_january +
                                        $plan->planning_february +
                                        $plan->planning_march +
                                        $plan->planning_april +
                                        $plan->planning_may +
                                        $plan->planning_june +
                                        $plan->planning_july +
                                        $plan->planning_august +
                                        $plan->planning_september +
                                        $plan->planning_october +
                                        $plan->planning_november +
                                        $plan->planning_december
                                    }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div x-cloak x-show="batubara" class="mt-10 w-full flex justify-center">
                        <a href="{{ route('initial-data.consuption-plan.edit', ['uuid' => $plan->uuid]) }}" class="px-4 py-2 rounded-lg bg-[#135F9C] text-white font-bold">Update</a>
                    </div>
                    <table x-cloak x-show="solar" class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Bulan</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana Pemakaian Solar (Liter)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consumption_plans['solar'] as $plan)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Januari</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_january }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Februari</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_february }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Maret</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_march }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">April</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_april }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Mei</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_may }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Juni</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_june }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Juli</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_july }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Agustus</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_august }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">September</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_september }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Oktober</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_october }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">November</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_november }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Desember</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_december }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-bold border px-2">Total</td>
                                <td class="h-[36px] text-[16px] font-bold border px-2">
                                    {{
                                        $plan->planning_january +
                                        $plan->planning_february +
                                        $plan->planning_march +
                                        $plan->planning_april +
                                        $plan->planning_may +
                                        $plan->planning_june +
                                        $plan->planning_july +
                                        $plan->planning_august +
                                        $plan->planning_september +
                                        $plan->planning_october +
                                        $plan->planning_november +
                                        $plan->planning_december
                                    }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div x-cloak x-show="solar" class="mt-10 w-full flex justify-center">
                        <a href="{{ route('initial-data.consuption-plan.edit', ['uuid' => $plan->uuid]) }}" class="px-4 py-2 rounded-lg bg-[#135F9C] text-white font-bold">Update</a>
                    </div>
                    <table x-cloak x-show="residu" class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Bulan</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana Pemakaian Residu (Liter)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consumption_plans['residu'] as $plan)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Januari</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_january }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Februari</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_february }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Maret</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_march }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">April</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_april }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Mei</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_may }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Juni</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_june }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Juli</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_july }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Agustus</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_august }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">September</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_september }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Oktober</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_october }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">November</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_november }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Desember</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $plan->planning_december }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-bold border px-2">Total</td>
                                <td class="h-[36px] text-[16px] font-bold border px-2">
                                    {{
                                        $plan->planning_january +
                                        $plan->planning_february +
                                        $plan->planning_march +
                                        $plan->planning_april +
                                        $plan->planning_may +
                                        $plan->planning_june +
                                        $plan->planning_july +
                                        $plan->planning_august +
                                        $plan->planning_september +
                                        $plan->planning_october +
                                        $plan->planning_november +
                                        $plan->planning_december
                                    }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div x-cloak x-show="residu" class="mt-10 w-full flex justify-center">
                        <a href="{{ route('initial-data.consuption-plan.edit', ['uuid' => $plan->uuid]) }}" class="px-4 py-2 rounded-lg bg-[#135F9C] text-white font-bold">Update</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
                        Produksi Listrik (GWh)
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Produksi Listrik</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 mb-3">
                <a href="{{ route('initial-data.electricity-production.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                    Tambah Data
                </a>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('initial-data.electricity-production.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <div class="mb-2 lg:mb-0">
                            <select name="year" id="" class="w-full lg:w-[200px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Tahun</option>
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
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Bulan</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Realisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Januari</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_january ?? 0 }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_january ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Februari</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_february ?? 0 }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_february ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Maret</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_march ?? 0 }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_march ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">April</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_april ?? 0 }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_april ?? 0}}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Mei</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_may ?? 0 }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_may ?? 0}}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Juni</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_june ?? 0}}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_june ?? 0}}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Juli</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_july ?? 0}}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_july ?? 0}}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Agustus</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_august ?? 0 }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_august ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">September</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_september ?? 0 }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_september ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Oktober</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_october ?? 0 }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_october  ?? 0}}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">November</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_november ?? 0 }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_november ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Desember</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->planning_december ?? 0 }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $electric_production->actual_december ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-bold border px-2">Total</td>
                                <td class="h-[36px] text-[16px] font-bold border px-2">
                                    @if ($electric_production)
                                        {{
                                            $electric_production->planning_january +
                                            $electric_production->planning_february +
                                            $electric_production->planning_march +
                                            $electric_production->planning_april +
                                            $electric_production->planning_may +
                                            $electric_production->planning_june +
                                            $electric_production->planning_july +
                                            $electric_production->planning_august +
                                            $electric_production->planning_september +
                                            $electric_production->planning_october +
                                            $electric_production->planning_november +
                                            $electric_production->planning_december
                                        }}
                                    @else
                                        0
                                    @endif
                                    
                                </td>
                                <td class="h-[36px] text-[16px] font-bold border px-2">
                                    @if ($electric_production)
                                        {{
                                            $electric_production->actual_january +
                                            $electric_production->actual_february +
                                            $electric_production->actual_march +
                                            $electric_production->actual_april +
                                            $electric_production->actual_may +
                                            $electric_production->actual_june +
                                            $electric_production->actual_july +
                                            $electric_production->actual_august +
                                            $electric_production->actual_september +
                                            $electric_production->actual_october +
                                            $electric_production->actual_november +
                                            $electric_production->actual_december
                                        }}
                                    @else
                                        0
                                    @endif
                                   
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-10 w-full flex justify-center">
                    @if ($electric_production)   
                        <a href="{{ route('initial-data.electricity-production.edit', ['uuid' => $electric_production->uuid]) }}" class="px-4 py-2 rounded-lg bg-[#135F9C] text-white font-bold">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

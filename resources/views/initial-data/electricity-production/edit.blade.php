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
                        Produksi Listrik (GWh) {{ $electric_production->settingBpb->year }}
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('initial-data.electricity-production.index') }}" class="cursor-pointer">Produksi Listrik</a> / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <form action="{{ route('initial-data.electricity-production.update', ['uuid' => $electric_production->uuid]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white rounded-lg p-6">
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
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_january" value="{{ old('planning_january') ? old('planning_january') : $electric_production->planning_january }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_january" value="{{ old('actual_january') ? old('actual_january') : $electric_production->actual_january }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Februari</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_february" value="{{ old('planning_february') ? old('planning_february') : $electric_production->planning_february }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_february" value="{{ old('actual_february') ? old('actual_february') : $electric_production->actual_february }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Maret</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_march" value="{{ old('planning_march') ? old('planning_march') : $electric_production->planning_march }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_march" value="{{ old('actual_march') ? old('actual_march') : $electric_production->actual_march }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">April</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_april" value="{{ old('planning_april') ? old('planning_april') : $electric_production->planning_april }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_april" value="{{ old('actual_april') ? old('actual_april') : $electric_production->actual_april }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Mei</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_may" value="{{ old('planning_may') ? old('planning_may') : $electric_production->planning_may }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_may" value="{{ old('actual_may') ? old('actual_may') : $electric_production->actual_may }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Juni</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_june" value="{{ old('planning_june') ? old('planning_june') : $electric_production->planning_june }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_june" value="{{ old('actual_june') ? old('actual_june') : $electric_production->actual_june }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Juli</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_july" value="{{ old('planning_july') ? old('planning_july') : $electric_production->planning_july }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_july" value="{{ old('actual_july') ? old('actual_july') : $electric_production->actual_july }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Agustus</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_august" value="{{ old('planning_august') ? old('planning_august') : $electric_production->planning_august }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_august" value="{{ old('actual_august') ? old('actual_august') : $electric_production->actual_august }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">September</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_september" value="{{ old('planning_september') ? old('planning_september') : $electric_production->planning_september }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_september" value="{{ old('actual_september') ? old('actual_september') : $electric_production->actual_september }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Oktober</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_october" value="{{ old('planning_october') ? old('planning_october') : $electric_production->planning_october }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_october" value="{{ old('actual_october') ? old('actual_october') : $electric_production->actual_october }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">November</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_november" value="{{ old('planning_november') ? old('planning_november') : $electric_production->planning_november }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_november" value="{{ old('actual_november') ? old('actual_november') : $electric_production->actual_november }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Desember</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_december" value="{{ old('planning_december') ? old('planning_december') : $electric_production->planning_december }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_december" value="{{ old('actual_december') ? old('actual_december') : $electric_production->actual_december }}" class="w-full border">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-10 w-full flex justify-center">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-[#135F9C] text-white font-bold">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('initial-data.electricity-production.index') }}" class="cursor-pointer">Produksi Listrik</a> / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <form action="{{ route('initial-data.electricity-production.store') }}" method="POST">
                @csrf
                <div class="bg-white rounded-lg p-6">
                    <div class="overflow-auto hide-scrollbar max-w-full">
                        <div class="w-full">
                            <label for="year" class="font-bold text-[#232D42] text-[16px]">Tahun</label>
                            <div class="relative">
                                <input required type="number" name="year" class="w-full lg:w-3/12 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                @error('year')
                                <div class="absolute -bottom-1 left-1 text-red-500">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
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
                                        <input type="text" name="planning_january" value="{{ old('planning_january') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_january" value="{{ old('actual_january') }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Februari</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_february" value="{{ old('planning_february') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_february" value="{{ old('actual_february') }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Maret</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_march" value="{{ old('planning_march') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_march" value="{{ old('actual_march') }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">April</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_april" value="{{ old('planning_april') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_april" value="{{ old('actual_april') }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Mei</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_may" value="{{ old('planning_may') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_may" value="{{ old('actual_may') }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Juni</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_june" value="{{ old('planning_june') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_june" value="{{ old('actual_june') }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Juli</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_july" value="{{ old('planning_july') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_july" value="{{ old('actual_july') }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Agustus</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_august" value="{{ old('planning_august') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_august" value="{{ old('actual_august') }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">September</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_september" value="{{ old('planning_september') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_september" value="{{ old('actual_september') }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Oktober</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_october" value="{{ old('planning_october') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_october" value="{{ old('actual_october') }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">November</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_november" value="{{ old('planning_november') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_november" value="{{ old('actual_november') }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Desember</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_december" value="{{ old('planning_december') }}" class="w-full border">
                                    </td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="actual_december" value="{{ old('actual_december') }}" class="w-full border">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-10 w-full flex justify-center">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-[#135F9C] text-white font-bold">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

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
                        Rencana Penerimaan Biomassa Tahun {{ $biomassa_receipt_plan->year }}
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('initial-data.biomassa-receipt-plan.index') }}" class="cursor-pointer">Rencana Penerimaan Biomassa</a> / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <form action="{{ route('initial-data.biomassa-receipt-plan.update', ['uuid' => $biomassa_receipt_plan->uuid]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-lg p-6">
                    <div class="w-full">
                        <label for="year" class="font-bold text-[#232D42] text-[16px]">Tahun</label>
                        <div class="relative">
                            <input required type="number" name="year" class="w-full lg:w-3/12 border rounded-md mt-3 mb-5 h-[40px] px-3" value="{{$biomassa_receipt_plan->year}}">
                            @error('year')
                            <div class="absolute -bottom-1 left-1 text-red-500">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="overflow-auto hide-scrollbar max-w-full">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Bulan</th>
                                    <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana (Kg)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Januari</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_january" value="{{ old('planning_january') ? old('planning_january') : $biomassa_receipt_plan->planning_january }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Februari</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_february" value="{{ old('planning_february') ? old('planning_february') : $biomassa_receipt_plan->planning_february }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Maret</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_march" value="{{ old('planning_march') ? old('planning_march') : $biomassa_receipt_plan->planning_march }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">April</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_april" value="{{ old('planning_april') ? old('planning_april') : $biomassa_receipt_plan->planning_april }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Mei</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_may" value="{{ old('planning_may') ? old('planning_may') : $biomassa_receipt_plan->planning_may }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Juni</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_june" value="{{ old('planning_june') ? old('planning_june') : $biomassa_receipt_plan->planning_june }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Juli</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_july" value="{{ old('planning_july') ? old('planning_july') : $biomassa_receipt_plan->planning_july }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Agustus</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_august" value="{{ old('planning_august') ? old('planning_august') : $biomassa_receipt_plan->planning_august }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">September</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_september" value="{{ old('planning_september') ? old('planning_september') : $biomassa_receipt_plan->planning_september }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Oktober</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_october" value="{{ old('planning_october') ? old('planning_october') : $biomassa_receipt_plan->planning_october }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">November</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_november" value="{{ old('planning_november') ? old('planning_november') : $biomassa_receipt_plan->planning_november }}" class="w-full border">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">Desember</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2">
                                        <input type="text" name="planning_december" value="{{ old('planning_december') ? old('planning_december') : $biomassa_receipt_plan->planning_december }}" class="w-full border">
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

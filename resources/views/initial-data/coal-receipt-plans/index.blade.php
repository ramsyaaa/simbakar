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
                        Rencana Penerimaan Batubara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Rencana Penerimaan Batubara</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('initial-data.coal-receipt-plan.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <div class="mb-2 lg:mb-0">
                            <select name="year" id="" class="w-full lg:w-[200px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Tahun</option>
                                @foreach ($years as $year)
                                <option @if($year->uuid == $bpb->uuid) selected @endif value="{{ $year->uuid }}">{{ $year->year }}</option>
                                @endforeach
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
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Rencana Penerimaan Batubara (Kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Januari</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_january }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Februari</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_february }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Maret</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_march }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">April</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_april }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Mei</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_may }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Juni</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_june }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Juli</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_july }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Agustus</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_august }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">September</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_september }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Oktober</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_october }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">November</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_november }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Desember</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $coal_receipt_plan->planning_december }}</td>
                            </tr>
                            <tr>
                                <td class="h-[36px] text-[16px] font-bold border px-2">Total</td>
                                <td class="h-[36px] text-[16px] font-bold border px-2">
                                    {{
                                        $coal_receipt_plan->planning_january +
                                        $coal_receipt_plan->planning_february +
                                        $coal_receipt_plan->planning_march +
                                        $coal_receipt_plan->planning_april +
                                        $coal_receipt_plan->planning_may +
                                        $coal_receipt_plan->planning_june +
                                        $coal_receipt_plan->planning_july +
                                        $coal_receipt_plan->planning_august +
                                        $coal_receipt_plan->planning_september +
                                        $coal_receipt_plan->planning_october +
                                        $coal_receipt_plan->planning_november +
                                        $coal_receipt_plan->planning_december
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-10 w-full flex justify-center">
                    <a href="{{ route('initial-data.coal-receipt-plan.edit', ['uuid' => $coal_receipt_plan->uuid]) }}" class="px-4 py-2 rounded-lg bg-[#135F9C] text-white font-bold">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

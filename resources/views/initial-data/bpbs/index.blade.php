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
                        Pemakaian BPB
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">BPB</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Tahun</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">BPB terakir batubara</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">BPB terakir solar</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">BPB terakir residu</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">1</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$year }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$solar }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$residu }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

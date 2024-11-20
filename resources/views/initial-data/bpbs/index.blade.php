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
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Tahun</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">BPB terakir batubara</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">BPB terakir solar</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">BPB terakir residu</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">BPB terakir biomassa</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">1</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$year }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$coal }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$solar }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$residu }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{$biomassa }}</td>
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

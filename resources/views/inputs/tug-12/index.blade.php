@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="w-full flex gap-4 items-center my-4">
                <a href="{{ route('inputs.tug-3.index') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    TUG 3
                </a>
                <a href="{{ route('inputs.tug-9.index-coal') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    TUG 9
                </a>
                <a href="#" class="w-1/2 px-3 py-2 bg-[#2E46BA] text-white text-center font-bold rounded-lg">
                    TUG 12
                </a>
                <a href="{{ route('inputs.tug-11.index') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    TUG 11
                </a>
                <a href="{{ route('inputs.tug-4.index') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    TUG 4
                </a>
            </div>
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        List TUG 12
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="cursor-pointer">TUG 12</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 h-full">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('inputs.tug-12.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center gap-5 w-full mb-3">
                        <label for="" class="font-bold text-[#232D42] text-[16px]">Tanggal </label>
                        <input name="date" type="date" value="{{ request()->date ?? '' }}" class="w-full lg:w-3/12 h-[44px] rounded-md border px-2" placeholder="Cari Data" autofocus>
                        <button type="button" onclick="printPDF('a4')" class="px-5 py-2 bg-sky-700 hover:bg-sky-800 text-white text-center font-bold rounded-lg"> Print</button>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                @isset($tugs)

                <div>

                    <div class="overflow-auto hide-scrollbar max-w-full p-9">
                        <img src="{{asset('logo.png')}}" alt="" style="display:none;">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="border  bg-[#F5F6FA] text-[#8A92A6]">#</th>
                                    <th class="border  bg-[#F5F6FA] text-[#8A92A6]">Nomor Pemesanan</th>
                                    <th class="border  bg-[#F5F6FA] text-[#8A92A6]">Nomor Pemesanan</th>
                                    <th class="border  bg-[#F5F6FA] text-[#8A92A6]">Nomor Pemesanan</th>
                                    <th class="border  bg-[#F5F6FA] text-[#8A92A6]">Nomor Pemesanan</th>
                                    <th class="border  bg-[#F5F6FA] text-[#8A92A6]">Nomor Pemesanan</th>
                                    <th class="border  bg-[#F5F6FA] text-[#8A92A6]">Nomor Pemesanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tugs as $item)
                                    <tr>
                                        <td class="text-[16px] font-normal border px-2 text-center">{{$loop->iteration}}</td>
                                        @foreach ($item as $tug)
                                            <td class="text-[16px] font-normal border px-2 text-center">{{ $tug->tug_9_number ?? '' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $tugs->links() }} --}}
                    </div>
                </div>
                
                
            </div>
        </div>
        <div id="my-pdf" style="display:none;" class="w-50">
            <div class="p-10" style="font-size: 12px;"><div id="my-pdf" class="p-10">
                <div class="flex justify-between mb-4">
                    <div>
                        <img src="{{asset('logo.png')}}" alt="" width="200">
                        <p class="text-right">UBP SURALAYA</p>
                    </div>
                    <div class="text-[20px] font-bold">
                        DAFTAR PENGANTAR BON - BON GUDANG
                    </div>
                    <div></div>
                </div>
                <div class="max-w-full p-9">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border border-slate-900 text-[#8A92A6]">#</th>
                                <th class="border border-slate-900 text-[#8A92A6]">Nomor Pemesanan</th>
                                <th class="border border-slate-900 text-[#8A92A6]">Nomor Pemesanan</th>
                                <th class="border border-slate-900 text-[#8A92A6]">Nomor Pemesanan</th>
                                <th class="border border-slate-900 text-[#8A92A6]">Nomor Pemesanan</th>
                                <th class="border border-slate-900 text-[#8A92A6]">Nomor Pemesanan</th>
                                <th class="border border-slate-900 text-[#8A92A6]">Nomor Pemesanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tugs as $item)
                                <tr>
                                    <td class="text-[16px] font-normal border border-slate-900 px-2 text-center">{{$loop->iteration}}</td>
                                    @foreach ($item as $tug)
                                        <td class="text-[16px] font-normal border border-slate-900 px-2 text-center">{{ $tug->tug_9_number ?? '' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                               <!-- Fill in empty rows until minimum row count is reached -->
                            @for ($i = count($tugs); $i < 30; $i++)
                                <tr>
                                    <td class="border border-slate-900 px-2 text-center">&nbsp;</td> <!-- Empty cell with border border-slate-900 -->
                                    <td class="border border-slate-900 px-2 text-center">&nbsp;</td>
                                    <td class="border border-slate-900 px-2 text-center">&nbsp;</td>
                                    <td class="border border-slate-900 px-2 text-center">&nbsp;</td>
                                    <td class="border border-slate-900 px-2 text-center">&nbsp;</td>
                                    <td class="border border-slate-900 px-2 text-center">&nbsp;</td>
                                    <td class="border border-slate-900 px-2 text-center">&nbsp;</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                    {{-- {{ $tugs->links() }} --}}
                </div>
                <div class="second-table mt-5 flex justify-between">
                    <div class="first">
                         <table class="w-full" style="font-size:10px;">
                              <thead>
                                   <tr>
                                        <th></th>
                                        <th>Tanggal</th>
                                        <th>Paraf</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <tr>
                                        <th class="border border-gray-400 px-2">Dibuat</th>
                                        <th class="border border-gray-400 px-2">  {{date('d-m-Y', strtotime(request('date')))}}</th>
                                        <th class="border border-gray-400 px-2 w-[150px]"></th>
                                   </tr>
                              </tbody>
                              <tbody>
                                   <tr>
                                        <th class="border border-gray-400 px-2">Diperiksa</th>
                                        <th class="border border-gray-400 px-2">  {{date('d-m-Y', strtotime(request('date')))}}</th>
                                        <th class="border border-gray-400 px-2"></th>
                                   </tr>
                              </tbody>
                              <tbody>
                                   <tr>
                                        <th class="border border-gray-400 px-2">Dibukukan</th>
                                        <th class="border border-gray-400 px-2">  {{date('d-m-Y', strtotime(request('date')))}}</th>
                                        <th class="border border-gray-400 px-2"></th>
                                   </tr>
                              </tbody>
                         </table>
                    </div>
                    <div class="second">
                         
                    </div>
                    
               </div>
            </div>
        </div>
        @endisset
       
    </div>
    
</div>


@endsection

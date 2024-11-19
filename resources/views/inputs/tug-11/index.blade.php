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
                <a href="{{ route('inputs.tug-12.index') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    TUG 12
                </a>
                <a href="#" class="w-1/2 px-3 py-2 bg-[#2E46BA] text-white text-center font-bold rounded-lg">
                    TUG 11
                </a>
                <a href="{{ route('inputs.tug-4.index') }}" class="w-1/2 px-3 py-2 bg-[#6C757D] text-white text-center font-bold rounded-lg">
                    TUG 4
                </a>
            </div>
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        List TUG 11
                    </div>
                    <div class="mb-4  text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="cursor-pointer">TUG 11</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 h-full">
                <form action="{{ route('inputs.tug-11.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center gap-5 w-full mb-3">
                        <label for="" class="font-bold text-[#232D42] ">Tanggal </label>
                        <input name="date" type="date" value="{{ request()->date ?? '' }}" class="w-full lg:w-3/12 h-[44px] rounded-md border px-2" placeholder="Cari Data" autofocus required>
                        <label for="" class="font-bold text-[#232D42] ">Kepala Gudang</label>
                        <input type="text" name="headwarehouse" class="w-full lg:w-3/12 h-[44px] rounded-md border px-2" placeholder="Ketik Kepala Gudang" value="{{request()->headwarehouse ?? ''}}" required>
                        <button type="submit" class="px-5 py-2 bg-[#1aa222] text-white text-center font-bold rounded-lg">Submit</button>
                        <button type="button" onclick="printPDF()" class="px-5 py-2 bg-sky-700 hover:bg-sky-800 text-white text-center font-bold rounded-lg"> Print</button>
                    </div>
                </form>
                @isset($coal)

                <div>

                    <div class="overflow-auto hide-scrollbar max-w-full text-sm p-10" style="font-size:0.8em">
                         <table class="w-full">
                         <thead>
                              <tr>
                                   <th class="border bg-[#F5F6FA] text-[#8A92A6]">Nama Barang</th>
                                   <th class="border bg-[#F5F6FA] text-[#8A92A6]">Unit</th>
                                   <th class="border bg-[#F5F6FA] text-[#8A92A6]">Nomor Normalisasi</th>
                                   <th class="border bg-[#F5F6FA] text-[#8A92A6]">Satuan</th>
                                   <th class="border bg-[#F5F6FA] text-[#8A92A6]">Mutasi Keluar</th>
                              </tr>
                         </thead>
                         <tbody>
                              {{-- Batu Bara --}}
                              <tr>
                                   <td class=" font-normal border px-2 text-center">Batu Bara</td>
                                   <td class=" font-normal border px-2 text-center">Unit 1</td>
                                   <td class=" font-normal border px-2 text-center font-bold" rowspan="4">01.001.003.0100</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{$coal[0] ? number_format($coal[0]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 2</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{$coal[1] ? number_format($coal[1]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 3</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$coal[2] ? number_format($coal[2]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 4</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$coal[3] ? number_format($coal[3]) : 0}}
                                   </td>
                              </tr>
                              @php
                                  $sumCoal1 = $coal[0] + $coal[1] + $coal[2] + $coal[3];
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 1 - 4 </td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($sumCoal1)}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 5</td>
                                   <td class=" font-normal border px-2 text-center font-bold" rowspan="3">01.001.003.0100</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$coal[4] ? number_format($coal[4]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 6</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$coal[5] ? number_format($coal[5]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 7</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$coal[6] ? number_format($coal[6]) : 0}}
                                   </td>
                              </tr>
                              @php
                                   $sumCoal2 = $coal[4] + $coal[5] + $coal[6];
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 5 - 7 </td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($sumCoal2)}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Batu Bara Lainnya </td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($coalOther)}}</td>
                              </tr>
                              @php
                                  $coalTotal = $sumCoal1 + $sumCoal2 + $coalOther;
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Batu Bara </td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($coalTotal)}}</td>
                              </tr>
                              {{-- Solar --}}
                              <tr>
                                   <td class=" font-normal border px-2 text-center">Solar HSD</td>
                                   <td class=" font-normal border px-2 text-center">Unit 1</td>
                                   <td class=" font-normal border px-2 text-center font-bold" rowspan="6">01.001.003.0013</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{$solar[0] ? number_format($solar[0]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 2</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{$solar[1] ? number_format($solar[1]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 3</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{$solar[2] ? number_format($solar[2]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 4</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{$solar[3] ? number_format($solar[3]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Albes</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($solarHeavy)}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Lain - Lain</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($solarOther)}}</td>
                              </tr>
                              @php
                                   $sumSolar1 = $solar[0] + $solar[1] + $solar[2] + $solar[3];
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 1 - 4 </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($sumSolar1)}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 5</td>
                                   <td class=" font-normal border px-2 text-center font-bold" rowspan="3">01.001.003.0013</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{$solar[4] ? number_format($solar[4]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 6</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{$solar[5] ? number_format($solar[5]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 7</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{$solar[6] ? number_format($solar[6]) : 0}}</td>
                              </tr>
                              @php
                                   $sumSolar2 = $solar[4] + $solar[5] + $solar[6];
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 5 - 7 </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($sumSolar2)}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Solar HSD Lainnya </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($solarOther)}}</td>
                              </tr>
                              @php
                                   $solarTotal = $sumSolar1 + $sumSolar2 + $solarOther + $solarHeavy;
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Solar HSD </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($solarTotal)}}</td>
                              </tr>
                              {{-- Residu --}}
                              <tr>
                                   <td class=" font-normal border px-2 text-center">Residu MFO</td>
                                   <td class=" font-normal border px-2 text-center">Unit 1</td>
                                   <td class=" font-normal border px-2 text-center font-bold" rowspan="4">01.001.003.0101</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$residu[0] ? number_format($residu[0]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 2</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$residu[1] ? number_format($residu[1]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 3</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$residu[2] ? number_format($residu[2]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 4</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$residu[3] ? number_format($residu[3]) : 0}}
                                   </td>
                              </tr>
                              @php
                                   $sumResidu1 = $residu[0] + $residu[1] + $residu[2] + $residu[3];
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 1 - 4 </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($sumResidu1)}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 5</td>
                                   <td class=" font-normal border px-2 text-center font-bold" rowspan="3">01.001.003.0101

                                   </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$residu[4] ? number_format($residu[4]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 6</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$residu[5] ? number_format($residu[5]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 7</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">
                                        {{$residu[6] ? number_format($residu[6]) : 0}}
                                   </td>
                              </tr>
                              @php
                                   $sumResidu2 = $residu[4] + $residu[5] + $residu[6];
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 5 - 7 </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($sumResidu2)}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Residu MFO Lainnya </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($residuOther)}}</td>
                              </tr>
                              @php
                                   $residuTotal = $sumResidu1 + $sumResidu2 + $residuOther;
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Residu MFO </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($residuTotal)}}</td>
                              </tr>

                              {{-- Biomassa --}}
                              <tr>
                                   <td class=" font-normal border px-2 text-center">Biomassa</td>
                                   <td class=" font-normal border px-2 text-center">Unit 1</td>
                                   <td class=" font-normal border px-2 text-center font-bold" rowspan="4">01.001.003.0013</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{$biomassa[0] ? number_format($biomassa[0]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 2</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{$biomassa[1] ? number_format($biomassa[1]) : 0}}</</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 3</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{$biomassa[2] ? number_format($biomassa[2]) : 0}}</</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 4</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{$biomassa[3] ? number_format($biomassa[3]) : 0}}</</td>
                              </tr>
                              @php
                                   $sumBiomassa1 = $biomassa[0] + $biomassa[1] + $biomassa[2] + $biomassa[3];
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 1 - 4 </td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($sumBiomassa1)}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 5</td>
                                   <td class=" font-normal border px-2 text-center font-bold" rowspan="3">01.001.003.0013</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{$biomassa[4] ? number_format($biomassa[4]) : 0}}</</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 6</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{$biomassa[5] ? number_format($biomassa[5]) : 0}}</</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 7</td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{$biomassa[6] ? number_format($biomassa[6]) : 0}}</</td>
                              </tr>
                              @php
                                   $sumBiomassa2 = $biomassa[4] + $biomassa[5] + $biomassa[6];
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 5 - 7 </td>
                                   <td class=" font-normal border px-2 text-center">Kg</td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($sumBiomassa2)}}</td>
                              </tr>
                              @php
                                   $biomassaTotal = $sumBiomassa1 + $sumBiomassa2;
                              @endphp
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Biomassa </td>
                                   <td class=" font-normal border px-2 text-center">Kg  </td>
                                   <td class=" font-normal border px-2 text-center">{{number_format($biomassaTotal)}}</td>
                              </tr>
                         </tbody>
                         </table>
                    </div>
                </div>
            </div>

            <div id="my-pdf" style="display:none;" class="w-50">
               <div class="p-10" style="font-size: 12px;">
                    <div class="flex justify-between mb-4">
                         <div>
                             <img src="{{asset('logo.png')}}" alt="" width="200">
                             <p class="text-right">UBP SURALAYA</p>
                         </div>
                         <div class="text-[12px] font-bold">
                              TUG 11
                         </div>
                     </div>
                     <div class="text-center font-bold">
                         <h4 class="underline">DAFTAR MUTASI HARIAN</h4>
                         <p> Nomor : {{$day}} /  {{date('Y', strtotime($date))}}</p>
                     </div>
                   <div class="p-10 mx-auto my-auto">
                       
                    <table class="w-full" style="font-size:10px;">
                         <thead>
                              <tr>
                                   <th class="border border-slate-900">No</th>
                                   <th class="border border-slate-900">Nama Barang</th>
                                   <th class="border border-slate-900">Unit</th>
                                   <th class="border border-slate-900">Nomor Normalisasi</th>
                                   <th class="border border-slate-900">Satuan</th>
                                   <th class="border border-slate-900">Mutasi Keluar</th>
                              </tr>
                         </thead>
                         <tbody>
                              {{-- Batu Bara --}}
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="11">1</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="11">Batu Bara</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 1</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="4"> <b>01.001.003.0100</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$coal[0] ? number_format($coal[0]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 2</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$coal[1] ? number_format($coal[1]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 3</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">
                                        {{$coal[2] ? number_format($coal[2]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 4</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">
                                        {{$coal[3] ? number_format($coal[3]) : 0}}
                                   </td>
                              </tr>
                              @php
                                  $sumCoal1 = $coal[0] + $coal[1] + $coal[2] + $coal[3];
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Unit 1 - 4</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($sumCoal1)}}</b></td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 5</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="3"><b>01.001.003.0100</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">
                                        {{$coal[4] ? number_format($coal[4]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 6</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">
                                        {{$coal[5] ? number_format($coal[5]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 7</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">
                                        {{$coal[6] ? number_format($coal[6]) : 0}}
                                   </td>
                              </tr>
                              @php
                                   $sumCoal2 = $coal[4] + $coal[5] + $coal[6];
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Unit 5 - 7</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Kg</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($sumCoal2)}}</b></td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Batu Bara Lainnya</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Kg</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($coalOther)}}</b></td>
                              </tr>
                              @php
                                  $coalTotal = $sumCoal1 + $sumCoal2 + $coalOther;
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Batu Bara</b> </td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Kg</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($coalTotal)}}</b></td>
                              </tr>
                              {{-- Solar --}}
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="13">2</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="13">Solar HSD</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 1</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="6"><b>01.001.003.0013</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$solar[0] ? number_format($solar[0]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 2</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$solar[1] ? number_format($solar[1]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 3</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$solar[2] ? number_format($solar[2]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 4</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$solar[3] ? number_format($solar[3]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Albes</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{number_format($solarHeavy)}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Lain - Lain</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{number_format($solarOther)}}</td>
                              </tr>
                              @php
                                   $sumSolar1 = $solar[0] + $solar[1] + $solar[2] + $solar[3];
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Unit 1 - 4</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Liter</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($sumSolar1)}}</b></td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 5</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="3"><b>01.001.003.0013</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$solar[4] ? number_format($solar[4]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 6</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$solar[5] ? number_format($solar[5]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 7</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$solar[6] ? number_format($solar[6]) : 0}}</td>
                              </tr>
                              @php
                                   $sumSolar2 = $solar[4] + $solar[5] + $solar[6];
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Unit 5 - 7</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Liter</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($sumSolar2)}}</b></td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Solar HSD Lainnya</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Liter</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($solarOther)}}</b></td>
                              </tr>
                              @php
                                   $solarTotal = $sumSolar1 + $sumSolar2 + $solarOther + $solarHeavy;
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Solar HSD</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Liter</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($solarTotal)}}</b></td>
                              </tr>
                              {{-- Residu --}}
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="7">3</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="7">Residu MFO</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 1</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="4"><b>01.001.003.0101</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">
                                        {{$residu[0] ? number_format($residu[0]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 2</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">
                                        {{$residu[1] ? number_format($residu[1]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 3</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">
                                        {{$residu[2] ? number_format($residu[2]) : 0}}
                                   </td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 4</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Liter</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">
                                        {{$residu[3] ? number_format($residu[3]) : 0}}
                                   </td>
                              </tr>
                              @php
                                   $sumResidu1 = $residu[0] + $residu[1] + $residu[2] + $residu[3];
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Unit 1 - 4</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Liter</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($sumResidu1)}}</b></td>
                              </tr>
                             
                              @php
                                   $sumResidu2 = $residu[4] + $residu[5] + $residu[6];
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Residu MFO Lainnya</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Liter</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($residuOther)}}</b></td>
                              </tr>
                              @php
                                   $residuTotal = $sumResidu1 + $sumResidu2 + $residuOther;
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Residu MFO</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Liter</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($residuTotal)}}</b></td>
                              </tr>

                              {{-- Biomassa --}}
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="11">4</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="11">Biomassa</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 1</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="4"> <b>01.002.001.0001</b>
                                   </td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$biomassa[0] ? number_format($biomassa[0]) : 0}}</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 2</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$biomassa[1] ? number_format($biomassa[1]) : 0}}</</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 3</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$biomassa[2] ? number_format($biomassa[2]) : 0}}</</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 4</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$biomassa[3] ? number_format($biomassa[3]) : 0}}</</td>
                              </tr>
                              @php
                                   $sumBiomassa1 = $biomassa[0] + $biomassa[1] + $biomassa[2] + $biomassa[3];
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Unit 1 - 4</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Kg</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($sumBiomassa1)}}</b></td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 5</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" rowspan="3"> <b>01.002.001.0001</b>
                                   </td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$biomassa[4] ? number_format($biomassa[4]) : 0}}</</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 6</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$biomassa[5] ? number_format($biomassa[5]) : 0}}</</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Unit 7</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">Kg</td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center">{{$biomassa[6] ? number_format($biomassa[6]) : 0}}</</td>
                              </tr>
                              @php
                                   $sumBiomassa2 = $biomassa[4] + $biomassa[5] + $biomassa[6];
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Unit 5 - 7</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Kg</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($sumBiomassa2)}}</b></td>
                              </tr>
                              @php
                                   $biomassaTotal = $sumBiomassa1 + $sumBiomassa2;
                              @endphp
                              <tr>
                                   <td class=" font-normal border border-slate-900 px-2 text-center" colspan="2"><b>Total Pemakaian Biomassa</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>Kg</b></td>
                                   <td class=" font-normal border border-slate-900 px-2 text-center"><b>{{number_format($biomassaTotal)}}</b></td>
                              </tr>
                         </tbody>
                         </table>

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
                                             <th class="border border-slate-900 px-2">Dibuat</th>
                                             <th class="border border-slate-900 px-2">  {{date('d-m-Y', strtotime($date))}}</th>
                                             <th class="border border-slate-900 px-2 w-[150px]"></th>
                                        </tr>
                                   </tbody>
                                   <tbody>
                                        <tr>
                                             <th class="border border-slate-900 px-2">Diperiksa</th>
                                             <th class="border border-slate-900 px-2">  {{date('d-m-Y', strtotime($date))}}</th>
                                             <th class="border border-slate-900 px-2"></th>
                                        </tr>
                                   </tbody>
                                   <tbody>
                                        <tr>
                                             <th class="border border-slate-900 px-2">Dibukukan</th>
                                             <th class="border border-slate-900 px-2">  {{date('d-m-Y', strtotime($date))}}</th>
                                             <th class="border border-slate-900 px-2"></th>
                                        </tr>
                                   </tbody>
                              </table>
                         </div>
                         <div class="second">
                              <h6 class="pb-20">Kepala Gudang</h6>
                              <span class="">{{request('headwarehouse')}}</span>
                         </div>
                         
                    </div>
                   </div>
                   
               </div>
           </div>
            @endisset

        </div>
    </div>
</div>
@endsection

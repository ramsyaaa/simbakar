@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
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
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('inputs.tug-11.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center gap-5 w-full mb-3">
                        <label for="" class="font-bold text-[#232D42] ">Tanggal </label>
                        <input name="date" type="date" value="{{ request()->date ?? '' }}" class="w-full lg:w-3/12 h-[44px] rounded-md border px-2" placeholder="Cari Data" autofocus>
                        <button type="button" onclick="printPDF()" class="px-5 py-2 bg-sky-700 hover:bg-sky-800 text-white text-center font-bold rounded-lg"> Print</button>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div id="my-pdf">

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
                                   <td class=" font-normal border px-2 text-center" rowspan="4">18.01.0009</td>
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
                                   <td class=" font-normal border px-2 text-center" rowspan="3">18.01.0009</td>
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
                                   <td class=" font-normal border px-2 text-center" rowspan="6">18.01.0322</td>
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
                                   <td class=" font-normal border px-2 text-center" rowspan="3">18.01.0322</td>
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
                                   <td class=" font-normal border px-2 text-center" rowspan="4">18.01.0306</td>
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
                                   <td class=" font-normal border px-2 text-center" rowspan="3">18.01.0306</td>
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
                                   <td class=" font-normal border px-2 text-center" rowspan="4">18.01.0306</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">0</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 2</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">0</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 3</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">0</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 4</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">0</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 1 - 4 </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">0</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 5</td>
                                   <td class=" font-normal border px-2 text-center" rowspan="3">18.01.0306</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">0</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 6</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">0</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center">Unit 7</td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">0</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 5 - 7 </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">0</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Biomassa Lainnya </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">0</td>
                              </tr>
                              <tr>
                                   <td class=" font-normal border px-2 text-center"></td>
                                   <td class=" font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Biomassa </td>
                                   <td class=" font-normal border px-2 text-center">Liter</td>
                                   <td class=" font-normal border px-2 text-center">0</td>
                              </tr>
                         </tbody>
                         </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

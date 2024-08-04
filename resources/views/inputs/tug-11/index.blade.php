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
                        List TUG 9
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="cursor-pointer">TUG 9</span>
                    </div>
                </div>      
            </div>
            <div class="bg-white rounded-lg p-6 h-full">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('inputs.tug-9.index-coal') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center gap-5 w-full mb-3">
                        <label for="" class="font-bold text-[#232D42] text-[16px]">Tanggal </label>
                        <input name="date" type="date" value="{{ request()->date ?? '' }}" class="w-full lg:w-3/12 h-[44px] rounded-md border px-2" placeholder="Cari Data" autofocus>
                        <select id="head" name="head" class="w-full lg:w-[350px] h-[44px] rounded-md border px-2" autofocus>
                            <option selected disabled>Pilih Kepala Gudang</option>
                            @foreach ($heads as $head)
                                <option value="{{$head->name}}" {{request('head') == $head->name ? 'selected' :''}}>{{$head->name}}</option>
                            @endforeach
                        </select>
                        <button type="button" onclick="printPDF()" class="px-5 py-2 bg-sky-700 hover:bg-sky-800 text-white text-center font-bold rounded-lg"> Print</button>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>

                <div class="overflow-auto hide-scrollbar max-w-full" id="my-pdf">
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
                                <td class="text-[16px] font-normal border px-2 text-center">Batu Bara</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 1</td>
                                <td class="text-[16px] font-normal border px-2 text-center" rowspan="4">18.01.0009</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 2</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 3</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 4</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 1 - 4 </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 5</td>
                                <td class="text-[16px] font-normal border px-2 text-center" rowspan="4">18.01.0009</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 6</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 7</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 8</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 5 - 8 </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Batu Bara Lainnya </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Batu Bara </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Kg</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           {{-- Solar --}}
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center">Solar HSD</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 1</td>
                                <td class="text-[16px] font-normal border px-2 text-center" rowspan="4">18.01.0322</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 2</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 3</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 4</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 1 - 4 </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 5</td>
                                <td class="text-[16px] font-normal border px-2 text-center" rowspan="4">18.01.0322</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 6</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 7</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 8</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 5 - 8 </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Solar HSD Lainnya </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Solar HSD </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           {{-- Residu --}}
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center">Residu MFO</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 1</td>
                                <td class="text-[16px] font-normal border px-2 text-center" rowspan="4">18.01.0306</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 2</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 3</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 4</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 1 - 4 </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 5</td>
                                <td class="text-[16px] font-normal border px-2 text-center" rowspan="4">18.01.0306</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 6</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 7</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center">Unit 8</td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Unit 5 - 8 </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Residu MFO Lainnya </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                           <tr>
                                <td class="text-[16px] font-normal border px-2 text-center"></td>
                                <td class="text-[16px] font-normal border px-2 text-center bg-sky-500 text-white" colspan="2">Total Pemakaian Residu MFO </td>
                                <td class="text-[16px] font-normal border px-2 text-center">Liter</td>
                                <td class="text-[16px] font-normal border px-2 text-center">0</td>
                           </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
                        Detail TUG 9
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.tug-9.index-coal') }}" class="cursor-pointer">TUG 9</a> / <span class="text-[#2E46BA] cursor-pointer">Detail</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                        <div class="unloadings">
                            <div class="p-4 bg-white rounded-lg w-full">
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="usage_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Pakai</label>
                                        <div class="relative">
                                            <input required type="date" value="{{$tug->use_date}}" name="usage_date" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('usage_date')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="usage_amount" class="font-bold text-[#232D42] text-[16px]">Jumlah Pakai</label>
                                        <div class="relative">
                                            <input required type="text" value="{{$tug->amount}}" name="usage_amount" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('usage_amount')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="ba_number" class="font-bold text-[#232D42] text-[16px]">Nomor TUG 9</label>
                                        <div class="relative">
                                            <input required type="text" value="{{$tug->tug9_number}}" name="ba_number" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('ba_number')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="flex gap-3">

                            <a href="{{route('inputs.tug-9.index-coal')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                            <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3" type="button" onclick="printPDF()">Print</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="my-pdf" style="display: none;">
                <div style="font-size: 0.7em;">
                    <div class="mx-auto my-10 bg-white p-8 rounded">
                        <table class="w-full border-collapse border border-gray-900">
                            <thead class="border">
                                <tr class="border border-gray-900">
                                    <th class="p-2 text-left">
                                        <div class="flex justify-between items-center">
                                            <div>
                                               <img src="{{asset('logo-2.png')}}" alt="" width="200">
                                            </div>
                                        </div>
                                    </th>
                                    </tr>
                                    <tr class="border border-gray-900 text-center">
                                        <th class="border border-gray-900" rowspan="5" colspan="4">
                                            <h2 class="text-xl font-bold">BON PEMAKAIAN</h2>
                                        </th>
                                    </tr>
                                    <tr class="border border-gray-900 text-left">
                                        <th class="border border-gray-900">
                                            <p>No. Dokumen: <strong>FM-SLA/141</strong></p>
                                        </th>
                                    </tr>
                                    <tr class="border border-gray-900 text-left">
                                        <th class="border border-gray-900">
                                            <p>Tanggal: {{$tug->use_date}}</p>
                                        </th>
                                    </tr>
                                    <tr class="border border-gray-900 text-left">
                                        <th class="border border-gray-900">
                                            <p>Revisi: 00</p>
                                        </th>
                                    </tr>
                                    <tr class="border border-gray-900 text-left">
                                        <th class="border border-gray-900">
                                            <p>Halaman: 1 dari 1 halaman</p>
                                        </th>
                                    </tr>
                                <tr>
                                    <th class="border border-gray-900 p-2" colspan="5">
                                        <div class="flex justify-between">
                                            <div>
                                                1 . TUG 9
                                            </div>
                                            <div>
                                                No . {{$tug->tug9_number}}
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="border border-gray-900" colspan="5">
                                        <div class="flex justify-between">
                                            <div>INDONESIA POWER</div>
                                            <div>UNIT PEMBANGKITAN SURALAYA</div>
                                            @php
                                                $angka = abs($tug->unit->name);
                                                $baca = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
                                                $terbilang = "";
                                                $terbilang = " " . $baca[$tug->unit->name];
                                            @endphp
                                            <div>UNIT: <strong>{{$tug->unit->name}} ({{$terbilang}})</strong></div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="border">
                                    <td class="border border-gray-900 p-2" colspan="4">Pekerjaan</td>
                                    <td class="border border-gray-900">No. P.P.</td>
                                </tr>
                                <tr class="border">
                                    <td class="border border-gray-900 p-2" colspan="5">Nama Alamat : </td>
                                </tr>
                                <tr>
                                    <th class="border border-gray-900">Banyaknya</th>
                                    <th class="border border-gray-900">Satuan</th>
                                    <th class="border border-gray-900">Nama Barang  / Spare Part</th>
                                    <th class="border border-gray-900">No . Form / Part</th>
                                    <th class="border border-gray-900">Jumlah Uang</th>
                                </tr>
                                <tr>
                                    <td class="border border-gray-900 p-8">{{number_format($tug->use)}}</td>
                                    <td class="border border-gray-900 p-8">L</td>
                                    <td class="border border-gray-900 p-8">{{$tug->bbm_type == 'solar' ? 'Solar / HSD' : 'Residu / MFO'}}</td>
                                    <td class="border border-gray-900 p-8">18.01.0323</td>
                                    <td class="border border-gray-900 p-8"></td>
                                </tr>
                                <tr>
                                    <th class="border border-gray-900 px-5 text-left" >Perkiraan Pembebanan</th>
                                    <th class="border border-gray-900 px-5 text-left" >Kode Perkiraan</th>
                                    <th class="border border-gray-900 px-5 text-left"  colspan="3">Tanggal {{date('d F Y')}}</th>
                                </tr>

                                <tr>
                                    <th style="padding-bottom: 100px;padding-top: 30px;">Setuju</th>
                                    <th style="padding-bottom: 100px;padding-top: 30px;">Kepala Gudang</th>
                                    <th style="padding-bottom: 100px;padding-top: 30px;">Pemeriksaa</th>
                                    <th style="padding-bottom: 100px;padding-top: 30px;">Penerima</th>
                                    <th style="padding-bottom: 100px;padding-top: 30px;"></th>
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

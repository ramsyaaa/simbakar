@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen h-screen flex bg-[#E9ECEF] overflow-auto hide-scrollbar">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        Detail TUG 3
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.tug-3.index') }}" class="cursor-pointer">TUG 3</a> / <span class="text-[#2E46BA] cursor-pointer">Detail</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                        <div class="unloadings">
                            <div class="p-4 bg-white rounded-lg w-full">
                                <div class="lg:flex gap-3">
                                    <div class="w-full">
                                        <label for="type_fuel" class="font-bold text-[#232D42] text-[16px]">Jenis Bahan Bakar</label>
                                        <div class="relative">
                                            <input type="hidden" name="type_adjusment" value="income">
                                            <select id="type_fuel" name="type_fuel" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" autofocus>
                                                <option selected disabled>Jenis Bahan Bakar</option>
                                                <option {{$tug->type_fuel == 'Batu Bara' ? 'selected' :''}}> Batu Bara</option>
                                                <option {{$tug->type_fuel == 'HSD / Solar' ? 'selected' :''}}> HSD / Solar</option>
                                                <option {{$tug->type_fuel == 'MFO / Residu' ? 'selected' :''}}> MFO / Residu</option>
                                            </select>
                                            @error('type_fuel')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                
                                    <div class="w-full">
                                        <label for="tug_number" class="font-bold text-[#232D42] text-[16px]">Nomor TUG</label>
                                        <div class="relative">
                                            <input required type="text" value="{{$tug->tug_number}}" name="tug_number" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('tug_number')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="w-full">
                                        <label for="bpb_number" class="font-bold text-[#232D42] text-[16px]">Nomor BPB</label>
                                        <div class="relative">
                                            <input required type="text" value="{{$tug->bpb_number}}" name="bpb_number" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('bpb_number')
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
                                            <input required type="text" value="{{number_format($tug->usage_amount)}} {{$tug->unit}}" name="usage_amount" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('usage_amount')
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

                                <a href="{{route('inputs.tug-3.index')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>

                                <button type="button" class="bg-[#2E46BA] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3" onclick="printPDF()">Print</button>
                            </div>
                            
                    </div>
                    <div id="my-pdf" style="display:none;">
                        <div class="p-8" style="font-size: 0.9em;">
                            <div class="p-6 mx-auto my-auto">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <img src="{{asset('logo.png')}}" alt="" width="200">
                                        <p class="text-right">UBP SURALAYA</p>
                                    </div>
                                    <div class="text-right">
                                        <p>Bon Penerimaan Barang-barang/Spare Parts</p>
                                        <p>No: {{$tug->bpb_number}}/IBPB/UBPSLA/PBB/{{date('Y')}}</p>
                                    </div>
                                    <div class="text-right">
                                        <p>TUG - 3</p>
                                        <p>{{$tug->tug_number}}</p>
                                        <div class="text-right mt-5">
                                            <p class="border border-slate-700">P.I.N.: INDONESIA POWER</p>
                                            <p class="border border-slate-700">Cab./UP/Bkl: SURALAYA PGU</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <div class="flex justify-between">
                                        <div>
                                            @if ($tug->type_fuel == 'Batu Bara')          
                                                <p>Diterima tanggal: {{$tug->coal->receipt_date}}</p>
                                                <p>Dari: UBP SURALAYA</p>
                                                <p>Dengan: {{$tug->coal->ship->name}}</p>
                                            @endif
                                            @if ($tug->type_fuel == 'solar')          
                                                <p>Diterima tanggal: {{$tug->bbm->date_receipt}}</p>
                                                <p>Dari: UBP SURALAYA</p>
                                                <p>Dengan: {{$tug->bbm->ship->name}}</p>
                                            @endif
                                        </div>
                                        <div class="text-left">
                                            @if ($tug->type_fuel == 'Batu Bara')          
                                                <p>Pembelian ditempat lihat faktur / bukti kas no:</p>
                                                <p>Diterima bon pengeluaran/surat pengantar no:</p>
                                                <p>Menurut surat pesanan/daftar permintaan no : {{$tug->coal->contract->contract_number}} / {{$tug->coal->receipt_date}}</p>
                                            @endif
                                            @if ($tug->type_fuel == 'solar')          
                                            <p>Pembelian ditempat lihat faktur / bukti kas no:</p>
                                            <p>Diterima bon pengeluaran/surat pengantar no:</p>
                                            <p>Menurut surat pesanan/daftar permintaan no : </p>
                                            @endif
                                        </div>
                                        <div></div>
                                        
                                    </div>
                                </div>
                                
                                <table class="mt-6 bg-white w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 border border-slate-700">No. Urut</th>
                                            <th class="px-4 py-2 border border-slate-700">Nama</th>
                                            <th class="px-4 py-2 border border-slate-700">Norm/Part</th>
                                            <th class="px-4 py-2 border border-slate-700">Stn.</th>
                                            <th class="px-4 py-2 border border-slate-700">Banyaknya</th>
                                            <th class="px-4 py-2 border border-slate-700">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($tug->type_tug == 'coal-unloading')
                                            <tr>
                                                <td class="px-4 py-2 border border-slate-700"></td>
                                                <td class="px-4 py-2 border border-slate-700">
                                                    <p>Jenis Bahan Bakar: Batubara</p>
                                                    <p>ex. {{$tug->coal->supplier->name}}</p>
                                                    <p>Penerimaan Untuk Unit 1-7</p>
                                                    <p>Pelabuhan Asal: {{$tug->coal->originHarbor->name}}</p>
                                                    <p>Draft Survey: {{ number_format($tug->coal->ds)}} Kg</p>
                                                    <p>Belt Weiger: 0 Kg</p>
                                                    <p>Bill of Lading: {{ number_format($tug->coal->bl)}} Kg</p>
                                                    <p>Diterima: {{ number_format($tug->coal->tug_3_accept)}} Kg</p>
                                                </td>
                                                <td class="px-4 py-2 border border-slate-700">18.01.0009</td>
                                                <td class="px-4 py-2 border border-slate-700">Kg</td>
                                                <td class="px-4 py-2 border border-slate-700">{{ number_format($tug->coal->tug_3_accept)}}</td>
                                                <td class="px-4 py-2 border border-slate-700"></td>
                                            </tr>   
                                        @endif
                                        @if ($tug->type_tug == 'bbm-receipt')
                                            <tr>
                                                <td class="px-4 py-2 border border-slate-700"></td>
                                                <td class="px-4 py-2 border border-slate-700">
                                                    <p>Jenis Bahan Bakar: {{$tug->type_fuel == 'Solar' ? 'Solar / HSD' : 'Residu MFO'}}</p>
                                                    <p>{{$tug->bbm->note}}</p>
                                                    <p>Nama Agen : {{$tug->bbm->shipAgent->name}}</p>
                                                    <p>Volume Faktur: {{ number_format($tug->bbm->amount_receipt)}} Kg</p>
                                                </td>
                                                <td class="px-4 py-2 border border-slate-700">18.01.0323</td>
                                                <td class="px-4 py-2 border border-slate-700">L</td>
                                                <td class="px-4 py-2 border border-slate-700">{{ number_format($tug->bbm->amount_receipt)}}</td>
                                                <td class="px-4 py-2 border border-slate-700"></td>
                                            </tr>   
                                        @endif
                                       
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="px-4 py-2 border border-slate-700" colspan="2">
                                                <div class="flex justify-between">
                                                    <div>Nota No.</div>
                                                    <div class="mr-24">Kode Perkiraan</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 border border-slate-700" colspan="3">
                                                <div class="flex justify-between">
                                                    <div>Perintah Kerja</div>
                                                    <div class="mr-24">Fungsi</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 border border-slate-700">
                                                <div>Jumlah</div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>                       
                                <div class="mt-6 flex justify-between">
                                    <div></div>
                                    <div class="text-center">
                                        <p>Diperiksa Oleh</p>
                                    </div>
                                    <div class="text-center">
                                        <p>Kepala Gudang</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

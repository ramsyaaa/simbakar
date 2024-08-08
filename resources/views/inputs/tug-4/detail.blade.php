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
                        Detail TUG 4 
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.tug-4.index') }}" class="cursor-pointer">TUG - 4 </a> / <span class="text-[#2E46BA] cursor-pointer">Detail</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                        <div class="unloadings">
                            <div class="p-4 bg-white rounded-lg w-full">
                                    <div class="w-full mb-5">
                                        <label for="bpb_number" class="font-bold text-[#232D42] text-[16px]">No BPB</label>
                                        <div class="relative">
                                            <input required type="text" value="{{$tug->bpb_number}}" name="bpb_number" class="w-full lg:w-46 border rounded-md mt-3 h-[40px] px-3">
                                            @error('bpb_number')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="inspection_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Periksa</label>
                                        <div class="relative">
                                            <input required type="date" value="{{$tug->inspection_date}}" name="inspection_date" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                           
                                            @error('inspection_date')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full mb-5">
                                        <label for="user_inspection" class="font-bold text-[#232D42] text-[16px]">Pemeriksa</label>
                                        <div class="relative">
                                            @foreach ($pics as $pic)
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inspectionuser" name="user_inspections[]" value="{{$pic->id}}"
                                                    @if ($tug->user_inspections)
                                                        @foreach (json_decode($tug->user_inspections) as $item)
                                                            {{($item == $pic->id) ? 'checked':''}}
                                                        @endforeach
                                                    @endif
                                                    >
                                                    <label class="form-check-label" for="inspectionuser">
                                                    {{$pic->name}} - {{$pic->structural_position}} - {{$pic->functional_role}}
                                                    </label>
                                                </div>
                                            @endforeach
                                            
                                            @error('user_inspection')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full mb-5">
                                        <label for="tug_number" class="font-bold text-[#232D42] text-[16px]">No TUG 3</label>
                                        <div class="relative">
                                            <input required type="text" value="{{$tug->tug_number}}" name="tug_number" class="w-full lg:w-46 border rounded-md mt-3 h-[40px] px-3">
                                            @error('tug_number')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full mb-5">
                                        <label for="bunker_id" class="font-bold text-[#232D42] text-[16px]">Gudang</label>
                                        <div class="relative">
                                            <select name="bunker_id" id="bunker_id" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option value="">Pilih</option>
                                                @foreach ($bunkers as $item)
                                                    <option value="{{ $item->id }}" {{ $tug->bunker_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('bunker_id')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full mb-5">
                                        <label for="general_manager" class="font-bold text-[#232D42] text-[16px]">General Manager</label>
                                        <div class="relative">
                                            <select name="general_manager" id="general_manager" class="select-2 select-manager w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option value="">Pilih</option>
                                                @foreach ($managers as $manager)
                                                    <option value="{{ $manager->name }}" {{ $tug->general_manager == $manager->name ? 'selected' : '' }}>{{ $manager->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('general_manager')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                            </div>
                        </div>
                            <div class="flex gap-3">

                            <a href="{{route('inputs.tug-4.index')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>

                            <button  type="button" class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3" onclick="printPDF()">Print</button>
                        </div>
                    </div>
                    <div id="my-pdf" style="display: none;">
                        <div class="p-10" style="font-size: 0.7em;">
                            <div class="p-6 print-page">
                                <div class="flex justify-between items-center mb-4 print-header">
                                    <div>
                                        <h1 class="text-xl font-bold">PLN Indonesia Power</h1>
                                        <h2 class="text-lg">UBP Suralaya</h2>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold">TUG 4</p>
                                    </div>
                                </div>
                                <h4 class="text-center font-bold mb-4">BERITA ACARA PEMERIKSAAN BARANG-BARANG/SPARE PARTS</h4>
                                <p class="text-center mb-6">NO : BB.2024.302/BA/UBPSLA/PBB/2024</p>
                                
                                <div class="mb-4 w-[100px]">
                                    <div class="border-collapse border border-slate-700">
                                        <span>Rabu</span> <br>
                                        <span>26-Jun-24</span>
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <p class="font-bold mb-2">Para Pemeriksa terdiri dari :</p>
                                    <table class="min-w-full border-collapse border border-slate-700" style="font-size: 0.7em;">
                                        <thead>
                                            <tr>
                                                <th class="border border-slate-700 p-2">No.</th>
                                                <th class="border border-slate-700 p-2">Nama</th>
                                                <th class="border border-slate-700 p-2">Jabatan</th>
                                                <th class="border border-slate-700 p-2">Tanda Tangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="border border-slate-700 p-2">1</td>
                                                <td class="border border-slate-700 p-2">Nugroho Prasetyo Rubiyanto</td>
                                                <td class="border border-slate-700 p-2">
                                                    <div class="flex justify-between">
                                                        <span>MREP</span>
                                                        <span>Ketua</span>
                                                    </div>
                                                    
                                                </td>
                                                <td class="border border-slate-700 p-2"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mb-6" style="font-size: 0.7em;">
                                    <p class="mb-2">Telah mengadakan pemeriksaan atas barang-barang/spare parts milik PT. PLN Indonesia Power yang berada di/terima dari: UBP Suralaya Tgl. 26-Jun-24. Menurut Surat Pesanan/B.P. No. ...... Tgl. ...... Gudang ...... </p>
                                    <p class="my-5">dan menyatakan sebagai berikut :</p>
                                    
                                    <table class="min-w-full border-collapse border border-slate-700" style="font-size: 0.7em;">
                                        <thead>
                                            <tr>
                                                <th class="border border-slate-700 p-2">No.</th>
                                                <th class="border border-slate-700 p-2">Nama Barang/Spare Part</th>
                                                <th class="border border-slate-700 p-2">Nomor Norm/Part</th>
                                                <th class="border border-slate-700 p-2">Stn</th>
                                                <th class="border border-slate-700 p-2">*) Banyaknya</th>
                                                <th class="border border-slate-700 p-2">Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="border border-slate-700 p-2">1</td>
                                                <td class="border border-slate-700 p-2">Seluruhnya diterima dengan baik sesuai data terlampir</td>
                                                <td class="border border-slate-700 p-2">
                                                    <div class="mt-4">
                                                        <p class="mb-1">Tanggal penerimaan : 26-Jun-24</p>
                                                        <p class="mb-1">Jumlah B/L : 63.000.000 Kg</p>
                                                        <p class="mb-1">Jumlah D/S : 63.000.163 Kg</p>
                                                        <p class="mb-1">Jumlah Diterima : 63.000.163 Kg</p>
                                                        <p class="mb-1">Nama Kapal : MV. ANDHIKA ATHALIA</p>
                                                        <p class="mb-1">No. Kontrak : 159.PJ/061/IP/2017 tanggal 17 Juli 2017</p>
                                                        <p class="mb-1">No. TUG3 : B.20240626.02</p>
                                                    </div>
                                                </td>
                                                <td class="border border-slate-700 p-2">Kg</td>
                                                <td class="border border-slate-700 p-2">63.000.163</td>
                                                <td class="border border-slate-700 p-2"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                 
                                </div>
                                
                                <div class="flex justify-between mt-6 print-footer" style="font: 0.7em;">
                                    <div class="text-center-print">
                                        <p class="pb-12">PLT SENIOR MANAGER ENERGI PRIMER</p>
                                        <p class="font-bold mt-4">ROMY NURAWAN</p>
                                    </div>
                                    <div class="text-center-print">
                                        <p class="pb-12">GENERAL MANAGER</p>
                                        <p class="font-bold mt-4">IRWAN EDI SYAHPUTRA LUBIS</p>
                                    </div>
                                </div>
                                
                                <p class="text-center mt-6">Model : 030/BR/003/84</p>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

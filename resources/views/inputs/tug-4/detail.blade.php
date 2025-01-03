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
                                        @foreach ($pics as $manager)
                                            <option value="{{ $manager->id }}" {{ $tug->general_manager == $manager->id ? 'selected' : '' }}>{{ $manager->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('general_manager')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full mb-5">
                                <label for="senior_manager" class="font-bold text-[#232D42] text-[16px]">Senior Manager</label>
                                <div class="relative">
                                    <select name="senior_manager" id="senior_manager" class="select-2 select-manager w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option value="">Pilih</option>
                                        @foreach ($pics as $senior)
                                            <option value="{{ $senior->id }}" {{ $tug->senior_manager == $senior->id ? 'selected' : '' }}>{{ $senior->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('senior_manager')
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
                <div class="p-5" style="font-size: 14px;">
                    <div class="p-1 print-page">
                        <div class="flex justify-between items-center mb-4 print-header">
                            <div>
                                <img src="{{asset('logo.png')}}" alt="" width="200 ">
                                <h2 class="text-lg text-right">UBP Suralaya</h2>
                            </div>
                            <div class="text-right">
                                <p class="font-bold">TUG 4</p>
                                <div class="text-right mt-5">
                                    <p class="border border-slate-900">P.I.N. INDONESIA POWER</p>
                                    <p class="border border-slate-900">Cab./UBP/Bkl: SURALAYA</p>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-center font-bold underline">BERITA ACARA PEMERIKSAAN BARANG-BARANG/SPARE PARTS</h4>
                        <p class="text-center mb-6 font-bold">NO : {{$tug->bpb_number}}/BA/UBPSLA/PBB/{{date('Y')}}</p>

                        <div class="mb-4 w-[100px]">
                            <span>Pada hari, tgl</span>
                            <div class="border-collapse border border-slate-900">
                                <span>{{$day}}</span> <br>
                                <span>{{date('d-M-Y', strtotime($tug->receipt_date))}}</span>
                            </div>
                        </div>

                        <div class="mb-6">
                            <p class="font-bold mb-2 text-center">Para Pemeriksa terdiri dari :</p>
                            <table class="min-w-full border-collapse border border-slate-900" style="font-size:14px;">
                                <thead>
                                    <tr>
                                        <th class="border border-slate-900 p-2">No.</th>
                                        <th class="border border-slate-900 p-2">Nama</th>
                                        <th class="border border-slate-900 p-2">Jabatan</th>
                                        <th class="border border-slate-900 p-2">Tanda Tangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inspections as $item)
                                        <tr>
                                            <td class="border border-slate-900 p-2">{{$loop->iteration}}</td>
                                            <td class="border border-slate-900 p-2">{{$item->name}}</td>
                                            <td class="border border-slate-900 p-2">
                                                <div class="flex justify-between">
                                                    <span>{{$item->structural_position}}</span>
                                                    <span>{{$item->functional_role}}</span>
                                                </div>

                                            </td>
                                            <td class="border border-slate-900 p-2"></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div class="mb-6 font-bold" style="font-size: 13px; line-height:1.5;">
                            @if ($tug->type_tug == 'coal-unloading')
                                <p class="mb-2" style="text-align: justify;">Telah mengadakan pemeriksaan atas barang-barang/spare parts milik PT. PLN Indonesia Power yang berada <br> di / terima dari: UBP Suralaya Tgl. {{date('d-M-Y', strtotime($tug->receipt_date))}}. Menurut Surat Pesanan/B.P. No. ............. Tgl. .......... Gudang <span class="border border-slate-900 border-1 p-1 pr-10">{{$tug->bunker->name ?? ''}}</span> </p>
                                <p >dan menyatakan sebagai berikut :</p>
                            @endif
                            @if ($tug->type_tug == 'bbm-receipt')
                                <p class="mb-2" style="text-align: justify;">Telah mengadakan pemeriksaan atas barang-barang/spare parts milik PT. PLN Indonesia Power yang berada <br> di / terima dari: UBP Suralaya Tgl.{{date('d-M-Y', strtotime($tug->receipt_date))}}. Menurut Surat Pesanan/B.P. No. {{$tug->bbm->order->order_number}} Tgl. {{date('d-M-Y', strtotime($tug->bbm->order->order_date))}} Gudang <span class="border border-slate-900 border-1 p-1 pr-10">{{$tug->bunker->name ?? ''}}</span> </p>
                                <p >dan menyatakan sebagai berikut :</p>
                            @endif
                            @if ($tug->type_tug == 'biomassa-receipt')
                                <p class="mb-2" style="text-align: justify;">Telah mengadakan pemeriksaan atas barang-barang/spare parts milik PT. PLN Indonesia Power yang berada <br> di / terima dari: UBP Suralaya Tgl. {{date('d-M-Y', strtotime($tug->receipt_date))}}. Menurut Surat Pesanan/B.P. No. ............. Tgl. .......... Gudang <span class="border border-slate-900 border-1 p-1 pr-10">{{$tug->bunker->name ?? ''}}</span> </p>
                                <p >dan menyatakan sebagai berikut :</p>
                            @endif
                            <table class="min-w-full border-collapse border border-slate-900" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th class="border border-slate-900 p-2">No.</th>
                                        <th class="border border-slate-900 p-2">Nama Barang/Spare Part</th>
                                        <th class="border border-slate-900 p-2">Nomor Norm/Part</th>
                                        <th class="border border-slate-900 p-2">Stn</th>
                                        <th class="border border-slate-900 p-2">*) Banyaknya</th>
                                        <th class="border border-slate-900 p-2">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($tug->type_tug == 'coal-unloading')
                                    <tr>
                                        <td class="px-4 py-2 border border-slate-900"></td>
                                        <td class="px-4 py-2 border border-slate-900">
                                            <table class="table-auto w-full font-bold">
                                                <tr>
                                                    <p class="font-normal">Seluruhnya diterima dengan baik sesuai data terlampir</p>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Tanggal Penerimaan</td>
                                                    <td> : {{date('d-m-Y', strtotime($tug->receipt_date))}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Jumlah B/L</td>
                                                    <td> : {{number_format($tug->coal->bl)}} Kg</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Jumlah DS</td>
                                                    <td> : {{number_format($tug->coal->bl)}} Kg</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Jumlah BW</td>
                                                    <td> : {{number_format($tug->coal->bw)}} Kg</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Jumlah Diterima</td>
                                                    <td> : {{number_format($tug->coal->tug_3_accept)}} Kg</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Nama Kapal</td>
                                                    <td> : {{$tug->coal->ship->name ?? ''}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">No Kontrak</td>
                                                    <td> : {{$tug->coal->contract->contract_number ?? ''}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">No TUG3</td>
                                                    <td> : {{$tug->coal->tug_number ?? ''}}</td>
                                                </tr>
                                              
                                            </table>
                                            
                                        </td>
                                        <td class="px-4 py-2 border border-slate-900">01.001.003.0100</td>
                                        <td class="px-4 py-2 border border-slate-900">Kg</td>
                                        <td class="px-4 py-2 border border-slate-900">{{ number_format($tug->coal->tug_3_accept)}}</td>
                                        <td class="px-4 py-2 border border-slate-900"></td>
                                    </tr>
                                @endif
                                @if ($tug->type_tug == 'bbm-receipt')
                                    @php
                                        $totalbbm = $tug->bbm->amount_receipt - $tug->bbm->faktur_obs;
                                        $percentage = $totalbbm / $tug->bbm->amount_receipt * 100;
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-2 border border-slate-900"></td>
                                        <td class="px-4 py-2 border border-slate-900">
                                            <p style="text-align: justify;" class="font-normal"> Telah diterima dengan baik, dengan
                                                @if ($totalbbm == 0)
                                                    Volume yang sama
                                                @else
                                                    Volume berbeda
                                                @endif
                                                  antara Fisik Bunker di banding dengan B/L  {{$tug->type_fuel == 'solar' ? 'Solar' : 'MFO'}}</p>
                                            <table class="table-auto w-full font-bold">
                                                <tr>
                                                    <td class="pr-4">Keterangan : </td>
                                             
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Jumlah menurut B/L</td>
                                                    <td> : {{$tug->bbm->faktur_obs ? number_format($tug->bbm->faktur_obs) : 0}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Jumlah menurut Liter 15<sup>o</sup> C</td>
                                                    <td> : {{$tug->bbm->faktur_obs ? number_format($tug->bbm->faktur_ltr15) : 0}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Jumlah menurut Fisik Bunker</td>
                                                    <td> : {{$tug->bbm->faktur_obs ? number_format($tug->bbm->amount_receipt) : 0}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Diterima</td>
                                                    <td> : {{$tug->bbm->faktur_obs ? number_format($tug->bbm->amount_receipt) : 0}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Nomor TUG 3</td>
                                                    <td> : {{$tug->bbm->tug3_number ?? ''}}</td>
                                                </tr>
                                            </table>
                                            
                                        </td>
                                        <td class="px-4 py-2 border border-slate-900 align-top"> {{$tug->type_fuel == 'solar' ? '01.001.003.0013' : '01.001.003.0101'}}</td>
                                        <td class="px-4 py-2 border border-slate-900 align-top">L</td>
                                        <td class="px-4 py-2 border border-slate-900 align-top text-nowrap">{{ number_format($totalbbm)}} Liter</td>
                                        <td class="px-4 py-2 border border-slate-900 align-top text-nowrap">{{number_format($percentage,2)}} %</td>
                                    </tr>
                                @endif
                                @if ($tug->type_tug == 'biomassa-receipt')
                                <tr>
                                    <td class="px-4 py-2 border border-slate-900"></td>
                                    <td class="px-4 py-2 border border-slate-900">
                                        <table class="table-auto w-full">
                                            <tr>
                                                <td class="pr-4">Jenis Bahan Bakar </td>
                                                <td> : Biomassa</td>
                                            </tr>
                                            <tr>
                                                <td class="pr-4">Nama Pemasok</td>
                                                <td> : {{$tug->biomassa->supplier->name ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="pr-4">Diterima</td>
                                                <td> : {{ number_format($tug->biomassa->detailReceipt->sum('volume') ?? 0) }} Kg</td>
                                            </tr>
                                        </table>
                                        
                                    </td>
                                    <td class="px-4 py-2 border border-slate-900">01.002.001.0001</td>
                                    <td class="px-4 py-2 border border-slate-900">Kg</td>
                                    <td class="px-4 py-2 border border-slate-900">{{ number_format($tug->biomassa->detailReceipt->sum('volume') ?? 0)}}</td>
                                </tr>
                            @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="px-4 py-2 border border-slate-900" colspan="2">
                                            <div>Kode Perkiraan</div>
                                        </td>
                                        <td class="px-4 py-2 border border-slate-900" colspan="2">
                                            <div class="flex justify-between">
                                                <div>Perintah Kerja</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 border border-slate-900" colspan="2">
                                            <div>Fungsi</div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>


                        </div>
                        <span>*) Diisi jumlah yang rusak / hilang / lebih saja</span>
                        <div class="flex justify-between pb-5 print-footer gap-5">
                            
                            <div class="flex justify-between mt-6 print-footer ml-20" style="font: 14px;">
                                <div class="text-center-print">
                                </div>
                                <div class="text-center-print font-bold">
                                    <p class="pb-20">{{$tug->senior->name_position ?? ''}}</p>
                                    <p class="font-bold mt-4 uppercase text-center">{{$tug->senior->name ?? ''}}</p>
                                </div>
                            </div>
                            <div class="flex justify-between mt-6 print-footer" style="font: 14px;">
                                <div class="text-center-print">
                                </div>
                                <div class="text-center-print font-bold">
                                    <p class="pb-20">{{$tug->manager->name_position ?? ''}}</p>
                                    <p class="font-bold mt-4 uppercase text-center">{{$tug->manager->name ?? ''}}</p>
                                </div>
                            </div>
                        </div>


                        <p class="text-left font-bold">Model : 030/BR/003/84</p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

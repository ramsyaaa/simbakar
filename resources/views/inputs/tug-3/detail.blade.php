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
                                                <option {{$tug->type_fuel == 'Biomassa' ? 'selected' :''}}> Biomassa</option>
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
                                    <div class="w-full">
                                        <label for="usage_amount" class="font-bold text-[#232D42] text-[16px]">Pemeriksa</label>
                                        <div class="relative">
                                            @php
                                                $inspect = '';
                                                if ($tug->type_tug == 'coal-unloading') {
                                                    $inspect = $tug->coal->user_inspection;
                                                } elseif ($tug->type_tug == 'bbm-receipt') {
                                                    $inspect = $tug->bbm->inspector;
                                                }else{
                                                    $inspect = '';
                                                }
                                                
                                            @endphp
                                            <input required type="text" value="{{$inspect}}" name="usage_amount" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            @error('usage_amount')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="usage_amount" class="font-bold text-[#232D42] text-[16px]">Kepala Gudang</label>
                                        <div class="relative">
                                            @php
                                            $head = '';
                                                if ($tug->type_tug == 'coal-unloading') {
                                                    $head = $tug->coal->head_warehouse;
                                                } elseif ($tug->type_tug == 'bbm-receipt') {
                                                    $head = $tug->bbm->head_of_warehouse;
                                                }else{
                                                    $head = '';
                                                }
                                                
                                            @endphp
                                            <input required type="text" value="{{$head}}" name="usage_amount" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
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

                                <a href="{{session('back_url')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>

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
                                    <div class="text-right font-bold">
                                        <p class="uppercase underline">Bon Penerimaan Barang-barang/Spare Parts</p>
                                        <p class="text-center">No: {{$tug->bpb_number}}/BPB/UBPSLA/PBB/{{date('Y')}}</p>
                                    </div>
                                    <div class="text-right">
                                        <p>TUG - 3</p>
                                        <p>{{$tug->tug_number}}</p>
                                        <div class="text-right mt-5">
                                            <p class="border border-slate-900">P.L.N. INDONESIA POWER</p>
                                            <p class="border border-slate-900">Cab./UBP/Bkl. SURALAYA</p>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-slate-900 mt-5">
                                <div class="mt-6">
                                    <div class="flex justify-between">
                                        <div>
                                            @if ($tug->type_tug == 'coal-unloading')
                                            <table class="table-auto w-full">
                                                <tr>
                                                    <td class="pr-4">Diterima tanggal</td>
                                                    <td  > : {{ date('d-m-Y', strtotime($tug->coal->receipt_date)) ?? ''}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Dari</td>
                                                    <td class="font-bold"> : UBP SURALAYA</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Dengan</td>
                                                    <td class="font-bold"> : {{$tug->coal->ship->name ?? ''}}</td>
                                                </tr>
                                            </table>
                                            
                                            
                                            @endif
                                            @if ($tug->type_tug == 'bbm-receipt')
                                                <table class="table-auto w-full">
                                                    <tr>
                                                        <td class="pr-4">Diterima tanggal</td>
                                                        <td class="font-bold"> : {{ date('d-m-Y', strtotime($tug->bbm->date_receipt)) ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pr-4">Dari</td>
                                                        <td class="font-bold"> : UBP SURALAYA</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pr-4">Dengan</td>
                                                        <td class="font-bold"> : {{$tug->bbm->ship->name ?? ''}}</td>
                                                    </tr>
                                                </table>
                                            @endif
                                            @if ($tug->type_tug == 'biomassa-receipt')
                                                <table class="table-auto w-full">
                                                    <tr>
                                                        <td class="pr-4">Diterima tanggal</td>
                                                        <td class="font-bold"> : {{ date('d-m-Y', strtotime($tug->biomassa->date_receipt)) ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pr-4">Dari</td>
                                                        <td class="font-bold"> : UBP SURALAYA</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pr-4">Dengan</td>
                                                        <td class="font-bold"> : Truck</td>
                                                    </tr>
                                                </table>
                                            @endif
                                        </div>
                                        <div class="text-left">
                                            @if ($tug->type_tug == 'coal-unloading')
                                            <table class="table-auto w-full">
                                                <tr>
                                                    <td class="pr-4">Pembelian ditempat lihat faktur / bukti kas no</td>
                                                    <td> : </td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Diterima bon pengeluaran/surat pengantar no</td>
                                                    <td> : </td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Menurut surat pesanan/daftar permintaan no</td>
                                                    <td> : {{$tug->coal->contract->contract_number ?? ''}}</td>
                                                </tr>
                                            </table>
                                            
                                            @endif
                                            @if ($tug->type_tug == 'bbm-receipt')
                                            <table class="table-auto w-full">
                                                <tr>
                                                    <td class="pr-4">Pembelian ditempat lihat faktur / bukti kas no</td>
                                                    <td> :  {{$tug->bbm->order->order_number ?? ''}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Diterima bon pengeluaran/surat pengantar no</td>
                                                    <td> : </td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Menurut surat pesanan/daftar permintaan no:</td>
                                                    <td> : </td>
                                                </tr>
                                            </table>
                                            
                                            @endif
                                            @if ($tug->type_tug == 'biomassa-receipt')
                                            <table class="table-auto w-full">
                                                <tr>
                                                    <td class="pr-4">Pembelian ditempat lihat faktur / bukti kas no</td>
                                                    <td> : </td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Diterima bon pengeluaran/surat pengantar no</td>
                                                    <td> : </td>
                                                </tr>
                                                <tr>
                                                    <td class="pr-4">Menurut surat pesanan/daftar permintaan no:</td>
                                                    <td> : </td>
                                                </tr>
                                            </table>
                                            
                                            @endif
                                        </div>
                                        <div></div>

                                    </div>
                                </div>

                                <table class="mt-6 bg-white w-full">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 border border-slate-900">No. Urut</th>
                                            <th class="px-4 py-2 border border-slate-900">Nama</th>
                                            <th class="px-4 py-2 border border-slate-900">Norm/Part</th>
                                            <th class="px-4 py-2 border border-slate-900">Stn.</th>
                                            <th class="px-4 py-2 border border-slate-900">Banyaknya</th>
                                            <th class="px-4 py-2 border border-slate-900">Keterangan</th>
                                            <th class="px-4 py-2 border border-slate-900">Harga Stn. ( Rp )</th>
                                            <th class="px-4 py-2 border border-slate-900">Jumlah ( Rp )</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($tug->type_tug == 'coal-unloading')
                                            <tr>
                                                <td class="px-4 py-2 border border-slate-900"></td>
                                                <td class="px-4 py-2 border border-slate-900">
                                                    <table class="table-auto w-full">
                                                        <tr>
                                                            <td class="pr-4">Jenis Bahan Bakar</td>
                                                            <td class="font-bold"> : Batubara</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="pr-4">ex.</td>
                                                            <td class="font-bold"> : {{$tug->coal->supplier->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="pr-4 font-bold">Penerimaan Untuk</td>
                                                            <td class="font-bold"> : Unit 1-7</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="pr-4">Pelabuhan Asal</td>
                                                            <td class="font-bold"> : {{$tug->coal->originHarbor->name ?? ''}}</td>
                                                        </tr>
                                                        <tr class="font-bold">
                                                            <td class="pr-4">Draft Survey</td>
                                                            <td> : {{ number_format($tug->coal->ds) }} Kg</td>
                                                        </tr>
                                                        <tr class="font-bold">
                                                            <td class="pr-4">Belt Weigher</td>
                                                            <td> : 0 Kg</td>
                                                        </tr>
                                                        <tr class="font-bold">
                                                            <td class="pr-4">Bill of Lading</td>
                                                            <td> : {{ number_format($tug->coal->bl) }} Kg</td>
                                                        </tr>
                                                        <tr class="font-bold">
                                                            <td class="pr-4">Diterima</td>
                                                            <td> : {{ number_format($tug->coal->tug_3_accept) }} Kg</td>
                                                        </tr>
                                                    </table>
                                                    
                                                </td>
                                                <td class="px-4 py-2 border border-slate-900">01.001.003.0100</td>
                                                <td class="px-4 py-2 border border-slate-900">Kg</td>
                                                <td class="px-4 py-2 border border-slate-900">{{ number_format($tug->coal->tug_3_accept ?? 0)}}</td>
                                                <td class="px-4 py-2 border border-slate-900"></td>
                                                <td class="px-4 py-2 border border-slate-900"></td>
                                                <td class="px-4 py-2 border border-slate-900"></td>
                                            </tr>
                                        @endif
                                        @if ($tug->type_tug == 'bbm-receipt')
                                            <tr>
                                                <td class="px-4 py-2 border border-slate-900"></td>
                                                <td class="px-4 py-2 border border-slate-900">
                                                    <table class="table-auto w-full">
                                                        <tr>
                                                            <td class="pr-4">Jenis Bahan Bakar </td>
                                                            <td> : {{$tug->type_fuel == 'solar' ? 'Solar / HSD' : 'Residu MFO'}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="pr-4">Nama Agen</td>
                                                            <td> : {{$tug->bbm->shipAgent->name ?? ''}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="pr-4">Volume Faktur</td>
                                                            <td> : {{ number_format($tug->bbm->amount_receipt ?? 0) }} Liter</td>
                                                        </tr>
                                                    </table>
                                                    
                                                </td>
                                                <td class="px-4 py-2 border border-slate-900">{{$tug->type_fuel == 'solar' ? '01.001.003.0013' : '01.001.003.0101'}}</td>
                                                <td class="px-4 py-2 border border-slate-900">L</td>
                                                <td class="px-4 py-2 border border-slate-900">{{ number_format($tug->bbm->amount_receipt)}}</td>
                                                <td class="px-4 py-2 border border-slate-900"></td>
                                                <td class="px-4 py-2 border border-slate-900"></td>
                                                <td class="px-4 py-2 border border-slate-900"></td>
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
                                                <td class="px-4 py-2 border border-slate-900"></td>
                                                <td class="px-4 py-2 border border-slate-900"></td>
                                                <td class="px-4 py-2 border border-slate-900"></td>
                                            </tr>
                                        @endif

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="px-4 py-2 border border-slate-900" colspan="2">
                                                <div class="flex justify-between">
                                                    <div>Nota No.</div>
                                                    <div class="mr-24">Kode Perkiraan</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 border border-slate-900" colspan="3">
                                                <div class="flex justify-between">
                                                    <div>Perintah Kerja</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 border border-slate-900">
                                                <div>Fungsi</div>
                                            </td>
                                            <td class="px-4 py-2 border border-slate-900" colspan="2">
                                                <div>Jumlah</div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="mt-6 flex justify-between font-bold">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div class="text-center">
                                        <p class="pb-20">Diperiksa Oleh</p>
                                        @if ($tug->type_tug == 'coal-unloading')
                                            <p>{{$tug->coal->user_inspection}}</p>
                                        @endif
                                        @if ($tug->type_tug == 'bbm-receipt')
                                            <p>{{$tug->bbm->inspector}}</p>
                                        @endif
                                    </div>
                                    <div class="text-center">
                                        <p class="pb-20">Kepala Gudang</p>
                                        @if ($tug->type_tug == 'coal-unloading')
                                            <p>{{$tug->coal->head_warehouse}}</p>
                                        @endif
                                        @if ($tug->type_tug == 'bbm-receipt')
                                            <p>{{$tug->bbm->head_of_warehouse}}</p>
                                        @endif
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

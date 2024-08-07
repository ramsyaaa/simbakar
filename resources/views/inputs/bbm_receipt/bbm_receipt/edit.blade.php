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
                        Ubah Loading
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                         <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.bbm_receipts.index', ['shipment_type' => $shipment_type]) }}">Penerimaan BBM</a> / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Edit Penerimaan BBM?')" action="{{ route('inputs.bbm_receipts.update', ['shipment_type' => $shipment_type, 'id' => $bbm->id]) }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="w-full">
                            <div class="w-full lg:w-6/12">
                                <label for="bbm_type" class="font-bold text-[#232D42] text-[16px]">Jenis BBM</label>
                                <div class="relative">
                                    <select name="bbm_type" id="bbm_type" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option value="">Pilih</option>
                                        <option value="solar" {{ old('bbm_type', $bbm->bbm_type ?? '') == "solar" ? 'selected' : '' }}>Solar/HSD</option>
                                        <option value="residu" {{ old('bbm_type', $bbm->bbm_type ?? '') == "residu" ? 'selected' : '' }}>Residu</option>
                                    </select>
                                    @error('bbm_type')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full lg:w-6/12">
                                <label for="load_company_uuid" class="font-bold text-[#232D42] text-[16px]">PBM</label>
                                <div class="relative">
                                    <select name="load_company_uuid" id="load_company_uuid" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option value="">Pilih</option>
                                        @foreach ($load_companies as $item)
                                            <option value="{{ $item->uuid }}" {{ old('load_company_uuid', $bbm->load_company_uuid ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('load_company_uuid')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="bpb_number" class="font-bold text-[#232D42] text-[16px]">No BPB</label>
                                    <div class="relative">
                                        <input type="text" name="bpb_number" value="{{ old('bpb_number', $bbm->bpb_number ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('bpb_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="order_number" class="font-bold text-[#232D42] text-[16px]">No Pemesanan</label>
                                    <div class="relative">
                                        <input type="text" name="order_number" value="{{ old('order_number', $bbm->order_number ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('order_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="faktur_number" class="font-bold text-[#232D42] text-[16px]">No Faktur/LO</label>
                                    <div class="relative">
                                        <input type="text" name="faktur_number" value="{{ old('faktur_number', $bbm->faktur_number ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('faktur_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                @if($shipment_type == 'ship')
                                <div class="w-full lg:w-6/12">
                                    <label for="port_origin" class="font-bold text-[#232D42] text-[16px]">Pelabuhan Asal</label>
                                    <div class="relative">
                                        <select name="port_origin" id="port_origin" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option value="">Pilih</option>
                                            @foreach ($harbors as $item)
                                                <option value="{{ $item->uuid }}" {{ old('port_origin', $bbm->port_origin ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('port_origin')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="destination_port" class="font-bold text-[#232D42] text-[16px]">Pelabuhan Tujuan</label>
                                    <div class="relative">
                                        <select name="destination_port" id="destination_port" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option value="">Pilih</option>
                                            @foreach ($harbors as $item)
                                                <option value="{{ $item->uuid }}" {{ old('destination_port', $bbm->destination_port ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('destination_port')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="w-full flex gap-4">
                                @if($shipment_type == 'ship')
                                <div class="w-full lg:w-6/12">
                                    <label for="dock" class="font-bold text-[#232D42] text-[16px]">Dermaga</label>
                                    <div class="relative">
                                        <select name="dock" id="dock" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option value="">Pilih</option>
                                            @foreach ($docks as $item)
                                                <option value="{{ $item->uuid }}" {{ old('dock', $bbm->dock ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('dock')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                <div class="w-full lg:w-6/12">
                                    <label for="ship_agent_uuid" class="font-bold text-[#232D42] text-[16px]">Agen</label>
                                    <div class="relative">
                                        <select name="ship_agent_uuid" id="ship_agent_uuid" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option value="">Pilih</option>
                                            @foreach ($ship_agents as $item)
                                                <option value="{{ $item->uuid }}" {{ old('ship_agent_uuid', $bbm->ship_agent_uuid ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('ship_agent_uuid')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="supplier_uuid" class="font-bold text-[#232D42] text-[16px]">Pemasok</label>
                                    <div class="relative">
                                        <select name="supplier_uuid" id="supplier_uuid" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option value="">Pilih</option>
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->uuid }}" {{ old('supplier_uuid', $bbm->supplier_uuid ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_uuid')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="bunker_uuid" class="font-bold text-[#232D42] text-[16px]">Bunker</label>
                                    <div class="relative">
                                        <select name="bunker_uuid" id="bunker_uuid" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option value="">Pilih</option>
                                            @foreach ($bunkers as $item)
                                                <option value="{{ $item->uuid }}" {{ old('bunker_uuid', $bbm->bunker_uuid ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('bunker_uuid')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                @if($shipment_type == 'ship')
                                <div class="w-full lg:w-6/12">
                                    <label for="ship_uuid" class="font-bold text-[#232D42] text-[16px]">Kapal</label>
                                    <div class="relative">
                                        <select name="ship_uuid" id="ship_uuid" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option value="">Pilih</option>
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->uuid }}" {{ old('ship_uuid', $bbm->ship_uuid ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('ship_uuid')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="captain" class="font-bold text-[#232D42] text-[16px]">Nahkoda</label>
                                    <div class="relative">
                                        <input type="text" name="captain" value="{{ old('captain', $bbm->captain ?? '') }}}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('captain')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="w-full flex gap-4">
                                @if($shipment_type == 'car')
                                <div class="w-full lg:w-6/12">
                                    <label for="car_type" class="font-bold text-[#232D42] text-[16px]">Tipe Mobil</label>
                                    <div class="relative">
                                        <input type="text" name="car_type" value="{{ old('car_type', $bbm->car_type ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('car_type')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="police_number" class="font-bold text-[#232D42] text-[16px]">No Polisi</label>
                                    <div class="relative">
                                        <input type="text" name="police_number" value="{{ old('police_number', $bbm->police_number ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('police_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="transporter_uuid" class="font-bold text-[#232D42] text-[16px]">Transportir</label>
                                    <div class="relative">
                                        <select name="transporter_uuid" id="transporter_uuid" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option value="">Pilih</option>
                                            @foreach ($transporters as $item)
                                                <option value="{{ $item->uuid }}" {{ old('transporter_uuid', $bbm->transporter_uuid ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('transporter_uuid')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                @if($shipment_type == 'ship')
                                <div class="w-full lg:w-6/12">
                                    <label for="load_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Loading</label>
                                    <div class="relative">
                                        <input type="datetime-local" name="load_date" value="{{ old('load_date', $bbm->load_date ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('load_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="arrival_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Tiba</label>
                                    <div class="relative">
                                        <input type="datetime-local" name="arrival_date" value="{{ old('arrival_date', $bbm->arrival_date ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('arrival_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="w-full flex gap-4">
                                @if($shipment_type == 'ship')
                                <div class="w-full lg:w-6/12">
                                    <label for="docked_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Sandar</label>
                                    <div class="relative">
                                        <input type="datetime-local" name="docked_date" value="{{ old('docked_date', $bbm->docked_date ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('docked_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                <div class="w-full lg:w-6/12">
                                    <label for="unload_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Bongkar</label>
                                    <div class="relative">
                                        <input type="datetime-local" name="unload_date" value="{{ old('unload_date', $bbm->unload_date ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('unload_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="finish_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Selesai</label>
                                    <div class="relative">
                                        <input type="datetime-local" name="finish_date" value="{{ old('finish_date', $bbm->finish_date ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('finish_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @if($shipment_type == 'ship')
                                <div class="w-full lg:w-6/12">
                                    <label for="departure_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Berangkat</label>
                                    <div class="relative">
                                        <input type="datetime-local" name="departure_date" value="{{ old('departure_date', $bbm->departure_date ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('departure_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="note" class="font-bold text-[#232D42] text-[16px]">Catatan</label>
                                    <div class="relative">
                                        <input type="string" name="note" value="{{ old('note', $bbm->note ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('note')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="w-full py-2 text-center text-white bg-[#2E46BA] mb-4">
                                Detail Analisa
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="faktur_obs" class="font-bold text-[#232D42] text-[16px]">Faktur (OBS)</label>
                                    <div class="relative">
                                        <input type="text" name="faktur_obs" value="{{ old('faktur_obs', $bbm->faktur_obs ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('faktur_obs')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="faktur_ltr15" class="font-bold text-[#232D42] text-[16px]">Faktur (LTR15)</label>
                                    <div class="relative">
                                        <input type="text" name="faktur_ltr15" value="{{ old('faktur_ltr15', $bbm->faktur_ltr15 ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('faktur_ltr15')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="ubl_obs" class="font-bold text-[#232D42] text-[16px]">UBL (OBS) (sebelum load)</label>
                                    <div class="relative">
                                        <input type="text" name="ubl_obs" value="{{ old('ubl_obs', $bbm->ubl_obs ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('ubl_obs')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="ubl_ltr15" class="font-bold text-[#232D42] text-[16px]">UBL (LTR15)</label>
                                    <div class="relative">
                                        <input type="text" name="ubl_ltr15" value="{{ old('ubl_ltr15', $bbm->ubl_ltr15 ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('ubl_ltr15')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="ual_obs" class="font-bold text-[#232D42] text-[16px]">UAL (OBS) (setelah load)</label>
                                    <div class="relative">
                                        <input type="text" name="ual_obs" value="{{ old('ual_obs', $bbm->ual_obs ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('ual_obs')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="ual_ltr15" class="font-bold text-[#232D42] text-[16px]">UAL (LTR15)</label>
                                    <div class="relative">
                                        <input type="text" name="ual_ltr15" value="{{ old('ual_ltr15', $bbm->ual_ltr15 ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('ual_ltr15')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="ubd_obs" class="font-bold text-[#232D42] text-[16px]">UBD (OBS) (sebelum bongkar)</label>
                                    <div class="relative">
                                        <input type="text" name="ubd_obs" value="{{ old('ubd_obs', $bbm->ubd_obs ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('ubd_obs')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="ubd_ltr15" class="font-bold text-[#232D42] text-[16px]">ubd (LTR15)</label>
                                    <div class="relative">
                                        <input type="text" name="ubd_ltr15" value="{{ old('ubd_ltr15', $bbm->ubd_ltr15 ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('ubd_ltr15')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="uad_obs" class="font-bold text-[#232D42] text-[16px]">UAD (OBS) (setelah bongkar)</label>
                                    <div class="relative">
                                        <input type="text" name="uad_obs" value="{{ old('uad_obs', $bbm->uad_obs ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('uad_obs')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="uad_ltr15" class="font-bold text-[#232D42] text-[16px]">UAD (LTR15)</label>
                                    <div class="relative">
                                        <input type="text" name="uad_ltr15" value="{{ old('uad_ltr15', $bbm->uad_ltr15 ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('uad_ltr15')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="vol_level_awal_obs" class="font-bold text-[#232D42] text-[16px]">Vol Level Awal (OBS)</label>
                                    <div class="relative">
                                        <input type="text" name="vol_level_awal_obs" value="{{ old('vol_level_awal_obs', $bbm->vol_level_awal_obs ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('vol_level_awal_obs')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="vol_level_akhir_abs" class="font-bold text-[#232D42] text-[16px]">Vol Level Akhir (OBS)</label>
                                    <div class="relative">
                                        <input type="text" name="vol_level_akhir_abs" value="{{ old('vol_level_akhir_abs', $bbm->vol_level_akhir_abs ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('vol_level_akhir_abs')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="vol_level_awal_ltr15" class="font-bold text-[#232D42] text-[16px]">Vol level Awal (LTR15)</label>
                                    <div class="relative">
                                        <input type="text" name="vol_level_awal_ltr15" value="{{ old('vol_level_awal_ltr15', $bbm->vol_level_awal_ltr15 ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('vol_level_awal_ltr15')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="vol_level_akhir_ltr15" class="font-bold text-[#232D42] text-[16px]">Vol Level Akhir (LTR15)</label>
                                    <div class="relative">
                                        <input type="text" name="vol_level_akhir_ltr15" value="{{ old('vol_level_akhir_ltr15', $bbm->vol_level_akhir_ltr15 ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('vol_level_akhir_ltr15')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="hasil_sond_awal" class="font-bold text-[#232D42] text-[16px]">Hasil Sond Awal</label>
                                    <div class="relative">
                                        <input type="text" name="hasil_sond_awal" value="{{ old('hasil_sond_awal', $bbm->hasil_sond_awal ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('hasil_sond_awal')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="hasil_sond_akhir" class="font-bold text-[#232D42] text-[16px]">Hasil Sond Akhir</label>
                                    <div class="relative">
                                        <input type="text" name="hasil_sond_akhir" value="{{ old('hasil_sond_akhir', $bbm->hasil_sond_akhir ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('hasil_sond_akhir')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="flow_meter_awal" class="font-bold text-[#232D42] text-[16px]">Flow Meter Awal</label>
                                    <div class="relative">
                                        <input type="text" name="flow_meter_awal" value="{{ old('flow_meter_awal', $bbm->flow_meter_awal ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('flow_meter_awal')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="flow_meter_akhir" class="font-bold text-[#232D42] text-[16px]">Flow Meter Akhir</label>
                                    <div class="relative">
                                        <input type="text" name="flow_meter_akhir" value="{{ old('flow_meter_akhir', $bbm->flow_meter_akhir ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('flow_meter_akhir')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="liter_15_tug3" class="font-bold text-[#232D42] text-[16px]">Liter 15 TUG3</label>
                                    <div class="relative">
                                        <input type="text" name="liter_15_tug3" value="{{ old('liter_15_tug3', $bbm->liter_15_tug3 ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('liter_15_tug3')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="w-full py-2 text-center text-white bg-[#2E46BA] mb-4">
                                Detail TUG3
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="tug3_number" class="font-bold text-[#232D42] text-[16px]">No TUG3</label>
                                    <div class="relative">
                                        <input type="text" name="tug3_number" disabled value="{{ old('tug3_number', $bbm->tug3_number ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('tug3_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="date_receipt" class="font-bold text-[#232D42] text-[16px]">Tanggal Terima</label>
                                    <div class="relative">
                                        <input type="date" name="date_receipt" value="{{ old('date_receipt', $bbm->date_receipt ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('date_receipt')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="norm_number" class="font-bold text-[#232D42] text-[16px]">No. Norm/Part</label>
                                    <div class="relative">
                                        <input type="text" name="norm_number" value="{{ old('norm_number', $bbm->norm_number ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('norm_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="unit" class="font-bold text-[#232D42] text-[16px]">Satuan</label>
                                    <div class="relative">
                                        <input type="text" name="unit" value="{{ old('unit', $bbm->unit ?? '') }}" value="Liter" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('unit')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="amount_receipt" class="font-bold text-[#232D42] text-[16px]">Jumlah Terima</label>
                                    <div class="relative">
                                        <input type="text" name="amount_receipt" value="{{ old('amount_receipt', $bbm->amount_receipt ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('amount_receipt')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="inspector" class="font-bold text-[#232D42] text-[16px]">Pemeriksa</label>
                                    <div class="relative">
                                        <select name="inspector" id="inspector" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Pemeriksa</option>
                                            @foreach ($inspections as $inspection)
                                                <option {{old('inspector', $bbm->inspector ?? '') == $inspection->name ? 'selected' :''}}>{{$inspection->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('inspector')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="head_of_warehouse" class="font-bold text-[#232D42] text-[16px]">Kepala Gudang</label>
                                    <div class="relative">
                                        <select name="head_of_warehouse" id="head_of_warehouse" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Kepala Gudang</option>
                                                @foreach ($heads as $head)
                                                <option {{old('head_of_warehouse', $bbm->head_of_warehouse ?? '') == $head->name ? 'selected' :''}}>{{$head->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('head_of_warehouse')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('inputs.bbm_receipts.index', ['shipment_type' => $shipment_type]) }}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Edit Penerimaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

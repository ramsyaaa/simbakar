@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full max-w-[800px] mx-auto py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        Ubah Unloading
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                         <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.analysis.unloadings.index') }}">Analisa</a> / <a href="{{ route('inputs.analysis.unloadings.index') }}" class="cursor-pointer">Unloading</a>  / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Edit Unloading?')" action="{{ route('inputs.analysis.unloadings.update', ['id' => $unloading->id]) }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="w-full">
                            <div class="w-6/12 flex items-center mt-2">
                                <label for="supplier_uuid" class="w-4/12 font-bold text-[#232D42] text-[16px]">Pemasok</label>
                                <div class="relative w-8/12">
                                    <select id="supplier_uuid" class="select-2 w-full border rounded-md h-[24px] px-3">
                                        <option value="">Pilih</option>
                                        @foreach ($suppliers as $item)
                                            <option @isset($unloading->coal_unloading->supplier_id) {{ $unloading->coal_unloading->supplier_id == $item->id ? 'selected' : '' }} @endisset>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_uuid')
                                    <div class="-bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-6/12 flex items-center mt-2">
                                <label for="ship_uuid" class="w-4/12 font-bold text-[#232D42] text-[16px]">Kapal</label>
                                <div class="relative w-8/12">
                                    <select id="ship_uuid" class="select-2 w-full border rounded-md h-[24px] px-3">
                                        <option value="">Pilih</option>
                                        @foreach ($ships as $item)
                                            <option @isset($unloading->coal_unloading->ship_id) {{ $unloading->coal_unloading->ship_id == $item->id ? 'selected' : '' }} @endisset>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('ship_uuid')
                                    <div class="-bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-6/12 flex items-center mt-2">
                                <label for="surveyor_uuid" class="w-4/12 font-bold text-[#232D42] text-[16px]">Surveyor</label>
                                <div class="relative w-8/12">
                                    <select name="surveyor_uuid" id="surveyor_uuid" class="select-2 w-full border rounded-md h-[24px] px-3">
                                        <option value="">Pilih</option>
                                        @foreach ($surveyors as $item)
                                            <option value="{{ $item->uuid }}" {{ old('surveyor_uuid', $unloading->surveyor_uuid ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('surveyor_uuid')
                                    <div class="-bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full flex gap-2 gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="start_unloading" class="w-4/12 font-bold text-[#232D42] text-[16px]">Tanggal Mulai Bongkar</label>
                                    <div class="relative w-8/12">
                                        @isset($unloading->coal_unloading->unloading_date)
                                            @php
                                                $unloadingDate = \Carbon\Carbon::parse($unloading->coal_unloading->unloading_date)->format('Y-m-d\TH:i');
                                            @endphp
                                        @endisset
                                        <input type="datetime-local" disabled value="{{ $unloadingDate ?? '' }}" class="w-full border rounded-md h-[24px] px-3">

                                        @error('start_unloading')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="end_unloading" class="w-4/12 font-bold text-[#232D42] text-[16px]">Tanggal Selesai Bongkar</label>
                                    <div class="relative w-8/12">
                                        @isset($unloading->coal_unloading->end_date)
                                            @php
                                                $endDate = \Carbon\Carbon::parse($unloading->coal_unloading->end_date)->format('Y-m-d\TH:i');
                                            @endphp
                                        @endisset
                                        <input type="datetime-local" disabled value="{{ $endDate ?? '' }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('end_unloading')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="analysis_number" class="w-4/12 font-bold text-[#232D42] text-[16px]">No Analisa</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="analysis_number" value="{{ old('analysis_number', $unloading->analysis_number ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('analysis_number')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="analysis_date" class="w-4/12 font-bold text-[#232D42] text-[16px]">Tanggal Analisa</label>
                                    <div class="relative w-8/12">
                                        <input type="date" name="analysis_date" value="{{ old('analysis_date', $unloading->analysis_date ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('analysis_date')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-4">
                            <div class="w-full py-2 text-center text-white bg-[#2E46BA] mb-4">
                                Proximate Analysis (ASTM D-3172)
                            </div>
                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="moisture_total" class="w-4/12 font-bold text-[#232D42] text-[16px]">Total Moisture</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="moisture_total" value="{{ old('moisture_total', $unloading->moisture_total ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('moisture_total')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="air_dried_moisture" class="w-4/12 font-bold text-[#232D42] text-[16px]">Air Dried Moisture</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="air_dried_moisture" value="{{ old('air_dried_moisture', $unloading->air_dried_moisture ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('air_dried_moisture')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="ash" class="w-4/12 font-bold text-[#232D42] text-[16px]">Ash</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="ash" value="{{ old('ash', $unloading->ash ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('ash')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="volatile_matter" class="w-4/12 font-bold text-[#232D42] text-[16px]">Volatile Matter</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="volatile_matter" value="{{ old('volatile_matter', $unloading->volatile_matter ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('volatile_matter')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="fixed_carbon" class="w-4/12 font-bold text-[#232D42] text-[16px]">Fixed Carbon</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="fixed_carbon" value="{{ old('fixed_carbon', $unloading->fixed_carbon ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('fixed_carbon')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="total_sulfur" class="w-4/12 font-bold text-[#232D42] text-[16px]">Total Sulfur</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="total_sulfur" value="{{ old('total_sulfur', $unloading->total_sulfur ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('total_sulfur')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="calorivic_value" class="w-4/12 font-bold text-[#232D42] text-[16px]">Calorivic Value</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="calorivic_value" value="{{ old('calorivic_value', $unloading->calorivic_value ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('calorivic_value')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-4">
                            <div class="w-full py-2 text-center text-white bg-[#2E46BA] mb-4">
                                Ultimate Analysis (ASTM D-3176)
                            </div>
                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="carbon" class="w-4/12 font-bold text-[#232D42] text-[16px]">Carbon</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="carbon" value="{{ old('carbon', $unloading->carbon ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('carbon')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="hydrogen" class="w-4/12 font-bold text-[#232D42] text-[16px]">Hydrogen</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="hydrogen" value="{{ old('hydrogen', $unloading->hydrogen ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('hydrogen')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="nitrogen" class="w-4/12 font-bold text-[#232D42] text-[16px]">Nitrogen</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="nitrogen" value="{{ old('nitrogen', $unloading->nitrogen ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('nitrogen')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="oxygen" class="w-4/12 font-bold text-[#232D42] text-[16px]">Oxygen</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="oxygen" value="{{ old('oxygen', $unloading->oxygen ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('oxygen')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-4">
                            <div class="w-full py-2 text-center text-white bg-[#2E46BA] mb-4">
                                Ash Fussion Temperature (ASTM D-1857)
                            </div>
                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="initial_deformation" class="w-4/12 font-bold text-[#232D42] text-[16px]">Initial Deformation</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="initial_deformation" value="{{ old('initial_deformation', $unloading->initial_deformation ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('initial_deformation')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="softening" class="w-4/12 font-bold text-[#232D42] text-[16px]">Softening</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="softening" value="{{ old('softening', $unloading->softening ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('softening')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="hemispherical" class="w-4/12 font-bold text-[#232D42] text-[16px]">Hemispherical</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="hemispherical" value="{{ old('hemispherical', $unloading->hemispherical ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('hemispherical')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="fluid" class="w-4/12 font-bold text-[#232D42] text-[16px]">Fluid</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="fluid" value="{{ old('fluid', $unloading->fluid ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('fluid')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-4">
                            <div class="w-full py-2 text-center text-white bg-[#2E46BA] mb-4">
                                Ash Analysis (ASTM D-3682)
                            </div>
                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="sio2" class="w-4/12 font-bold text-[#232D42] text-[16px]">SiO2</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="sio2" value="{{ old('sio2', $unloading->sio2 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('sio2')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="al2o3" class="w-4/12 font-bold text-[#232D42] text-[16px]">Al2O3</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="al2o3" value="{{ old('al2o3', $unloading->al2o3 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('al2o3')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="fe2o3" class="w-4/12 font-bold text-[#232D42] text-[16px]">Fe2O3</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="fe2o3" value="{{ old('fe2o3', $unloading->fe2o3 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('fe2o3')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="cao" class="w-4/12 font-bold text-[#232D42] text-[16px]">CaO</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="cao" value="{{ old('cao', $unloading->cao ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('cao')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="mgo" class="w-4/12 font-bold text-[#232D42] text-[16px]">MgO</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="mgo" value="{{ old('mgo', $unloading->mgo ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('mgo')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="na2o" class="w-4/12 font-bold text-[#232D42] text-[16px]">Na2O</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="na2o" value="{{ old('na2o', $unloading->na2o ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('na2o')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="k2o" class="w-4/12 font-bold text-[#232D42] text-[16px]">K2O</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="k2o" value="{{ old('k2o', $unloading->k2o ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('k2o')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="tlo2" class="w-4/12 font-bold text-[#232D42] text-[16px]">TlO2</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="tlo2" value="{{ old('tlo2', $unloading->tlo2 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('tlo2')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="so3" class="w-4/12 font-bold text-[#232D42] text-[16px]">SO3</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="so3" value="{{ old('so3', $unloading->so3 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('so3')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="p2o5" class="w-4/12 font-bold text-[#232D42] text-[16px]">P2O5</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="p2o5" value="{{ old('p2o5', $unloading->p2o5 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('p2o5')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="mn3o4" class="w-4/12 font-bold text-[#232D42] text-[16px]">Mn3O4</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="mn3o4" value="{{ old('mn3o4', $unloading->mn3o4 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('mn3o4')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-4">
                            <div class="w-full py-2 text-center text-white bg-[#2E46BA] mb-4">
                                Ukuran Butiran Batubara (ASTM D-197)
                            </div>
                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="butiran_70" class="w-4/12 font-bold text-[#232D42] text-[16px]">Butiran > 70 mm</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="butiran_70" value="{{ old('butiran_70', $unloading->butiran_70 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('butiran_70')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="butiran_50" class="w-4/12 font-bold text-[#232D42] text-[16px]">Butiran > 50 mm</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="butiran_50" value="{{ old('butiran_50', $unloading->butiran_50 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('butiran_50')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="butiran_32_50" class="w-4/12 font-bold text-[#232D42] text-[16px]">Butiran 32 - 50 mm</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="butiran_32_50" value="{{ old('butiran_32_50', $unloading->butiran_32_50 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('butiran_32_50')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="butiran_32" class="w-4/12 font-bold text-[#232D42] text-[16px]">Butiran < 32 mm</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="butiran_32" value="{{ old('butiran_32', $unloading->butiran_32 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('butiran_32')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="butiran_238" class="w-4/12 font-bold text-[#232D42] text-[16px]">Butiran < 2,38 mm</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="butiran_238" value="{{ old('butiran_238', $unloading->butiran_238 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('butiran_238')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-4">
                            <div class="w-full py-2 text-center text-white bg-[#2E46BA] mb-4">
                                Lain-Lain
                            </div>
                            <div class="w-full flex gap-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="hgi" class="w-4/12 font-bold text-[#232D42] text-[16px]">HGI</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="hgi" value="{{ old('hgi', $unloading->hgi ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('hgi')
                                        <div class="-bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{session('back_url')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Edit Unloading</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

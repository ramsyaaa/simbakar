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
                        Ubah Preloading
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                         <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.analysis.preloadings.index') }}">Analisa</a> / <a href="{{ route('inputs.analysis.preloadings.index') }}" class="cursor-pointer">Preloading</a>  / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Edit Preloading?')" action="{{ route('inputs.analysis.preloadings.update', ['id' => $preloading->id]) }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="w-full mt-2">
                            <div class="w-6/12 flex items-center mt-2">
                                <label for="supplier_id" class="w-4/12 font-bold text-[#232D42] text-[16px]">Supplier</label>
                                <div class="relative w-8/12">
                                    <select name="supplier_id" id="supplier_id" class="select-2 w-full border rounded-md h-[24px] px-3">
                                        <option value="">Pilih</option>
                                        @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}" {{ old('supplier_id', $preloading->supplier_id ?? '') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-6/12 flex items-center mt-2">
                                <label for="contract_uuid" class="w-4/12 font-bold text-[#232D42] text-[16px]">No Kontrak</label>
                                <div class="relative w-8/12">
                                    <select name="contract_uuid" id="contract_uuid" class="select-2 w-full border rounded-md h-[24px] px-3">
                                        <option value="">Pilih</option>
                                    </select>
                                    @error('contract_uuid')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full flex gap-4 mt-2">
                                <div class="w-6/12 flex items-center">
                                    <label for="analysis_number" class="w-4/12 font-bold text-[#232D42] text-[16px]">No Analisa</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="analysis_number" value="{{ old('analysis_number', $preloading->analysis_number ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('analysis_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center">
                                    <label for="analysis_date" class="w-4/12 font-bold text-[#232D42] text-[16px]">Tanggal Analisa</label>
                                    <div class="relative w-8/12">
                                        <input type="date" name="analysis_date" value="{{ old('analysis_date', $preloading->analysis_date ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('analysis_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4 mt-2">
                                <div class="w-6/12 flex items-center">
                                    <label for="tonase" class="w-4/12 font-bold text-[#232D42] text-[16px]">Tonase ( Kg )</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="tonase" value="{{ old('tonase', $preloading->tonase ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('tonase')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center">
                                    <label for="surveyor_uuid" class="w-4/12 font-bold text-[#232D42] text-[16px]">Surveyor</label>
                                    <div class="relative w-8/12">
                                        <select name="surveyor_uuid" id="surveyor_uuid" class="select-2 w-full border rounded-md h-[24px] px-3">
                                            <option value="">Pilih</option>
                                            @foreach ($surveyors as $item)
                                            <option value="{{ $item->uuid }}" {{ old('surveyor_uuid', $preloading->surveyor_uuid ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('surveyor_uuid')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-6/12 flex items-center mt-2">
                                <label for="origin_of_goods" class="w-4/12 font-bold text-[#232D42] text-[16px]">Asal Barang</label>
                                <div class="relative w-8/12">
                                    <input type="text" name="origin_of_goods" value="{{ old('origin_of_goods', $preloading->origin_of_goods ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                    @error('origin_of_goods')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-4">
                            <div class="w-full py-2 text-center text-white bg-[#2E46BA] mb-4">
                                Proximate Analysis (ASTM D-3172)
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="moisture_total" class="w-4/12 font-bold text-[#232D42] text-[16px]">Total Moisture</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="moisture_total" value="{{ old('moisture_total', $preloading->moisture_total ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('moisture_total')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="air_dried_moisture" class="w-4/12 font-bold text-[#232D42] text-[16px]">Air Dried Moisture</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="air_dried_moisture" value="{{ old('air_dried_moisture', $preloading->air_dried_moisture ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('air_dried_moisture')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="ash" class="w-4/12 font-bold text-[#232D42] text-[16px]">Ash</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="ash" value="{{ old('ash', $preloading->ash ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('ash')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="volatile_matter" class="w-4/12 font-bold text-[#232D42] text-[16px]">Volatile Matter</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="volatile_matter" value="{{ old('volatile_matter', $preloading->volatile_matter ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('volatile_matter')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="fixed_carbon" class="w-4/12 font-bold text-[#232D42] text-[16px]">Fixed Carbon</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="fixed_carbon" value="{{ old('fixed_carbon', $preloading->fixed_carbon ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('fixed_carbon')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="total_sulfur" class="w-4/12 font-bold text-[#232D42] text-[16px]">Total Sulfur</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="total_sulfur" value="{{ old('total_sulfur', $preloading->total_sulfur ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('total_sulfur')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="calorivic_value" class="w-4/12 font-bold text-[#232D42] text-[16px]">Calorivic Value</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="calorivic_value" value="{{ old('calorivic_value', $preloading->calorivic_value ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('calorivic_value')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
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
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="carbon" class="w-4/12 font-bold text-[#232D42] text-[16px]">Carbon</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="carbon" value="{{ old('carbon', $preloading->carbon ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('carbon')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="hydrogen" class="w-4/12 font-bold text-[#232D42] text-[16px]">Hydrogen</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="hydrogen" value="{{ old('hydrogen', $preloading->hydrogen ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('hydrogen')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="nitrogen" class="w-4/12 font-bold text-[#232D42] text-[16px]">Nitrogen</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="nitrogen" value="{{ old('nitrogen', $preloading->nitrogen ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('nitrogen')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="oxygen" class="w-4/12 font-bold text-[#232D42] text-[16px]">Oxygen</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="oxygen" value="{{ old('oxygen', $preloading->oxygen ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('oxygen')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
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
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="initial_deformation" class="w-4/12 font-bold text-[#232D42] text-[16px]">Initial Deformation</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="initial_deformation" value="{{ old('initial_deformation', $preloading->initial_deformation ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('initial_deformation')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="softening" class="w-4/12 font-bold text-[#232D42] text-[16px]">Softening</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="softening" value="{{ old('softening', $preloading->softening ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('softening')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="hemispherical" class="w-4/12 font-bold text-[#232D42] text-[16px]">Hemispherical</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="hemispherical" value="{{ old('hemispherical', $preloading->hemispherical ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('hemispherical')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="fluid" class="w-4/12 font-bold text-[#232D42] text-[16px]">Fluid</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="fluid" value="{{ old('fluid', $preloading->fluid ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('fluid')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
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
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="sio2" class="w-4/12 font-bold text-[#232D42] text-[16px]">SiO2</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="sio2" value="{{ old('sio2', $preloading->sio2 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('sio2')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="al2o3" class="w-4/12 font-bold text-[#232D42] text-[16px]">Al2O3</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="al2o3" value="{{ old('al2o3', $preloading->al2o3 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('al2o3')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="fe2o3" class="w-4/12 font-bold text-[#232D42] text-[16px]">Fe2O3</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="fe2o3" value="{{ old('fe2o3', $preloading->fe2o3 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('fe2o3')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="cao" class="w-4/12 font-bold text-[#232D42] text-[16px]">CaO</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="cao" value="{{ old('cao', $preloading->cao ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('cao')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="mgo" class="w-4/12 font-bold text-[#232D42] text-[16px]">MgO</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="mgo" value="{{ old('mgo', $preloading->mgo ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('mgo')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="na2o" class="w-4/12 font-bold text-[#232D42] text-[16px]">Na2O</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="na2o" value="{{ old('na2o', $preloading->na2o ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('na2o')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="k2o" class="w-4/12 font-bold text-[#232D42] text-[16px]">K2O</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="k2o" value="{{ old('k2o', $preloading->k2o ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('k2o')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="tlo2" class="w-4/12 font-bold text-[#232D42] text-[16px]">TlO2</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="tlo2" value="{{ old('tlo2', $preloading->tlo2 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('tlo2')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="so3" class="w-4/12 font-bold text-[#232D42] text-[16px]">SO3</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="so3" value="{{ old('so3', $preloading->so3 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('so3')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="p2o5" class="w-4/12 font-bold text-[#232D42] text-[16px]">P2O5</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="p2o5" value="{{ old('p2o5', $preloading->p2o5 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('p2o5')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 mt-2">
                                    <label for="mn3o4" class="w-4/12 font-bold text-[#232D42] text-[16px]">Mn3O4</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="mn3o4" value="{{ old('mn3o4', $preloading->mn3o4 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('mn3o4')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
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
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="butiran_70" class="w-4/12 font-bold text-[#232D42] text-[16px]">Butiran > 70 mm</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="butiran_70" value="{{ old('butiran_70', $preloading->butiran_70 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('butiran_70')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="butiran_50" class="w-4/12 font-bold text-[#232D42] text-[16px]">Butiran > 50 mm</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="butiran_50" value="{{ old('butiran_50', $preloading->butiran_50 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('butiran_50')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="butiran_32_50" class="w-4/12 font-bold text-[#232D42] text-[16px]">Butiran 32 - 50 mm</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="butiran_32_50" value="{{ old('butiran_32_50', $preloading->butiran_32_50 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('butiran_32_50')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="butiran_32" class="w-4/12 font-bold text-[#232D42] text-[16px]">Butiran < 32 mm</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="butiran_32" value="{{ old('butiran_32', $preloading->butiran_32 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('butiran_32')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="butiran_238" class="w-4/12 font-bold text-[#232D42] text-[16px]">Butiran < 2,38 mm</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="butiran_238" value="{{ old('butiran_238', $preloading->butiran_238 ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('butiran_238')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
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
                            <div class="w-full flex gap-4 mt-2">
                                <div class="w-6/12 flex items-center mt-2">
                                    <label for="hgi" class="w-4/12 font-bold text-[#232D42] text-[16px]">HGI</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="hgi" value="{{ old('hgi', $preloading->hgi ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('hgi')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('inputs.analysis.preloadings.index') }}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Edit Preloading</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Fungsi untuk memuat kontrak berdasarkan supplier_id
    function loadContracts(supplier_id, selected_contract_uuid = null) {
        if (!supplier_id) {
            $('#contract_uuid').html('<option value="">Pilih</option>');
            return;
        }

        $.ajax({
            url: `{{ route('getSupplierContractList', ':supplierId') }}`.replace(':supplierId', supplier_id),
            method: 'GET',
            success: function (data) {
                let contractSelect = $('#contract_uuid');
                contractSelect.html('<option value="">Pilih</option>'); // Reset pilihan

                // Variabel untuk menyimpan indeks dari opsi terakhir
                let lastOptionIndex = -1;

                // Mengisi elemen select dengan data yang diterima dari API
                $.each(data, function (index, contract) {
                    let selected = (contract.uuid === selected_contract_uuid) ? 'selected' : '';
                    contractSelect.append(`<option value="${contract.uuid}" ${selected}>${contract.contract_number}</option>`);
                    lastOptionIndex = index; // Memperbarui indeks opsi terakhir
                });

                // Jika selected_contract_uuid tidak ada dan terdapat data, pilih opsi terakhir
                if (selected_contract_uuid === null && lastOptionIndex !== -1) {
                    contractSelect.find('option').last().prop('selected', true); // Pilih opsi terakhir
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    }

    // Ketika halaman pertama kali di-load
    $(document).ready(function () {
        let supplierId = $('#supplier_id').val();
        let selectedContractUuid = '{{ $preloading->contract_uuid }}'; // Dapatkan UUID kontrak yang sudah disimpan

        // Jika ada supplier_id yang dipilih, muat kontrak terkait
        if (supplierId) {
            loadContracts(supplierId, selectedContractUuid);
        }
    });

    // Ketika user mengganti supplier
    $('#supplier_id').on('change', function () {
        let supplierId = $(this).val();
        loadContracts(supplierId); // Panggil API tanpa UUID terpilih
    });
</script>

@endsection

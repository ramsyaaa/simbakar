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
                        Tambah Analisa Setelah Pembongkaran
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.analysis-bbm.afters.index') }}">Analisa</a> / <a href="{{ route('inputs.analysis-bbm.afters.index') }}" class="cursor-pointer">Setelah Bongkar</a>  / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Analisa?')" action="{{ route('inputs.analysis-bbm.afters.store') }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="w-full flex gap-4">
                            <div class="w-full lg:w-6/12">
                                <label for="order_number" class="font-bold text-[#232D42] text-[16px]">No Faktur Penerimaan</label>
                                <div class="relative">
                                    <select name="faktur_number" id="faktur_number" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option value="">Pilih Penerimaan</option>
                                        @foreach ($bbm_receipt as $item)
                                            <option value="{{ $item->id }}" {{ old('faktur_number') == $item->id ? 'selected' : '' }}>{{ $item->faktur_number }}</option>
                                        @endforeach
                                    </select>
                                    @error('faktur_number')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="w-full flex gap-4">
                                <div class="w-full">
                                    <label for="analysis_number" class="font-bold text-[#232D42] text-[16px]">No Analisa</label>
                                    <div class="relative">
                                        <input type="text" name="analysis_number" value="{{ old('analysis_number') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('analysis_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="analysis_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Analisa</label>
                                    <div class="relative">
                                        <input type="date" name="analysis_date" value="{{ old('analysis_date') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('analysis_date')
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
                                Report Analysis
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-full">
                                    <label for="density" class="font-bold text-[#232D42] text-[16px]">Density at 15&deg;C</label>
                                    <div class="relative">
                                        <input type="text" name="density" value="{{ old('density') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('density')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="spesific_gravity" class="font-bold text-[#232D42] text-[16px]">Specific Gravity at 60/60 F</label>
                                    <div class="relative">
                                        <input type="text" name="spesific_gravity" value="{{ old('spesific_gravity') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('spesific_gravity')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-full">
                                    <label for="kinematic_viscosity" class="font-bold text-[#232D42] text-[16px]">Kinematic Viscosity at 40</label>
                                    <div class="relative">
                                        <input type="text" name="kinematic_viscosity" value="{{ old('kinematic_viscosity') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('kinematic_viscosity')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="sulfur_content" class="font-bold text-[#232D42] text-[16px]">Sulfur Content</label>
                                    <div class="relative">
                                        <input type="text" name="sulfur_content" value="{{ old('sulfur_content') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('sulfur_content')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-full">
                                    <label for="flash_point" class="font-bold text-[#232D42] text-[16px]">Flash Point PMcc</label>
                                    <div class="relative">
                                        <input type="text" name="flash_point" value="{{ old('flash_point') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('flash_point')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="pour_point" class="font-bold text-[#232D42] text-[16px]">Pour Point</label>
                                    <div class="relative">
                                        <input type="text" name="pour_point" value="{{ old('pour_point') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('pour_point')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-full">
                                    <label for="carbon_residu" class="font-bold text-[#232D42] text-[16px]">Carbon Residue</label>
                                    <div class="relative">
                                        <input type="text" name="carbon_residu" value="{{ old('carbon_residu') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('carbon_residu')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="water_content" class="font-bold text-[#232D42] text-[16px]">Water Content</label>
                                    <div class="relative">
                                        <input type="text" name="water_content" value="{{ old('water_content') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('water_content')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-full">
                                    <label for="fame_content" class="font-bold text-[#232D42] text-[16px]">FAME Content</label>
                                    <div class="relative">
                                        <input type="text" name="fame_content" value="{{ old('fame_content') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('fame_content')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="ash_content" class="font-bold text-[#232D42] text-[16px]">Ash Content</label>
                                    <div class="relative">
                                        <input type="text" name="ash_content" value="{{ old('ash_content') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('ash_content')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-full">
                                    <label for="sediment_content" class="font-bold text-[#232D42] text-[16px]">Sediment Content</label>
                                    <div class="relative">
                                        <input type="text" name="sediment_content" value="{{ old('sediment_content') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('sediment_content')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="calorific_value" class="font-bold text-[#232D42] text-[16px]">Calorific Value, Gross</label>
                                    <div class="relative">
                                        <input type="text" name="calorific_value" value="{{ old('calorific_value') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('calorific_value')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-full">
                                    <label for="sodium" class="font-bold text-[#232D42] text-[16px]">Sodium (Na)</label>
                                    <div class="relative">
                                        <input type="text" name="sodium" value="{{ old('sodium') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('sodium')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="potassium" class="font-bold text-[#232D42] text-[16px]">Potassium (K)</label>
                                    <div class="relative">
                                        <input type="text" name="potassium" value="{{ old('potassium') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('potassium')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-full">
                                    <label for="vanadium" class="font-bold text-[#232D42] text-[16px]">Vanadium (V)</label>
                                    <div class="relative">
                                        <input type="text" name="vanadium" value="{{ old('vanadium') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('vanadium')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('inputs.analysis-bbm.afters.index') }}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah Analisa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

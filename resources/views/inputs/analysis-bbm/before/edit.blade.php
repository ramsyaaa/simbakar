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
                        Ubah Analisa Sebelum Pembongkaran
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.analysis-bbm.befores.index') }}">Analisa</a> / <a href="{{ route('inputs.analysis-bbm.befores.index') }}" class="cursor-pointer">Sebelum Bongkar</a>  / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Update Analisa?')" action="{{ route('inputs.analysis-bbm.befores.update', ['id' => $analytic->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="w-full">
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="analysis_number" class="w-4/12 font-bold text-[#232D42] text-[16px]">No Analisa</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="analysis_number" value="{{ old('analysis_number', $analytic->analysis_number ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('analysis_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="analysis_date" class="w-4/12 font-bold text-[#232D42] text-[16px]">Tanggal Analisa</label>
                                    <div class="relative w-8/12">
                                        <input type="date" name="analysis_date" value="{{ old('analysis_date', $analytic->analysis_date ?? '') }}" class="w-full border rounded-md h-[24px] px-3">
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
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="density" class="w-4/12 font-bold text-[#232D42] text-[16px]">Density at 15&deg;C</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="density" value="{{ old('density', $analytic->density ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('density')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="spesific_gravity" class="w-4/12 font-bold text-[#232D42] text-[16px]">Specific Gravity at 60/60 F</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="spesific_gravity" value="{{ old('spesific_gravity', $analytic->spesific_gravity ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('spesific_gravity')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="kinematic_viscosity" class="w-4/12 font-bold text-[#232D42] text-[16px]">Kinematic Viscosity at 40</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="kinematic_viscosity" value="{{ old('kinematic_viscosity', $analytic->kinematic_viscosity ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('kinematic_viscosity')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="sulfur_content" class="w-4/12 font-bold text-[#232D42] text-[16px]">Sulfur Content</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="sulfur_content" value="{{ old('sulfur_content', $analytic->sulfur_content ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('sulfur_content')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="flash_point" class="w-4/12 font-bold text-[#232D42] text-[16px]">Flash Point PMcc</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="flash_point" value="{{ old('flash_point', $analytic->flash_point ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('flash_point')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="pour_point" class="w-4/12 font-bold text-[#232D42] text-[16px]">Pour Point</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="pour_point" value="{{ old('pour_point', $analytic->pour_point ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('pour_point')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="carbon_residu" class="w-4/12 font-bold text-[#232D42] text-[16px]">Carbon Residue</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="carbon_residu" value="{{ old('carbon_residu', $analytic->carbon_residu ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('carbon_residu')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="water_content" class="w-4/12 font-bold text-[#232D42] text-[16px]">Water Content</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="water_content" value="{{ old('water_content', $analytic->water_content ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('water_content')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="fame_content" class="w-4/12 font-bold text-[#232D42] text-[16px]">FAME Content</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="fame_content" value="{{ old('fame_content', $analytic->fame_content ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('fame_content')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="ash_content" class="w-4/12 font-bold text-[#232D42] text-[16px]">Ash Content</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="ash_content" value="{{ old('ash_content', $analytic->ash_content ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('ash_content')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="sediment_content" class="w-4/12 font-bold text-[#232D42] text-[16px]">Sediment Content</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="sediment_content" value="{{ old('sediment_content', $analytic->sediment_content ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('sediment_content')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="calorific_value" class="w-4/12 font-bold text-[#232D42] text-[16px]">Calorific Value, Gross</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="calorific_value" value="{{ old('calorific_value', $analytic->calorific_value ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('calorific_value')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="sodium" class="w-4/12 font-bold text-[#232D42] text-[16px]">Sodium (Na)</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="sodium"value="{{ old('sodium', $analytic->sodium ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('sodium')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="potassium" class="w-4/12 font-bold text-[#232D42] text-[16px]">Potassium (K)</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="potassium" value="{{ old('potassium', $analytic->potassium ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('potassium')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="vanadium" class="w-4/12 font-bold text-[#232D42] text-[16px]">Vanadium (V)</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="vanadium" value="{{ old('vanadium', $analytic->vanadium ?? '') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('vanadium')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{session('back_url')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Update Analisa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

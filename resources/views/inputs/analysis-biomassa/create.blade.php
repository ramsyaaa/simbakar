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
                        Tambah Analisa Biomassa
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.analysis-biomassa.index') }}">Analisa</a> / <a href="{{ route('inputs.analysis-biomassa.index') }}" class="cursor-pointer">Sebelum Bongkar</a>  / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Analisa?')" action="{{ route('inputs.analysis-biomassa.store') }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="w-full flex gap-4">
                            <div class="w-6/12 flex items-center mt-2 gap-2">
                                <label for="faktur_number" class="w-4/12 font-bold text-[#232D42] text-[16px]">No Faktur Penerimaan</label>
                                <div class="relative w-8/12">
                                    <select name="faktur_number" id="faktur_number" class="select-2 w-full border rounded-md h-[24px] px-3">
                                        <option value="">Pilih Penerimaan</option>
                                        @foreach ($biomassa_receipt as $item)
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
                        <div class="w-full flex gap-4 mb-3">
                            <div class="w-6/12 flex items-center mt-2 gap-2">
                                <label for="order_number" class="w-4/12 font-bold text-[#232D42] text-[16px]">Kontrak</label>
                                <div class="relative w-8/12">
                                    <select name="contract_id" id="contract_id" class="select-2 w-full border rounded-md mt-3 h-[24px] px-3 select-contract">
                                        <option selected disabled>Pilih Kontrak</option>
                                        @foreach ($contracts as $item)
                                            <option value="{{ $item->id }}" {{ old('contract_id') == $item->id ? 'selected' : '' }}>{{$item->contract_number}} - {{ $item->supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('contract_id')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-6/12 flex items-center mt-2 gap-2">
                                <label for="order_number" class="w-4/12 font-bold text-[#232D42] text-[16px]">Sub Supplier</label>
                                <div class="relative w-8/12">
                                    <select name="sub_supplier_id" id="sub_supplier_id" class="select-2 w-full border rounded-md mt-3 h-[24px] px-3 select-sub-supplier">

                                    </select>
                                    @error('sub_supplier_id')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full mb-3">
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="analysis_number" class="w-4/12 font-bold text-[#232D42] text-[16px]">No Analisa</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="analysis_number" value="{{ old('analysis_number') }}" class="w-full border rounded-md mt-3 h-[24px] px-3">
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
                                        <input type="date" name="analysis_date" value="{{ old('analysis_date') }}" class="w-full border rounded-md mt-3 h-[24px] px-3">
                                        @error('analysis_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="start_date" class="w-4/12 font-bold text-[#232D42] text-[16px]">Tanggal Mulai</label>
                                    <div class="relative w-8/12">
                                        <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('start_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="end_date" class="w-4/12 font-bold text-[#232D42] text-[16px]">Tanggal Selesai</label>
                                    <div class="relative w-8/12">
                                        <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" class="w-full border rounded-md h-[24px] px-3">
                                        @error('end_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="tonage" class="w-4/12 font-bold text-[#232D42] text-[16px]">Tonase</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="tonage" value="{{ old('tonage') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('tonage')
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
                                    <label for="total_moisure" class="w-4/12 font-bold text-[#232D42] text-[16px]">Total Moisure</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="total_moisure" value="{{ old('total_moisure') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('total_moisure')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="moisure_in_analysis" class="w-4/12 font-bold text-[#232D42] text-[16px]">Moisure In Analysis</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="moisure_in_analysis" value="{{ old('moisure_in_analysis') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('moisure_in_analysis')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="calorivic_value" class="w-4/12 font-bold text-[#232D42] text-[16px]">Calorivic Value</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="calorivic_value" value="{{ old('calorivic_value') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('calorivic_value')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="size_distribution" class="w-4/12 font-bold text-[#232D42] text-[16px]">Size Distribution</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="size_distribution" value="{{ old('size_distribution') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('size_distribution')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="retained_5" class="w-4/12 font-bold text-[#232D42] text-[16px]">Retained 5</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="retained_5" value="{{ old('retained_5') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('retained_5')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="retained_238" class="w-4/12 font-bold text-[#232D42] text-[16px]">Retained 2,38</label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="retained_238" value="{{ old('retained_238') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('retained_238')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex gap-4">
                                <div class="w-6/12 flex items-center mt-2 gap-2">
                                    <label for="passing_238" class="w-4/12 font-bold text-[#232D42] text-[16px]">Passing 2,38 </label>
                                    <div class="relative w-8/12">
                                        <input type="text" name="passing_238" value="{{ old('passing_238') }}" class="w-full border rounded-md h-[24px] px-3 format-number">
                                        @error('passing_238')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{session('back_url')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah Analisa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $('.select-contract').change(function(){
            let id  = $(this).val();
            let token = "{{ csrf_token() }}"
            $(".select-sub-supplier").empty()
            $.ajax({
                method: "post",
                url: "{{route('getSubSupplier')}}",
                data: {
                    _token:token,
                    id:id,
                    },
                success: function (response) {
                    var suppliers = response
                    console.log(suppliers)
                    $(".select-sub-supplier").append(
                             `<option selected disabled>Pilih sub supplier</option>`
                                )
                    suppliers.forEach(supplier=>{
                        $(".select-sub-supplier").append(
                             `<option value="${supplier.id}">${supplier.name}</option>`
                                )
                            })
                        }
                     })
                })
    </script>
@endsection

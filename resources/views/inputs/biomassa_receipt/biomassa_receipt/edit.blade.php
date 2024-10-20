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
                        Edit Penerimaan Biomassa
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.biomassa_receipts.index') }}">Penerimaan Biomassa</a> / <span class="text-[#2E46BA] cursor-pointer">Update</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Update Penerimaan Biomassa?')" action="{{ route('inputs.biomassa_receipts.update', ['id' => $biomassa->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="w-full">
                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="bpb_number" class="font-bold text-[#232D42] text-[16px]">No BPB</label>
                                    <div class="relative">
                                        <input type="text" name="bpb_number" value="{{ old('bpb_number', $biomassa->bpb_number ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3" disabled>
                                        @error('bpb_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="main_supplier_uuid" class="font-bold text-[#232D42] text-[16px]">Pemasok</label>
                                    <div class="relative">
                                        <select name="main_supplier_uuid" id="main_supplier_uuid" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option value="">Pilih</option>
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->uuid }}" {{ old('bpb_number', $biomassa->main_supplier_uuid ?? '') == $item->uuid ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('main_supplier_uuid')
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
                                        <input type="text" name="faktur_number" value="{{ old('faktur_number', $biomassa->faktur_number ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('faktur_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12">
                                    <label for="note" class="font-bold text-[#232D42] text-[16px]">Catatan</label>
                                    <div class="relative">
                                        <input type="string" name="note" value="{{ old('note', $biomassa->note ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('note')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="w-full flex gap-4">
                                <div class="w-full lg:w-6/12">
                                    <label for="tug3_number" class="font-bold text-[#232D42] text-[16px]">No TUG3</label>
                                    <div class="relative">
                                        <input disabled type="text" name="tug3_number" value="{{ old('tug3_number', $biomassa->tug3_number ?? '') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3" placeholder="diisi otomatis">
                                        @error('tug3_number')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="contract_id" class="font-bold text-[#232D42] text-[16px]">Nomor Kontrak</label>
                                <div class="relative">
                                    <select name="contract_id" id="contract_id" class="w-full lg:w-1/2 lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option selected disabled>Pilih Nomor Kontrak</option>
                                        @foreach ($contracts as $contract)
                                        <option value="{{ $contract->id }}" {{old('contract_id', $biomassa->contract_id) == $contract->id ? 'selected' :''}}>{{ $contract->contract_number }} - {{$contract->spesification->identification_number ?? '[ Identifikasi Kosong ]'}} - {{$contract->kind_contract}}</option>
                                        @endforeach
                                    </select>
                                    @error('contract_id')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="w-full py-2 text-center text-white bg-[#2E46BA] mb-4">
                                Detail Penerimaan
                            </div>

                            <div class="flex justify-end mb-4">
                                <button id="addDataButton" type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data</button>
                            </div>
                            <div id="dataContainer" class="space-y-4">
                                <div class="dataForm bg-gray-50 p-4 rounded shadow hidden">
                                    <!-- Tombol Hapus -->
                                    <div class="flex justify-end">
                                        <button type="button" class="removeDataButton text-red-500">Hapus</button>
                                    </div>
                                    <!-- Input supplier_uuid dengan Select -->
                                    <div class="mb-4">
                                        <label for="supplier_uuid" class="block text-gray-700">Supplier</label>
                                        <select name="supplier_uuid[]" class="w-full border rounded-md mt-1 mb-3 h-[40px] px-3">
                                            <option value="">Pilih</option>
                                            <!-- Contoh penggunaan Blade di Laravel untuk pengisian opsi -->
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->uuid }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Input volume -->
                                    <div class="mb-4">
                                        <label for="volume" class="block text-gray-700">Volume/DO</label>
                                        <input type="text" name="volume[]" class="w-full border border-gray-300 p-2 rounded mt-1" placeholder="Masukkan Volume">
                                    </div>
                                    <!-- Input number_of_shipper -->
                                    <div class="mb-4">
                                        <label for="number_of_shipper" class="block text-gray-700">Jumlah Truk</label>
                                        <input type="text" name="number_of_shipper[]" class="w-full border border-gray-300 p-2 rounded mt-1" placeholder="Masukkan Jumlah Truk">
                                    </div>
                                    <!-- Input date_shipment -->
                                    <div class="mb-4">
                                        <label for="date_shipment" class="block text-gray-700">Tanggal Pengiriman</label>
                                        <input type="date" name="date_shipment[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                    </div>
                                    <div class="mb-4">
                                        <label for="analysis_number" class="block text-gray-700">No Analisa</label>
                                        <input type="text" name="analysis_number[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                    </div>
                                    <div class="mb-4">
                                        <label for="total_moisure" class="block text-gray-700">Total Moisure</label>
                                        <input type="text" name="total_moisure[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                    </div>
                                    <div class="mb-4">
                                        <label for="moisure_in_analysis" class="block text-gray-700">Moisure in Analysis</label>
                                        <input type="text" name="moisure_in_analysis[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                    </div>
                                    <div class="mb-4">
                                        <label for="calorivic_value" class="block text-gray-700">Calorivic Value</label>
                                        <input type="text" name="calorivic_value[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                    </div>
                                    <div class="mb-4">
                                        <label for="retained_5" class="block text-gray-700">Retained 5</label>
                                        <input type="text" name="retained_5[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                    </div>
                                </div>
                                @foreach ($biomassa->detailReceipt as $detail)
                                    <div class="dataForm bg-gray-50 p-4 rounded shadow">
                                        <!-- Tombol Hapus -->
                                        <div class="flex justify-end">
                                            <button onclick="removeData(this, 'dataForm')" type="button" class="removeDataButton text-red-500">Hapus</button>
                                        </div>
                                        <!-- Input supplier_uuid dengan Select -->
                                        <div class="mb-4">
                                            <label for="supplier_uuid" class="block text-gray-700">Supplier</label>
                                            <select name="supplier_uuid[]" class="w-full border rounded-md mt-1 mb-3 h-[40px] px-3">
                                                <option value="">Pilih</option>
                                                <!-- Contoh penggunaan Blade di Laravel untuk pengisian opsi -->
                                                @foreach ($suppliers as $item)
                                                    <option @if($detail->supplier_uuid == $item->uuid) selected @endif value="{{ $item->uuid }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Input volume -->
                                        <div class="mb-4">
                                            <label for="volume" class="block text-gray-700">Volume/DO</label>
                                            <input type="text" name="volume[]" value="{{ $detail->volume }}" class="w-full border border-gray-300 p-2 rounded mt-1" placeholder="Masukkan Volume">
                                        </div>
                                        <!-- Input number_of_shipper -->
                                        <div class="mb-4">
                                            <label for="number_of_shipper" class="block text-gray-700">Jumlah Truk</label>
                                            <input type="text" name="number_of_shipper[]" value="{{ $detail->number_of_shipper }}" class="w-full border border-gray-300 p-2 rounded mt-1" placeholder="Masukkan Jumlah Truk">
                                        </div>
                                        <!-- Input date_shipment -->
                                        <div class="mb-4">
                                            <label for="date_shipment" class="block text-gray-700">Tanggal Pengiriman</label>
                                            <input type="date" name="date_shipment[]" value="{{ $detail->date_shipment }}" class="w-full border border-gray-300 p-2 rounded mt-1">
                                        </div>
                                        <div class="mb-4">
                                            <label for="analysis_number" class="block text-gray-700">No Analisa</label>
                                            <input type="text" name="analysis_number[]" value="{{ $detail->analysis->analysis_number }}" class="w-full border border-gray-300 p-2 rounded mt-1">
                                        </div>
                                        <div class="mb-4">
                                            <label for="total_moisure" class="block text-gray-700">Total Moisure</label>
                                            <input type="text" name="total_moisure[]" value="{{ $detail->analysis->total_moisure }}" class="w-full border border-gray-300 p-2 rounded mt-1">
                                        </div>
                                        <div class="mb-4">
                                            <label for="moisure_in_analysis" class="block text-gray-700">Moisure in Analysis</label>
                                            <input type="text" name="moisure_in_analysis[]" value="{{ $detail->analysis->moisure_in_analysis }}" class="w-full border border-gray-300 p-2 rounded mt-1">
                                        </div>
                                        <div class="mb-4">
                                            <label for="calorivic_value" class="block text-gray-700">Calorivic Value</label>
                                            <input type="text" name="calorivic_value[]" value="{{ $detail->analysis->calorivic_value }}" class="w-full border border-gray-300 p-2 rounded mt-1">
                                        </div>
                                        <div class="mb-4">
                                            <label for="retained_5" class="block text-gray-700">Retained 5</label>
                                            <input type="text" name="retained_5[]" value="{{ $detail->analysis->retained_5 }}" class="w-full border border-gray-300 p-2 rounded mt-1">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="w-full py-2 text-center text-white bg-[#2E46BA] mb-4">
                                Detail Pembongkaran
                            </div>

                            <div class="flex justify-end mb-4">
                                <button id="addTimeDataButton" type="button" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Data</button>
                            </div>

                            <!-- Kontainer Formulir Data Waktu -->
                            <div id="timeDataContainer" class="space-y-4">
                                <!-- Template Form Data Waktu (Hidden by default) -->
                                <div class="timeDataForm bg-gray-50 p-4 rounded shadow hidden">
                                    <!-- Tombol Hapus -->
                                    <div class="flex justify-end">
                                        <button type="button" class="removeDataButton text-red-500">Hapus</button>
                                    </div>

                                    <!-- Input start time -->
                                    <div class="mb-4">
                                        <label for="start" class="block text-gray-700">Mulai Bongkar</label>
                                        <input type="time" name="start[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                    </div>

                                    <!-- Input end time -->
                                    <div class="mb-4">
                                        <label for="end" class="block text-gray-700">Selesai Bongkar</label>
                                        <input type="time" name="end[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                    </div>

                                    <!-- Input date_unloading -->
                                    <div class="mb-4">
                                        <label for="date_unloading" class="block text-gray-700">Tanggal Bongkar</label>
                                        <input type="date" name="date_unloading[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                    </div>
                                </div>
                                @foreach ($biomassa->unloadingBiomassa as $unloading)
                                    <div class="timeDataForm bg-gray-50 p-4 rounded shadow">
                                        <!-- Tombol Hapus -->
                                        <div class="flex justify-end">
                                            <button type="button" onclick="removeData(this, 'timeDataForm')" class="removeDataButton text-red-500">Hapus</button>
                                        </div>

                                        <!-- Input start time -->
                                        <div class="mb-4">
                                            <label for="start" class="block text-gray-700">Mulai Bongkar</label>
                                            <input type="time" value="{{ $unloading->start }}" name="start[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                        </div>

                                        <!-- Input end time -->
                                        <div class="mb-4">
                                            <label for="end" class="block text-gray-700">Selesai Bongkar</label>
                                            <input type="time" value="{{ $unloading->end }}" name="end[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                        </div>

                                        <!-- Input date_unloading -->
                                        <div class="mb-4">
                                            <label for="date_unloading" class="block text-gray-700">Tanggal Bongkar</label>
                                            <input type="date" value="{{ $unloading->date_unloading }}" name="date_unloading[]" class="w-full border border-gray-300 p-2 rounded mt-1">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <a href="{{ route('inputs.biomassa_receipts.index') }}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah Penerimaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function removeData(button, nearClass) {
        const dataFormElement = button.closest('.' + nearClass);
        if (dataFormElement) {
            dataFormElement.remove();
        }
    }
    document.addEventListener('DOMContentLoaded', () => {
        const addDataButton = document.getElementById('addDataButton');
        const dataContainer = document.getElementById('dataContainer');

        addDataButton.addEventListener('click', () => {
            // Clone template form data
            const dataFormTemplate = document.querySelector('.dataForm.hidden');
            const newDataForm = dataFormTemplate.cloneNode(true);
            newDataForm.classList.remove('hidden');

            // Event Listener untuk Tombol Hapus
            newDataForm.querySelector('.removeDataButton').addEventListener('click', () => {
                newDataForm.remove();
            });

            dataContainer.appendChild(newDataForm);
        });

        const addTimeDataButton = document.getElementById('addTimeDataButton');
        const timeDataContainer = document.getElementById('timeDataContainer');

        // Event Listener untuk Tombol Tambah Data Waktu
        addTimeDataButton.addEventListener('click', () => {
            const timeDataFormTemplate = document.querySelector('.timeDataForm.hidden');
            const newTimeDataForm = timeDataFormTemplate.cloneNode(true);
            newTimeDataForm.classList.remove('hidden');

            // Event Listener untuk Tombol Hapus Data Waktu
            newTimeDataForm.querySelector('.removeDataButton').addEventListener('click', () => {
                newTimeDataForm.remove();
            });

            timeDataContainer.appendChild(newTimeDataForm);
        });
    });
</script>

@endsection

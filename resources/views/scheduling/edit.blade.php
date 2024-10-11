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
                        Detail {{ isset($detail->schedulingPlan->ship->name) ? $detail->schedulingPlan->ship->name : '' }} pada tanggal {{ date('d-m-Y', strtotime($detail->start_date)) }}
                    </div>
                </div>
            </div>
            <div class="bg-white w-full p-4 rounded-lg">
                <div class="flex gap-4 mb-10">
                    <div>
                        Total Bongkar :
                    </div>
                    <div>
                        {{ $detail->capacity }}
                    </div>
                </div>
                <form method="POST" action="{{ route('scheduling.update', ['id' => $detail->id]) }}">
                    @csrf
                    @method('PUT')
                    <button type="button" id="toggleFormBtn" class="mb-4 px-4 py-2 text-center text-white rounded-lg bg-blue-500">
                        Bagi Jadwal
                    </button>

                    <div id="formContainer" style="display: none;"> <!-- Form container yang disembunyikan -->
                        <div class="flex gap-4">
                            <div class="w-full">
                                <label for="dock" class="font-bold text-[#232D42] text-[16px]">Pilih Dermaga</label>
                                <div class="relative">
                                    <select id="dock" name="dock" class="select-2 w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" autofocus>
                                        <option selected disabled>Pilih Dermaga</option>
                                        @foreach ($docks as $dock)
                                        <option value="{{ $dock->id }}">{{$dock->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('dock')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex gap-4 mt-4">
                            <div class="w-full">
                                <label for="start_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Mulai</label>
                                <div>
                                    <input type="datetime-local" id="start_date" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" name="start_date" required min="{{ \Carbon\Carbon::parse($detail->start_date)->format('Y-m-d\TH:i') }}">
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="end_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Selesai</label>
                                <div>
                                    <input type="datetime-local" id="end_date" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" name="end_date" required>
                                </div>
                            </div>
                        </div>
                        <div id="capacity-container" class="w-full"></div>
                        <button type="submit" class="px-4 py-2 text-center text-white rounded-lg bg-blue-500">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('toggleFormBtn').addEventListener('click', function() {
        var formContainer = document.getElementById('formContainer');
        if (formContainer.style.display === 'none' || formContainer.style.display === '') {
            formContainer.style.display = 'block'; // Menampilkan form
        } else {
            formContainer.style.display = 'none'; // Menyembunyikan form
        }
    });

    function createCapacityFields(startDate, endDate) {
        const capacityContainer = document.getElementById('capacity-container');
        capacityContainer.innerHTML = ''; // Clear any previous capacity fields

        const start = new Date(startDate);
        const end = new Date(endDate);

        // Array of month names in English
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Loop through each date from start to end, inclusive
        while (start <= end) {
            const day = start.getDate();
            const month = monthNames[start.getMonth()];
            const year = start.getFullYear();
            const formattedDate = `${day} ${month} ${year}`; // Format: '8 October 2024'

            const capacityField = document.createElement('div');
            capacityField.classList.add('w-full', 'mb-5');

            const label = document.createElement('label');
            label.classList.add('font-bold', 'text-[#232D42]', 'text-[16px]');
            label.textContent = `Kapasitas tanggal ${formattedDate}`;

            const input = document.createElement('input');
            input.type = 'text';
            input.name = `capacity[${formattedDate}]`;
            input.classList.add('w-full', 'lg:w-46', 'border', 'rounded-md', 'h-[40px]', 'px-3', 'mt-3');
            input.required = true; // Add the required attribute

            capacityField.appendChild(label);
            capacityField.appendChild(input);
            capacityContainer.appendChild(capacityField);

            // Move to the next day
            start.setDate(start.getDate() + 1);
        }
    }

    // Event listeners to detect changes in start_date and end_date
    document.getElementById('start_date').addEventListener('change', function () {
        const startDate = this.value;
        const endDate = document.getElementById('end_date').value;

        if (startDate && endDate) {
            createCapacityFields(startDate, endDate);
        }
    });

    document.getElementById('end_date').addEventListener('change', function () {
        const startDate = document.getElementById('start_date').value;
        const endDate = this.value;

        if (startDate && endDate) {
            createCapacityFields(startDate, endDate);
        }
    });
</script>

@endsection

@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen min-h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        Tambahkan Jadwal
                    </div>
                </div>
            </div>
            <div class="bg-white w-full p-4 rounded-lg">
                <form method="POST" action="{{ route('scheduling.store') }}">
                    @csrf
                    <div class="flex gap-4">
                        <div class="w-full">
                            <label for="ship" class="font-bold text-[#232D42] text-[16px]">Pilih Kapal</label>
                            <select id="ship" name="ship" class="select-2 w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                <option selected>Pilih Kapal</option>
                                @foreach ($ships as $ship)
                                    <option value="{{ $ship->id }}">{{ $ship->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full">
                            <label for="dock" class="font-bold text-[#232D42] text-[16px]">Pilih Dermaga</label>
                            <select id="dock" name="dock" class="select-2 w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                <option selected>Pilih Dermaga</option>
                                @foreach ($docks as $dock)
                                    <option data-rate="{{ $dock->load_rate ?? 0 }}" @if($dock->load_rate == null) disabled @endif value="{{ $dock->id }}">{{ $dock->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-4">
                        <div class="w-full">
                            <label for="supplier" class="font-bold text-[#232D42] text-[16px]">Pilih Supplier</label>
                            <select id="supplier" name="supplier" class="select-2 w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                <option selected disabled>Pilih Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full">
                            <label for="total_capacity" class="font-bold text-[#232D42] text-[16px]">Total Kapasitas</label>
                            <input type="text" id="total_capacity" class="w-full lg:w-46 border rounded-md mt-3 h-[40px] px-3" name="total_capacity" required>
                        </div>
                    </div>

                    <div class="w-full flex gap-4 mt-4">
                        <div class="w-6/12">
                            <label for="start_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Mulai</label>
                            <input type="datetime-local" id="start_date" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" name="start_date" required>
                        </div>

                        <div class="w-6/12">
                            <label for="end_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Selesai</label>
                            <input type="datetime-local" id="end_date" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" name="end_date" readonly>
                        </div>
                    </div>

                    <div id="capacity-container" class="w-full"></div>

                    <button type="submit" class="px-4 py-2 text-center text-white rounded-lg bg-blue-500">Simpan</button>
                </form>

                <script>
                    // Function to calculate end date and create capacity fields
                    function calculateEndDateAndCapacity() {
                        const startDateValue = document.getElementById('start_date').value;
                        const totalCapacity = parseFloat(document.getElementById('total_capacity').value);
                        const dockSelect = document.getElementById('dock');
                        const selectedDock = dockSelect.options[dockSelect.selectedIndex];
                        const loadRate = parseFloat(selectedDock.getAttribute('data-rate'));

                        // Check if all required values are available
                        if (startDateValue && totalCapacity && loadRate) {
                            const startDate = new Date(startDateValue);
                            const endDate = calculateEndDate(startDate, totalCapacity, loadRate);

                            // Format the end date to YYYY-MM-DDTHH:MM for the datetime-local input
                            const formattedEndDate = new Date(endDate.getTime() - (endDate.getTimezoneOffset() * 60000)).toISOString().slice(0, 16);
                            document.getElementById('end_date').value = formattedEndDate;

                            // Create capacity and speed fields for each date in the range
                            createCapacityFields(startDate, endDate, totalCapacity, loadRate);
                        }
                    }

                    // Function to calculate the end date based on load rate and total capacity
                    function calculateEndDate(startDate, totalCapacity, loadRate) {
                        const durationInHours = totalCapacity / loadRate;
                        return new Date(startDate.getTime() + durationInHours * 60 * 60 * 1000);
                    }

                    // Function to create capacity input fields for each date in the range
                    function createCapacityFields(startDate, endDate, totalCapacity, loadRate) {
                        const capacityContainer = document.getElementById('capacity-container');
                        capacityContainer.innerHTML = ''; // Clear any previous capacity fields

                        const start = new Date(startDate);
                        const end = new Date(endDate);
                        let remainingCapacity = totalCapacity;

                        // Loop through each date from start to end, inclusive
                        while (start <= end) {
                            const formattedDate = start.toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });

                            const capacityField = document.createElement('div');
                            capacityField.classList.add('w-full', 'mb-5', 'flex', 'items-center');

                            const label = document.createElement('label');
                            label.classList.add('font-bold', 'text-[#232D42]', 'text-[16px]', 'mr-2');
                            label.textContent = `Kapasitas tanggal ${formattedDate}`;

                            const capacityInput = document.createElement('input');
                            capacityInput.type = 'text';
                            capacityInput.name = `capacity[${formattedDate}]`;
                            capacityInput.classList.add('w-full', 'lg:w-46', 'border', 'rounded-md', 'h-[40px]', 'px-3', 'mt-3');
                            capacityInput.required = true; // Add the required attribute

                            // Calculate capacity for this day
                            const hoursInDay = 24;
                            const startHour = start.getHours();
                            let dailyCapacity = 0;

                            if (start.getTime() === startDate.getTime()) {
                                // If it's the starting day, calculate the hours remaining in the day
                                const hoursRemaining = hoursInDay - startHour; // Remaining hours in the first day
                                dailyCapacity = Math.min(hoursRemaining * loadRate, remainingCapacity);
                            } else {
                                // For subsequent days, fill the capacity based on the load rate
                                dailyCapacity = Math.min(hoursInDay * loadRate, remainingCapacity);
                            }

                            capacityInput.value = dailyCapacity; // Set the pre-filled capacity value
                            capacityInput.disabled = true; // Disable the input field

                            // Create the speed field next to the capacity field
                            const speedField = document.createElement('input');
                            speedField.type = 'text';
                            speedField.name = `speed[${formattedDate}]`;
                            speedField.value = '100%'; // Set the default speed value
                            speedField.classList.add('ml-3', 'border', 'rounded-md', 'h-[40px]', 'px-3'); // Add styling
                            speedField.disabled = true; // Disable the speed input field

                            capacityField.appendChild(label);
                            capacityField.appendChild(capacityInput);
                            capacityField.appendChild(speedField);
                            capacityContainer.appendChild(capacityField);

                            remainingCapacity -= dailyCapacity;

                            // Move to the next day at the start of the day
                            start.setDate(start.getDate() + 1);
                            start.setHours(0, 0, 0, 0); // Reset to the start of the day to ensure we only get full days
                        }
                    }

                    // Event listeners to detect changes in start_date, total_capacity, and dock selection
                    document.getElementById('start_date').addEventListener('change', calculateEndDateAndCapacity);
                    document.getElementById('total_capacity').addEventListener('input', calculateEndDateAndCapacity);
                    document.getElementById('dock').addEventListener('change', calculateEndDateAndCapacity);
                </script>



            </div>
        </div>
    </div>
</div>

{{-- <script>
    // Function to create capacity input fields for each date in the range
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
</script> --}}


@endsection

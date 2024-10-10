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

                    <div class="w-full lg:w-6/12 mt-4">
                        <div class="w-full">
                            <label for="calor" class="font-bold text-[#232D42] text-[16px]">Total Kalor</label>
                            <input type="text" id="calor" class="w-full lg:w-46 border rounded-md mt-3 h-[40px] px-3" name="calor" required>
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
                            capacityInput.classList.add('w-full', 'lg:w-46', 'border', 'rounded-md', 'h-[40px]', 'px-3', 'mt-3', 'capacity');
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
                            speedField.value = '100'; // Set the default speed value
                            speedField.classList.add('ml-3', 'border', 'rounded-md', 'h-[40px]', 'px-3', 'speed');

                            speedField.addEventListener('change', getCapacityValues);

                            capacityField.appendChild(label);
                            capacityField.appendChild(capacityInput);
                            capacityField.appendChild(speedField);
                            capacityContainer.appendChild(capacityField);

                            remainingCapacity -= dailyCapacity;

                            // Move to the next day at the start of the day
                            start.setDate(start.getDate() + 1);
                            start.setHours(0, 0, 0, 0); // Reset to the start of the day to ensure we only get full days
                        }

                        getCapacityValues();
                    }

                    function getCapacityValues() {
                        // Get all elements with the class 'capacity'
                        const capacityElements = document.querySelectorAll('.capacity');
                        const speedElements = document.querySelectorAll('.speed');

                        // Create an array to store the values
                        const capacityValues = [];
                        const speedValues = [];

                        // Populate speedValues array with the values from speed input fields
                        speedElements.forEach(element => {
                            speedValues.push(parseFloat(element.value));
                        });

                        const dockSelect = document.getElementById('dock');
                        const selectedDock = dockSelect.options[dockSelect.selectedIndex];
                        const loadRate = parseFloat(selectedDock.getAttribute('data-rate')); // Load rate in tons per hour
                        const totalCapacity = parseFloat(document.getElementById('total_capacity').value);
                        const startDateValue = document.getElementById('start_date').value;

                        // Parse the start date and extract the starting hour from datetime-local
                        const startDate = new Date(startDateValue);
                        const startHour = startDate.getHours(); // Get the hour from the start date

                        // Buat objek Date untuk target waktu 23:59 pada hari yang sama
                        const endOfDay = new Date(startDate);
                        endOfDay.setHours(23, 59, 0, 0); // Set waktu ke 23:59:00 pada hari yang sama

                        // Hitung selisih waktu dalam milidetik
                        const timeDifference = endOfDay - startDate;

                        const hourDecimal = (timeDifference / (1000 * 60 * 60)).toFixed(2);

                        const result = []; // Array untuk menyimpan distribusi kapasitas per jam
                        const dailyTotals = []; // Array untuk menyimpan total kapasitas dan speed yang digunakan per hari
                        let remainingCapacity = totalCapacity;
                        let totalHoursUsed = 0; // Variabel untuk melacak total jam yang digunakan

                        // Mengambil bagian bulat dari hourDecimal
                        const fullHours = Math.floor(hourDecimal);
                        // Mengambil sisa jam dalam bentuk desimal
                        const fractionalHour = hourDecimal - fullHours;

                        // Menghitung kapasitas per hari
                        let currentDailyTotal = 0; // Variabel untuk menyimpan total kapasitas harian
                        let currentSpeed = speedValues[0]; // Mengambil nilai speed untuk hari pertama

                        const start = new Date(startDate); // Mulai dari tanggal yang diberikan

                        // Format tanggal dengan format yang diinginkan
                        const formatDate = (date) => {
                            return date.toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });
                        };

                        // Melakukan perulangan untuk setiap jam penuh
                        for (let i = 0; i < fullHours; i++) {
                            const speedFactor = speedValues[0]; // Menggunakan speed untuk hari pertama
                            const loadForThisHour = loadRate * (speedFactor / 100); // Hitung kapasitas untuk jam ini

                            const loadUsed = Math.min(loadForThisHour, remainingCapacity);
                            result.push([parseFloat(loadUsed.toFixed(2)), speedFactor]); // Menyimpan kapasitas dan speed
                            remainingCapacity -= loadUsed; // Kurangi remainingCapacity
                            totalHoursUsed++; // Tambahkan total jam yang digunakan

                            // Tambahkan load yang digunakan ke total harian
                            currentDailyTotal += loadUsed;

                            // Jika kapasitas tersisa sudah habis, berhenti dari perulangan
                            if (remainingCapacity <= 0) {
                                break;
                            }
                        }

                        // Jika ada sisa waktu dalam bentuk desimal, proses kapasitas tersebut
                        if (fractionalHour > 0 && remainingCapacity > 0) {
                            const speedFactor = speedValues[0]; // Menggunakan speed untuk hari pertama
                            const loadForFractionalHour = loadRate * fractionalHour * (speedFactor / 100); // Hitung kapasitas untuk sisa waktu
                            const loadUsed = Math.min(loadForFractionalHour, remainingCapacity);
                            result.push([parseFloat(loadUsed.toFixed(2)), speedFactor]); // Menyimpan kapasitas dan speed
                            remainingCapacity -= loadUsed; // Kurangi remainingCapacity
                            totalHoursUsed += fractionalHour; // Tambahkan sisa jam yang digunakan

                            // Tambahkan load yang digunakan ke total harian
                            currentDailyTotal += loadUsed;
                        }

                        // Simpan total kapasitas dan speed harian ke dalam dailyTotals
                        dailyTotals.push([currentDailyTotal, currentSpeed]);

                        // Jika masih ada kapasitas yang tersisa setelah jam penuh berakhir, lanjutkan ke hari berikutnya
                        let dayIndex = 1; // Mulai dari hari kedua
                        while (remainingCapacity > 0) {
                            let nextDayTotal = 0; // Variabel untuk menyimpan total kapasitas untuk hari berikutnya
                            let nextDaySpeed = speedValues[dayIndex] !== undefined ? speedValues[dayIndex] : 100; // Mengambil nilai speed untuk hari berikutnya, jika tidak ada gunakan 100

                            // Perbarui tanggal untuk hari berikutnya
                            start.setDate(start.getDate() + 1);
                            const formattedDate = formatDate(start); // Format tanggal sesuai dengan hari saat ini

                            for (let i = 0; i < 24; i++) { // Lakukan perulangan 24 jam setiap hari
                                const loadForNextHour = loadRate * (nextDaySpeed / 100); // Hitung kapasitas untuk jam berikutnya
                                const loadUsed = Math.min(loadForNextHour, remainingCapacity);
                                result.push([parseFloat(loadUsed.toFixed(2)), nextDaySpeed]); // Menyimpan kapasitas dan speed
                                remainingCapacity -= loadUsed; // Kurangi remainingCapacity

                                totalHoursUsed++; // Tambahkan total jam yang digunakan
                                nextDayTotal += loadUsed; // Tambahkan ke total kapasitas hari berikutnya

                                // Jika kapasitas tersisa sudah habis, berhenti dari perulangan
                                if (remainingCapacity <= 0) {
                                    break;
                                }
                            }

                            // Simpan total kapasitas dan speed harian ke dalam dailyTotals untuk hari berikutnya
                            dailyTotals.push([nextDayTotal, nextDaySpeed]);
                            dayIndex++; // Pindah ke hari berikutnya
                        }

                        // Hitung jam dan menit dari totalHoursUsed
                        const getStartDate = new Date(startDate);
                        const totalHours = Math.floor(totalHoursUsed);
                        const totalMinutes = Math.round((totalHoursUsed - totalHours) * 60);

                        const formattedDate = getStartDate.toLocaleDateString('en-GB', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        // Membuat nama untuk speedInput dan capacityInput menggunakan formattedDate
                        const speedInput = document.createElement('input');
                        speedInput.name = `speed[${formatDate}]`;

                        const capacityInput = document.createElement('input');
                        capacityInput.name = `capacity[${formatDate}]`;

                        // Tambahkan jam dan menit ke getStartDate
                        getStartDate.setHours(getStartDate.getHours() + totalHours);
                        getStartDate.setMinutes(getStartDate.getMinutes() + totalMinutes);

                        // Format tanggal dan waktu ke format YYYY-MM-DDTHH:MM
                        const year = getStartDate.getFullYear();
                        const month = String(getStartDate.getMonth() + 1).padStart(2, '0'); // Menambahkan 1 karena bulan dimulai dari 0
                        const day = String(getStartDate.getDate()).padStart(2, '0');
                        const hours = String(getStartDate.getHours()).padStart(2, '0');
                        const minutes = String(getStartDate.getMinutes()).padStart(2, '0');

                        // Menggabungkan menjadi format yang diinginkan
                        const formattedEndDate = `${year}-${month}-${day}T${hours}:${minutes}`;

                        // Ubah nilai input datetime-local dengan id 'end_date'
                        document.getElementById('end_date').value = formattedEndDate;

                        console.log('Distribusi Load per Jam:', result);
                        console.log('Total Jam yang Dibutuhkan:', totalHoursUsed);
                        console.log('Total Kapasitas dan Speed per Hari:', dailyTotals);



                        // Mengambil elemen kapasitas-container
                        const capacityContainer = document.getElementById('capacity-container');

                        // Hapus isi kapasitas-container sebelumnya
                        capacityContainer.innerHTML = '';

                        const getStartDate1 = new Date(startDate);

                        // Iterasi melalui dailyTotals untuk menampilkan kapasitas dan speed
                        dailyTotals.forEach((dailyTotal, index) => {
                            const [totalCapacity, speed] = dailyTotal; // Destructure array untuk mendapatkan kapasitas dan speed

                            // Buat div untuk setiap entry
                            const dailyField = document.createElement('div');
                            dailyField.classList.add('w-full', 'mb-5', 'flex', 'items-center');

                            const formattedDate1 = getStartDate1.toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });

                            // Buat label untuk kapasitas
                            const capacityLabel = document.createElement('label');
                            capacityLabel.classList.add('font-bold', 'text-[#232D42]', 'text-[16px]', 'mr-2');
                            capacityLabel.textContent = `Kapasitas Hari ${formattedDate1}:`; // Misalnya Hari 1, Hari 2, dll.

                            // Buat input untuk kapasitas
                            const capacityInput = document.createElement('input');
                            capacityInput.type = 'text';
                            capacityInput.name = `capacity[${formattedDate1}]`;
                            capacityInput.value = totalCapacity; // Set nilai kapasitas
                            capacityInput.classList.add('w-full', 'lg:w-46', 'border', 'rounded-md', 'h-[40px]', 'px-3', 'mt-3', 'capacity');
                            capacityInput.readOnly = true; // Nonaktifkan input

                            // Buat label untuk speed
                            const speedLabel = document.createElement('label');
                            speedLabel.classList.add('font-bold', 'text-[#232D42]', 'text-[16px]', 'mr-2', 'ml-3');
                            speedLabel.textContent = `Speed Hari ${formattedDate1}:`;

                            // Buat input untuk speed
                            const speedInput = document.createElement('input');
                            speedInput.type = 'text';
                            speedInput.name = `speed[${formattedDate1}]`;
                            speedInput.value = speed; // Set nilai speed
                            speedInput.classList.add('ml-3', 'border', 'rounded-md', 'h-[40px]', 'px-3', 'speed');
                            speedInput.addEventListener('change', getCapacityValues);

                            // Tambahkan elemen ke dalam dailyField
                            dailyField.appendChild(capacityLabel);
                            dailyField.appendChild(capacityInput);
                            dailyField.appendChild(speedLabel);
                            dailyField.appendChild(speedInput);

                            // Tambahkan dailyField ke capacityContainer
                            capacityContainer.appendChild(dailyField);

                            getStartDate1.setDate(getStartDate1.getDate() + 1);
                            getStartDate1.setHours(0, 0, 0, 0);
                        });



                    }

                    // Event listeners to detect changes in start_date, total_capacity, and dock selection
                    document.getElementById('start_date').addEventListener('change', calculateEndDateAndCapacity);
                    document.getElementById('total_capacity').addEventListener('input', calculateEndDateAndCapacity);
                    document.getElementById('dock').addEventListener('change', calculateEndDateAndCapacity);
                    const speedElements = document.querySelectorAll('.speed');

                    // Add an event listener to each 'speed' element
                    speedElements.forEach(element => {
                        element.addEventListener('change', getCapacityValues);
                    });
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

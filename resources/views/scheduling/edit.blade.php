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
                <form method="POST" action="{{ route('scheduling.update', ['id' => $detail->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="flex gap-4">
                        <div class="w-full">
                            <label for="dock" class="font-bold text-[#232D42] text-[16px]">Dermaga Awal</label>
                            <select id="dock" disabled name="dock" class="select-2 w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                <option selected>Pilih Dermaga</option>
                                @foreach ($docks as $dock)
                                    <option data-rate="{{ $dock->load_rate ?? 0 }}" @if($dock->load_rate == null) disabled @endif {{ $dock->id == $detail->dock_id ? 'selected' : '' }} value="{{ $dock->id }}">{{ $dock->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-4 mt-4">
                        <div class="w-full">
                            <label for="total_capacity" class="font-bold text-[#232D42] text-[16px]">Total Kapasitas Sisa</label>
                            <input type="text" id="total_capacity" value="{{ $total }}" class="w-full lg:w-46 border rounded-md mt-3 h-[40px] px-3" name="total_capacity" required readonly>
                        </div>
                    </div>

                    <div class="w-full flex gap-4 mt-4">
                        <div class="w-6/12">
                            <label for="start_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Mulai</label>
                            <input type="datetime-local" id="start_date" value="{{ $start_date }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" name="start_date" required readonly>
                        </div>

                        <div class="w-6/12">
                            <label for="end_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Selesai</label>
                            <input type="datetime-local" value="{{ $end_date }}" id="end_date" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" name="end_date" readonly>
                        </div>
                    </div>

                    <div id="capacity-container" class="w-full">
                        @foreach ($scheduling as $schedule)
                            <div class="w-full mb-5 flex items-end">
                                <div class="flex gap-2">
                                    <label class="font-bold text-[#232D42] text-[16px] mr-2">
                                        Kapasitas Hari {{ date('d F Y', strtotime($schedule->start_date)) }}:
                                    </label>
                                    <input type="text" name="capacity[]" class="w-full lg:w-46 border rounded-md h-[40px] px-3 mt-3 capacity" value="{{ $schedule->capacity }}" onchange="updateData()">
                                </div>
                                <div class="flex gap-2 items-end">
                                    <div>
                                        <label class="font-bold text-[#232D42] text-[16px] mr-2 ml-3">
                                            Speed Hari {{ date('d F Y', strtotime($schedule->start_date)) }}:
                                        </label><input type="text" name="speed[]" class="ml-3 border rounded-md h-[40px] px-3 persentase" value="{{ $schedule->speed }}" onchange="updateData()">
                                    </div>
                                    <div>
                                        <select name="type[]" id="type" class="border px-4 py-2 type">
                                            <option @if($schedule->type == 'aktual') selected @endif value="aktual">Aktual</option>
                                            <option @if($schedule->type == 'persentase') selected @endif value="persentase">Persentase</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="new-schedule">
                        <div class="font-bold text-[20px] my-4">
                            <h1>Jadwal Baru</h1>
                        </div>
                        <div class="w-full flex items-end gap-4 mt-4">
                            <div class="w-6/12">
                                <div class="w-full">
                                    <label for="dock_new" class="font-bold text-[#232D42] text-[16px]">Pilih Dermaga Baru</label>
                                    <div>
                                    Jika dermaga tidak dapat di pilih, maka anda harus mengisi load rate dermaga dulu di <a class="text-blue-500 underline" href="{{ route('master-data.docks.index') }}" target="_blank">sini</a>
                                </div>
                                    <select id="dock_new" name="dock_new" class="select-2 w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option selected>Pilih Dermaga</option>
                                        @foreach ($docks as $dock)
                                            <option data-rate="{{ $dock->load_rate ?? 0 }}" @if($dock->load_rate == null) disabled @endif value="{{ $dock->id }}">{{ $dock->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="w-6/12">
                                <div class="w-full">
                                    <label for="total_capacity_new" class="font-bold text-[#232D42] text-[16px]">Total kapasitas baru</label>
                                    <input type="text" disabled id="total_capacity_new" name="total_capacity_new" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex gap-4 mt-4">
                            <div class="w-6/12">
                                <label for="start_date_new" class="font-bold text-[#232D42] text-[16px]">Tanggal Mulai</label>
                                <input type="datetime-local" id="start_date_new" min="{{ $start_date }}" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" name="start_date_new">
                            </div>
                            <div class="w-6/12">
                                <label for="end_date_new" class="font-bold text-[#232D42] text-[16px]">Tanggal Selesai</label>
                                <input type="datetime-local" id="end_date_new"  class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3" name="end_date_new" readonly>
                            </div>
                        </div>
                        <div id="capacity-container-new" class="w-full">
                        </div>
                    </div>

                    <button type="submit" class="px-4 py-2 text-center text-white rounded-lg bg-blue-500">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- <script>
    document.getElementById('start_date_new').addEventListener('change', function() {
        const endDateInput = document.getElementById('end_date');
        endDateInput.value = this.value;
    });

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
        const endDateValue = document.getElementById('end_date').value;

        const startDate = new Date(startDateValue);
        const endOfDay = new Date(endDateValue);
        const dayStartDate = startDate;
        const dayEndOfDay = endOfDay;


        // Hitung selisih waktu dalam milidetik
        var timeDifference = endOfDay - startDate;

        // total jam pada dermaga ini
        const hourDecimal = (timeDifference / (1000 * 60 * 60)).toFixed(2);

        const endDate = new Date(startDate);
        endDate.setHours(23, 59, 59, 999); // Set waktu ke 23:59:59.999

        // Hitung perbedaan waktu dalam milidetik
        timeDifference = endDate - startDate;

        // Konversi milidetik ke jam
        // total jam dari start date sampai jam 23:59
        const hourDifference = timeDifference / (1000 * 60 * 60);

        dayStartDate.setHours(0, 0, 0, 0);
        dayEndOfDay.setHours(0, 0, 0, 0);

        // Hitung perbedaan waktu dalam milidetik
        const dayTimeDifference = dayEndOfDay - dayStartDate;

        // Konversi milidetik ke hari
        const dayDifference = Math.ceil(dayTimeDifference / (1000 * 60 * 60 * 24));

        const result = [];
        const start = new Date(startDate);
        let remainingCapacity = totalCapacity;

        const formatDate = (date) => {
            return date.toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        };

        totalRemainingHour = hourDecimal;
        for (let index = 0; index < dayDifference + 1; index++) {
            if(remainingCapacity <= 0){
                break;
            }
            let HourInDay; // Mendeklarasikan HourInDay di sini

            if (totalRemainingHour > 24) {
                if (index === 0) {
                    HourInDay = totalRemainingHour - hourDifference; // Mengurangi hourDifference dari totalRemainingHour
                } else {
                    // Hitung sisa jam untuk hari berikutnya
                    if (totalRemainingHour > 24) {
                        HourInDay = Math.min(24, totalRemainingHour); // Jam maksimum per hari adalah 24
                        totalRemainingHour -= HourInDay; // Kurangi totalRemainingHour dengan jam yang dihitung
                    } else {
                        HourInDay = totalRemainingHour; // Jika sisa jam kurang dari 24
                    }
                }
            } else {
                HourInDay = totalRemainingHour; // Jika totalRemainingHour tidak lebih dari 24
            }

            const speedFactor = (index < speedValues.length && speedValues[index] !== null) ? speedValues[index] : 100;
            const loadForThisHour = HourInDay * (loadRate * (speedFactor / 100)); // Hitung kapasitas untuk jam ini
            const loadUsed = Math.min(loadForThisHour, remainingCapacity);
            result.push([parseFloat(loadUsed.toFixed(2)), speedFactor]); // Menyimpan kapasitas dan speed
            remainingCapacity -= loadUsed;

            // Jika jam sudah habis, tidak perlu menambah tanggal
            if (totalRemainingHour > 0) {
                start.setDate(start.getDate() + 1); // Hanya tambahkan satu hari jika masih ada jam tersisa
            }
            const formattedDate = formatDate(start);
        }

        const getStartDate1 = new Date(startDate);
        const capacityContainer = document.getElementById('capacity-container');

        // Hapus isi kapasitas-container sebelumnya
        capacityContainer.innerHTML = '';
        result.forEach(([totalCapacity, speedValue]) => {
            const formattedDate1 = getStartDate1.toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            // Buat div untuk setiap entry
            const dailyField = document.createElement('div');
            dailyField.classList.add('w-full', 'mb-5', 'flex', 'items-center');

            // Buat label untuk kapasitas
            const capacityLabel = document.createElement('label');
            capacityLabel.classList.add('font-bold', 'text-[#232D42]', 'text-[16px]', 'mr-2');
            capacityLabel.textContent = `Kapasitas Hari ${formattedDate1}:`; // Misalnya Hari 1, Hari 2, dll.

            // Buat input untuk kapasitas
            const capacityInput = document.createElement('input');
            capacityInput.type = 'text';
            capacityInput.name = `capacity[${formattedDate1}]`; // Ganti dengan capacity
            capacityInput.value = totalCapacity; // Set nilai kapasitas menggunakan loadUsed dari result
            capacityInput.classList.add('w-full', 'lg:w-46', 'border', 'rounded-md', 'h-[40px]', 'px-3', 'mt-3', 'capacity');
            capacityInput.readOnly = true; // Nonaktifkan input

            // Buat label untuk speed
            const speedLabel = document.createElement('label');
            speedLabel.classList.add('font-bold', 'text-[#232D42]', 'text-[16px]', 'mr-2', 'ml-3');
            speedLabel.textContent = `Speed Hari ${formattedDate1}:`;

            // Buat input untuk speed
            const speedInput = document.createElement('input');
            speedInput.type = 'text';
            speedInput.name = `speed[${formattedDate1}]`; // Ganti dengan new_speed
            speedInput.value = speedValue; // Set nilai speed dari dailyTotals
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
            getStartDate1.setHours(0, 0, 0, 0); // Reset jam untuk hari berikutnya
        });

        getNewCapacityValues(remainingCapacity);
    }

    function getNewCapacityValues(totalCapacity) {
        totalCapacity = parseFloat(totalCapacity);
        // Get all elements with the class 'capacity'
        const capacityElements = document.querySelectorAll('.capacity_new');
        const speedElements = document.querySelectorAll('.speed_new');

        // Create an array to store the values
        const capacityValues = [];
        const speedValues = [];

        // Populate speedValues array with the values from speed input fields
        speedElements.forEach(element => {
            speedValues.push(parseFloat(element.value));
        });

        const dockSelect = document.getElementById('new_dock');
        const selectedDock = dockSelect.options[dockSelect.selectedIndex];
        const loadRate = parseFloat(selectedDock.getAttribute('data-rate'));
        const startDateValue = document.getElementById('start_date_new').value;

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
        let currentSpeed = (typeof speedValues[0] === 'number' && !isNaN(speedValues[0]) && speedValues[0] !== undefined && speedValues[0] >= 1 && speedValues[0] <= 100) ? speedValues[0] : 100; // Mengambil nilai speed untuk hari pertama

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
            const speedFactor = (typeof speedValues[0] === 'number' && !isNaN(speedValues[0]) && speedValues[0] !== undefined && speedValues[0] >= 1 && speedValues[0] <= 100) ? speedValues[0] : 100; // Menggunakan speed untuk hari pertama
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
            const speedFactor = (typeof speedValues[0] === 'number' && !isNaN(speedValues[0]) && speedValues[0] !== undefined && speedValues[0] >= 1 && speedValues[0] <= 100) ? speedValues[0] : 100; // Menggunakan speed untuk hari pertama
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
            let nextDaySpeed = (speedValues[dayIndex] !== undefined && !isNaN(speedValues[dayIndex]) && speedValues[dayIndex] >= 1 && speedValues[dayIndex] <= 100)
                                ? speedValues[dayIndex]
                                : 100; // Mengambil nilai speed untuk hari berikutnya, jika tidak ada gunakan 100

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
        speedInput.name = `speed_new[${formatDate}]`;

        const capacityInput = document.createElement('input');
        capacityInput.name = `capacity_new[${formatDate}]`;

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
        document.getElementById('end_date_new').value = formattedEndDate;

        // Mengambil elemen kapasitas-container
        const capacityContainer = document.getElementById('capacity-container_new');

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
            capacityLabel.textContent = `Kapasitas Hari ${formattedDate1}:`;

            // Buat input untuk kapasitas
            const capacityInput = document.createElement('input');
            capacityInput.type = 'text';
            capacityInput.name = `capacity_new[${formattedDate1}]`;
            capacityInput.value = totalCapacity; // Set nilai kapasitas
            capacityInput.classList.add('w-full', 'lg:w-46', 'border', 'rounded-md', 'h-[40px]', 'px-3', 'mt-3', 'capacity_new');
            capacityInput.readOnly = true; // Nonaktifkan input

            // Buat label untuk speed
            const speedLabel = document.createElement('label');
            speedLabel.classList.add('font-bold', 'text-[#232D42]', 'text-[16px]', 'mr-2', 'ml-3');
            speedLabel.textContent = `Speed Hari ${formattedDate1}:`;

            // Buat input untuk speed
            const speedInput = document.createElement('input');
            speedInput.type = 'text';
            speedInput.name = `speed_new[${formattedDate1}]`;
            speedInput.value = speed; // Set nilai speed
            speedInput.classList.add('ml-3', 'border', 'rounded-md', 'h-[40px]', 'px-3', 'speed_new');
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
    document.getElementById('start_date_new').addEventListener('change', getCapacityValues);
    document.getElementById('new_dock').addEventListener('change', getCapacityValues);
    const speedElements = document.querySelectorAll('.speed');

    // Add an event listener to each 'speed' element
    speedElements.forEach(element => {
        element.addEventListener('change', getCapacityValues);
    });
</script> --}}

<script>
    // Event listeners to detect changes in start_date, total_capacity, and dock selection
    document.getElementById('start_date').addEventListener('change', calculateCapacity);
    document.getElementById('total_capacity').addEventListener('input', calculateCapacity);
    document.getElementById('dock').addEventListener('change', calculateCapacity);

    document.getElementById('start_date_new').addEventListener('change', calculateCapacityNew);
    document.getElementById('dock_new').addEventListener('change', calculateCapacityNew);

    function calculateCapacity(){
        const startDateValue = document.getElementById('start_date').value;
        const totalCapacity = parseFloat(document.getElementById('total_capacity').value);
        const dockSelect = document.getElementById('dock');
        const selectedDock = dockSelect.options[dockSelect.selectedIndex];
        const loadRate = parseFloat(selectedDock.getAttribute('data-rate'));

        const startDate = new Date(startDateValue);

        // Buat objek Date untuk jam 23:59 di hari yang sama
        const endOfDay = new Date(startDate);
        endOfDay.setHours(23, 59, 0, 0); // Jam 23:59:00

        // Hitung selisih waktu dalam milidetik
        const timeDifferenceMs = endOfDay - startDate;

        // Konversi selisih waktu menjadi jam desimal
        const hoursRemainingDecimal = timeDifferenceMs / (1000 * 60 * 60);

        const maximumLoad = hoursRemainingDecimal * loadRate; // Maksimal yang bisa di-load pada hari pertama

        // Hitung total load pada hari pertama
        const totalLoadFirstDay = Math.min(maximumLoad, totalCapacity);
        const firstDayTotalHours = hoursRemainingDecimal.toFixed(2); // Total jam yang digunakan di hari pertama

        // Array untuk menampung hasil perhitungan per hari
        let loadData = [
            {
                total: totalLoadFirstDay.toFixed(2), // Total yang berhasil di-load pada hari pertama
                persentase: 100, // Persentase untuk hari pertama
                type: "persentase", // Tipe untuk hari pertama
                total_jam: firstDayTotalHours // Jumlah jam yang dihabiskan di hari pertama
            }
        ];

        // Hitung sisa kapasitas setelah hari pertama
        let remainingCapacity = totalCapacity - totalLoadFirstDay;

        document.getElementById('total_capacity_new').value = remainingCapacity;
        
        showCapacity(loadData)
        calculateCapacityNew()
    }

    function calculateCapacityNew(){
        const startDateValue = document.getElementById('start_date_new').value;
        const totalCapacity = parseFloat(document.getElementById('total_capacity_new').value);
        const dockSelect = document.getElementById('dock_new');
        const selectedDock = dockSelect.options[dockSelect.selectedIndex];
        const loadRate = parseFloat(selectedDock.getAttribute('data-rate'));

        const startDate = new Date(startDateValue);

        // Buat objek Date untuk jam 23:59 di hari yang sama
        const endOfDay = new Date(startDate);
        endOfDay.setHours(23, 59, 0, 0); // Jam 23:59:00

        // Hitung selisih waktu dalam milidetik
        const timeDifferenceMs = endOfDay - startDate;

        // Konversi selisih waktu menjadi jam desimal
        const hoursRemainingDecimal = timeDifferenceMs / (1000 * 60 * 60);

        const maximumLoad = hoursRemainingDecimal * loadRate; // Maksimal yang bisa di-load pada hari pertama

        // Hitung total load pada hari pertama
        const totalLoadFirstDay = Math.min(maximumLoad, totalCapacity);
        const firstDayTotalHours = hoursRemainingDecimal.toFixed(2); // Total jam yang digunakan di hari pertama

        // Array untuk menampung hasil perhitungan per hari
        let loadData = [
            {
                total: totalLoadFirstDay.toFixed(2), // Total yang berhasil di-load pada hari pertama
                persentase: 100, // Persentase untuk hari pertama
                type: "persentase", // Tipe untuk hari pertama
                total_jam: firstDayTotalHours // Jumlah jam yang dihabiskan di hari pertama
            }
        ];

        // Hitung sisa kapasitas setelah hari pertama
        let remainingCapacity = totalCapacity - totalLoadFirstDay;

        if (remainingCapacity > 0) {
            let days = 1; // Hari pertama sudah dihitung, mulai dari hari berikutnya
            while (remainingCapacity > 0) {
                // Hitung waktu yang dibutuhkan untuk memuat sisa kapasitas per hari
                const loadForTheDay = Math.min(remainingCapacity, loadRate * 24); // 24 jam dalam sehari
                const totalHoursForDay = loadForTheDay / loadRate; // Jam yang dibutuhkan pada hari tersebut

                // Tambahkan ke array loadData
                loadData.push({
                    total: loadForTheDay.toFixed(2),
                    persentase: 100, // Persentase diatur tetap 100 untuk setiap hari
                    type: "persentase",
                    total_jam: totalHoursForDay.toFixed(2)
                });

                // Kurangi sisa kapasitas
                remainingCapacity -= loadForTheDay;

                days++; // Hitung hari selanjutnya
            }
        }
        
        showCapacityNew(loadData)
    }

    function updateData() {
        const startDateValue = document.getElementById('start_date').value;
        const totalCapacity = parseFloat(document.getElementById('total_capacity').value);
        const dockSelect = document.getElementById('dock');
        const selectedDock = dockSelect.options[dockSelect.selectedIndex];
        let loadRate = parseFloat(selectedDock.getAttribute('data-rate'));
        const capacityContainer = document.getElementById('capacity-container');

        const startDate = new Date(startDateValue);

        // Buat objek Date untuk jam 23:59 di hari yang sama
        const endOfDay = new Date(startDate);
        endOfDay.setHours(23, 59, 0, 0); // Jam 23:59:00

        // Hitung selisih waktu dalam milidetik
        const timeDifferenceMs = endOfDay - startDate;

        // Konversi selisih waktu menjadi jam desimal
        const hoursRemainingDecimal = timeDifferenceMs / (1000 * 60 * 60);
        let maximumLoad = hoursRemainingDecimal * loadRate;

        let inputData = [];
        let loadData = [];
        const capacityInputs = document.querySelectorAll('.capacity');
        const persentaseInputs = document.querySelectorAll('.persentase');
        const typeInputs = document.querySelectorAll('.type');

        capacityInputs.forEach((input, index) => {
            let totalCapacity = parseFloat(input.value); // Ambil nilai dari input capacity
            let persentase = parseFloat(persentaseInputs[index].value); // Ambil nilai dari input persentase
            let type = typeInputs[index].value;
            inputData.push({
                capacity: totalCapacity,
                persentase: persentase,
                type: type
            });
        });

        // Mengambil hanya inputData[0] untuk perhitungan hari pertama
        const firstInputData = inputData[0];
        let remainingCapacity = totalCapacity;

        if (firstInputData) {
            if (firstInputData.type === 'persentase') {
                const adjustedLoadRate = loadRate * (firstInputData.persentase / 100);
                maximumLoad = hoursRemainingDecimal * adjustedLoadRate;

                const totalLoadFirstDay = Math.min(maximumLoad, remainingCapacity);
                const firstDayTotalHours = (totalLoadFirstDay / adjustedLoadRate).toFixed(2);

                loadData.push({
                    total: totalLoadFirstDay.toFixed(2),
                    persentase: firstInputData.persentase,
                    type: "persentase",
                    total_jam: firstDayTotalHours
                });

                remainingCapacity -= totalLoadFirstDay;
            } else if (firstInputData.type === 'aktual') {
                const totalLoadFirstDay = firstInputData.capacity;
                const calculatedPercentage = (totalLoadFirstDay / maximumLoad) * 100;
                const firstDayTotalHours = hoursRemainingDecimal.toFixed(2);

                loadData.push({
                    total: totalLoadFirstDay.toFixed(2),
                    persentase: calculatedPercentage.toFixed(2),
                    type: "aktual",
                    total_jam: firstDayTotalHours
                });

                remainingCapacity -= totalLoadFirstDay;
            }
        }

        document.getElementById('total_capacity_new').value = remainingCapacity;

        showCapacity(loadData)
        calculateCapacityNew()
    }

    function updateDataNew() {
        const startDateValue = document.getElementById('start_date_new').value;
        const totalCapacity = parseFloat(document.getElementById('total_capacity_new').value);
        const dockSelect = document.getElementById('dock_new');
        const selectedDock = dockSelect.options[dockSelect.selectedIndex];
        let loadRate = parseFloat(selectedDock.getAttribute('data-rate'));
        const capacityContainer = document.getElementById('capacity-container-new');

        const startDate = new Date(startDateValue);

        // Buat objek Date untuk jam 23:59 di hari yang sama
        const endOfDay = new Date(startDate);
        endOfDay.setHours(23, 59, 0, 0); // Jam 23:59:00

        // Hitung selisih waktu dalam milidetik
        const timeDifferenceMs = endOfDay - startDate;

        // Konversi selisih waktu menjadi jam desimal
        const hoursRemainingDecimal = timeDifferenceMs / (1000 * 60 * 60);
        let maximumLoad = hoursRemainingDecimal * loadRate;

        let inputData = [];
        let loadData = [];
        const capacityInputs = document.querySelectorAll('.capacity_new');
        const persentaseInputs = document.querySelectorAll('.persentase_mew');
        const typeInputs = document.querySelectorAll('.type_new');

        capacityInputs.forEach((input, index) => {
            let totalCapacity = parseFloat(input.value); // Ambil nilai dari input capacity
            let persentase = parseFloat(persentaseInputs[index].value); // Ambil nilai dari input persentase
            let type = typeInputs[index].value;
            inputData.push({
                capacity: totalCapacity,
                persentase: persentase,
                type: type
            });
        });

        // Mengambil hanya inputData[0] untuk perhitungan hari pertama
        const firstInputData = inputData[0];
        let remainingCapacity = totalCapacity;

        if (firstInputData) {
            if (firstInputData.type === 'persentase') {
                const adjustedLoadRate = loadRate * (firstInputData.persentase / 100);
                maximumLoad = hoursRemainingDecimal * adjustedLoadRate;

                const totalLoadFirstDay = Math.min(maximumLoad, remainingCapacity);
                const firstDayTotalHours = (totalLoadFirstDay / adjustedLoadRate).toFixed(2);

                loadData.push({
                    total: totalLoadFirstDay.toFixed(2),
                    persentase: firstInputData.persentase,
                    type: "persentase",
                    total_jam: firstDayTotalHours
                });

                remainingCapacity -= totalLoadFirstDay;
            } else if (firstInputData.type === 'aktual') {
                const totalLoadFirstDay = firstInputData.capacity;
                const calculatedPercentage = (totalLoadFirstDay / maximumLoad) * 100;
                const firstDayTotalHours = hoursRemainingDecimal.toFixed(2);

                loadData.push({
                    total: totalLoadFirstDay.toFixed(2),
                    persentase: calculatedPercentage.toFixed(2),
                    type: "aktual",
                    total_jam: firstDayTotalHours
                });

                remainingCapacity -= totalLoadFirstDay;
            }
        }

        if (remainingCapacity > 0) {
            let days = 1; // Hari pertama sudah dihitung, mulai dari hari berikutnya
            while (remainingCapacity > 0) {
                if(inputData[days]){
                    if (inputData[days].type === 'persentase') {
                        const adjustedLoadRate = loadRate * (inputData[days].persentase / 100);
                        maximumLoad = 24.00 * adjustedLoadRate;

                        const totalLoadFirstDay = Math.min(maximumLoad, remainingCapacity);
                        const firstDayTotalHours = (totalLoadFirstDay / adjustedLoadRate).toFixed(2);

                        loadData.push({
                            total: totalLoadFirstDay.toFixed(2),
                            persentase: inputData[days].persentase,
                            type: "persentase",
                            total_jam: firstDayTotalHours
                        });

                        remainingCapacity -= totalLoadFirstDay;
                    } else if (inputData[days].type === 'aktual') {
                        const totalLoadFirstDay = inputData[days].capacity;
                        const calculatedPercentage = (totalLoadFirstDay / maximumLoad) * 100;
                        const firstDayTotalHours = 24.00;

                        loadData.push({
                            total: totalLoadFirstDay.toFixed(2),
                            persentase: calculatedPercentage.toFixed(2),
                            type: "aktual",
                            total_jam: firstDayTotalHours
                        });

                        remainingCapacity -= totalLoadFirstDay;
                    }
                }else{
                    // Hitung waktu yang dibutuhkan untuk memuat sisa kapasitas per hari
                    const loadForTheDay = Math.min(remainingCapacity, loadRate * 24); // 24 jam dalam sehari
                    const totalHoursForDay = loadForTheDay / loadRate; // Jam yang dibutuhkan pada hari tersebut

                    // Tambahkan ke array loadData
                    loadData.push({
                        total: loadForTheDay.toFixed(2),
                        persentase: 100, // Persentase diatur tetap 100 untuk setiap hari
                        type: "persentase",
                        total_jam: totalHoursForDay.toFixed(2)
                    });

                    // Kurangi sisa kapasitas
                    remainingCapacity -= loadForTheDay;
                }
                days++; // Hitung hari selanjutnya
            }
        }

        showCapacityNew(loadData)
    }

    function showCapacity(loadData) {
        const capacityContainer = document.getElementById('capacity-container');
        capacityContainer.innerHTML = '';

        let totalJam = 0;

        loadData.forEach((data, index) => {
            // Pastikan data.total adalah angka
            const total = parseFloat(data.total);
            totalJam += parseFloat(data.total_jam);
            
            // Cek apakah total valid (angka)
            if (isNaN(total)) {
                return; // Skip jika total tidak valid
            }

            // Membuat elemen baris <div> baru
            const row = document.createElement('div');
            row.classList.add('flex', 'gap-4', 'mb-4', 'items-center'); // Gunakan flexbox untuk tata letak lebih baik

            // Kolom pertama: input untuk capacity
            const capacityInput = document.createElement('input');
            capacityInput.type = 'text';
            capacityInput.name = 'capacity[]';
            capacityInput.value = total.toFixed(2); // Pastikan total adalah angka
            capacityInput.readonly = true; // Default readonly karena tidak bisa diubah saat persentase dipilih
            capacityInput.classList.add('w-1/3', 'p-2', 'rounded-lg', 'border', 'border-gray-300', 'focus:outline-none', 'focus:ring-2', 'focus:ring-blue-500', 'text-center', 'bg-gray-100', 'capacity');

            // Kolom kedua: input untuk persentase
            const percentageInput = document.createElement('input');
            percentageInput.type = 'text';
            percentageInput.name = 'speed[]';
            percentageInput.value = data.persentase;
            percentageInput.readonly = false; // Default enabled
            percentageInput.classList.add('w-1/3', 'p-2', 'rounded-lg', 'border', 'border-gray-300', 'focus:outline-none', 'focus:ring-2', 'focus:ring-blue-500', 'text-center', 'persentase');

            // Kolom ketiga: select untuk memilih tipe (persentase atau aktual)
            const selectType = document.createElement('select');
            selectType.name = 'type[]';
            selectType.classList.add('w-1/3', 'p-2', 'rounded-lg', 'border', 'border-gray-300', 'focus:outline-none', 'focus:ring-2', 'focus:ring-blue-500', 'text-center', 'type'); // Tambahkan kelas 'type' di sini
            const optionPersentase = document.createElement('option');
            optionPersentase.value = 'persentase';
            optionPersentase.textContent = 'Persentase';
            const optionAktual = document.createElement('option');
            optionAktual.value = 'aktual';
            optionAktual.textContent = 'Aktual';

            selectType.appendChild(optionPersentase);
            selectType.appendChild(optionAktual);

            // Pilih option berdasarkan data.type
            if (data.type === 'aktual') {
                selectType.value = 'aktual';
                // Jika 'aktual', disable persentaseInput dan enable capacityInput
                capacityInput.readonly = false;
                percentageInput.readonly = true;
            } else if (data.type === 'persentase') {
                selectType.value = 'persentase';
                // Jika 'persentase', disable capacityInput dan enable persentaseInput
                capacityInput.readonly = true;
                percentageInput.readonly = false;
            }

            // Fungsi untuk mengubah status readonly berdasarkan pilihan select
            selectType.addEventListener('change', () => {
                if (selectType.value === 'persentase') {
                    // Jika persentase dipilih, disable capacity input dan enable persentase input
                    capacityInput.readonly = true;
                    percentageInput.readonly = false;
                } else if (selectType.value === 'aktual') {
                    // Jika aktual dipilih, disable persentase input dan enable capacity input
                    capacityInput.readonly = false;
                    percentageInput.readonly = true;
                }
            });

            // Tambahkan event onchange untuk capacityInput
            capacityInput.addEventListener('change', () => {
                updateData();
            });

            // Tambahkan event onchange untuk percentageInput
            percentageInput.addEventListener('change', () => {
                updateData();
            });

            // Tambahkan kolom-kolom ke dalam baris
            row.appendChild(capacityInput);
            row.appendChild(percentageInput);
            row.appendChild(selectType);

            // Tambahkan baris ke dalam container
            capacityContainer.appendChild(row);
        });

        if (isNaN(totalJam)) {
            console.error('Total jam tidak valid:', totalJam);
            return;
        }

        // 2. Ambil nilai start_date dari input datetime-local
        const startDateValue = document.getElementById('start_date').value;

        // Pastikan startDateValue memiliki nilai
        if (!startDateValue) {
            console.error('Start date tidak ada');
            return;
        }

        // 3. Ubah startDateValue menjadi objek Date (tanpa memperhatikan timezone)
        const startDate = new Date(startDateValue);

        // 4. Tambahkan totalJam ke startDate
        const totalJamInMilliseconds = totalJam * 60 * 60 * 1000; // Mengkonversi jam ke milidetik
        startDate.setTime(startDate.getTime() + totalJamInMilliseconds); // Menambah waktu dalam milidetik

        // 5. Format endDate dalam format datetime-local
        // Mengambil tahun, bulan, hari, jam, menit, dan detik dari startDate secara lokal
        const endYear = startDate.getFullYear();
        const endMonth = String(startDate.getMonth() + 1).padStart(2, '0'); // Menambahkan 1 karena bulan dimulai dari 0
        const endDay = String(startDate.getDate()).padStart(2, '0');
        const endHours = String(startDate.getHours()).padStart(2, '0');
        const endMinutes = String(startDate.getMinutes()).padStart(2, '0');

        // Menggabungkan menjadi format datetime-local
        const endDateString = `${endYear}-${endMonth}-${endDay}T${endHours}:${endMinutes}`;

        // 6. Set nilai end_date dengan nilai endDate
        document.getElementById('end_date').value = endDateString;
    }

    function showCapacityNew(loadData) {
        const capacityContainer = document.getElementById('capacity-container-new');
        capacityContainer.innerHTML = '';

        let totalJam = 0;

        loadData.forEach((data, index) => {
            // Pastikan data.total adalah angka
            const total = parseFloat(data.total);
            totalJam += parseFloat(data.total_jam);
            
            // Cek apakah total valid (angka)
            if (isNaN(total)) {
                return; // Skip jika total tidak valid
            }

            // Membuat elemen baris <div> baru
            const row = document.createElement('div');
            row.classList.add('flex', 'gap-4', 'mb-4', 'items-center'); // Gunakan flexbox untuk tata letak lebih baik

            // Kolom pertama: input untuk capacity
            const capacityInput = document.createElement('input');
            capacityInput.type = 'text';
            capacityInput.name = 'capacity_new[]';
            capacityInput.value = total.toFixed(2); // Pastikan total adalah angka
            capacityInput.readonly = true; // Default readonly karena tidak bisa diubah saat persentase dipilih
            capacityInput.classList.add('w-1/3', 'p-2', 'rounded-lg', 'border', 'border-gray-300', 'focus:outline-none', 'focus:ring-2', 'focus:ring-blue-500', 'text-center', 'bg-gray-100', 'capacity_new');

            // Kolom kedua: input untuk persentase
            const percentageInput = document.createElement('input');
            percentageInput.type = 'text';
            percentageInput.name = 'speed_new[]';
            percentageInput.value = data.persentase;
            percentageInput.readonly = false; // Default enabled
            percentageInput.classList.add('w-1/3', 'p-2', 'rounded-lg', 'border', 'border-gray-300', 'focus:outline-none', 'focus:ring-2', 'focus:ring-blue-500', 'text-center', 'persentase_new');

            // Kolom ketiga: select untuk memilih tipe (persentase atau aktual)
            const selectType = document.createElement('select');
            selectType.name = 'type_new[]';
            selectType.classList.add('w-1/3', 'p-2', 'rounded-lg', 'border', 'border-gray-300', 'focus:outline-none', 'focus:ring-2', 'focus:ring-blue-500', 'text-center', 'type_new'); // Tambahkan kelas 'type' di sini
            const optionPersentase = document.createElement('option');
            optionPersentase.value = 'persentase';
            optionPersentase.textContent = 'Persentase';
            const optionAktual = document.createElement('option');
            optionAktual.value = 'aktual';
            optionAktual.textContent = 'Aktual';

            selectType.appendChild(optionPersentase);
            selectType.appendChild(optionAktual);

            // Pilih option berdasarkan data.type
            if (data.type === 'aktual') {
                selectType.value = 'aktual';
                // Jika 'aktual', disable persentaseInput dan enable capacityInput
                capacityInput.readonly = false;
                percentageInput.readonly = true;
            } else if (data.type === 'persentase') {
                selectType.value = 'persentase';
                // Jika 'persentase', disable capacityInput dan enable persentaseInput
                capacityInput.readonly = true;
                percentageInput.readonly = false;
            }

            // Fungsi untuk mengubah status readonly berdasarkan pilihan select
            selectType.addEventListener('change', () => {
                if (selectType.value === 'persentase') {
                    // Jika persentase dipilih, disable capacity input dan enable persentase input
                    capacityInput.readonly = true;
                    percentageInput.readonly = false;
                } else if (selectType.value === 'aktual') {
                    // Jika aktual dipilih, disable persentase input dan enable capacity input
                    capacityInput.readonly = false;
                    percentageInput.readonly = true;
                }
            });

            // Tambahkan event onchange untuk capacityInput
            capacityInput.addEventListener('change', () => {
                updateDataNew();
            });

            // Tambahkan event onchange untuk percentageInput
            percentageInput.addEventListener('change', () => {
                updateDataNew();
            });

            // Tambahkan kolom-kolom ke dalam baris
            row.appendChild(capacityInput);
            row.appendChild(percentageInput);
            row.appendChild(selectType);

            // Tambahkan baris ke dalam container
            capacityContainer.appendChild(row);
        });

        if (isNaN(totalJam)) {
            console.error('Total jam tidak valid:', totalJam);
            return;
        }

        // 2. Ambil nilai start_date dari input datetime-local
        const startDateValue = document.getElementById('start_date_new').value;

        // Pastikan startDateValue memiliki nilai
        if (!startDateValue) {
            console.error('Start date tidak ada');
            return;
        }

        // 3. Ubah startDateValue menjadi objek Date (tanpa memperhatikan timezone)
        const startDate = new Date(startDateValue);

        // 4. Tambahkan totalJam ke startDate
        const totalJamInMilliseconds = totalJam * 60 * 60 * 1000; // Mengkonversi jam ke milidetik
        startDate.setTime(startDate.getTime() + totalJamInMilliseconds); // Menambah waktu dalam milidetik

        // 5. Format endDate dalam format datetime-local
        // Mengambil tahun, bulan, hari, jam, menit, dan detik dari startDate secara lokal
        const endYear = startDate.getFullYear();
        const endMonth = String(startDate.getMonth() + 1).padStart(2, '0'); // Menambahkan 1 karena bulan dimulai dari 0
        const endDay = String(startDate.getDate()).padStart(2, '0');
        const endHours = String(startDate.getHours()).padStart(2, '0');
        const endMinutes = String(startDate.getMinutes()).padStart(2, '0');

        // Menggabungkan menjadi format datetime-local
        const endDateString = `${endYear}-${endMonth}-${endDay}T${endHours}:${endMinutes}`;

        // 6. Set nilai end_date dengan nilai endDate
        document.getElementById('end_date_new').value = endDateString;
    }

</script>

@endsection

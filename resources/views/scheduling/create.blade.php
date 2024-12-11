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
                                    <option value="{{ $ship->id }}">{{ $ship->name }} @if($ship->acronym != null) ({{ $ship->acronym }}) @endif</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full">
                            <label for="dock" class="font-bold text-[#232D42] text-[16px]">Pilih Dermaga</label>
                            <div>
                                Jika dermaga tidak dapat di pilih, maka anda harus mengisi load rate dermaga dulu di <a class="text-blue-500 underline" href="{{ route('master-data.docks.index') }}" target="_blank">sini</a>
                            </div>
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
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }} @if($supplier->acronym != null) ({{ $supplier->acronym }}) @endif</option>
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
                    // Event listeners to detect changes in start_date, total_capacity, and dock selection
                    document.getElementById('start_date').addEventListener('change', calculateCapacity);
                    document.getElementById('total_capacity').addEventListener('input', calculateCapacity);
                    document.getElementById('dock').addEventListener('change', calculateCapacity);

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
                        
                        showCapacity(loadData)
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
                        showCapacity(loadData)
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

                </script>
            </div>
        </div>
    </div>
</div>

@endsection

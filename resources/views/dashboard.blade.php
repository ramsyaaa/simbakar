@extends('layouts.app')

@section('content')
<style>
    * {
        box-sizing: border-box;
    }
    div {
        margin: 0;
        padding: 0;
    }
</style>
@php
    function generateRandomColor() {
        // Menghasilkan nilai acak untuk komponen RGB (0-255)
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);

        // Mengonversi komponen RGB menjadi format hex
        return sprintf('#%02x%02x%02x', $red, $green, $blue);
    }
@endphp
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div>
                <a href="{{ route('scheduling.create') }}" class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg">Tambah Data</a>
                <!-- Tombol untuk Hide/Show -->
                <button id="toggleButton" class="px-4 py-2 text-white bg-blue-500 rounded mb-4">
                    Tampilkan Kapasitas
                </button>
            </div>
            <table class="table-auto border-collapse w-full" style="table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-center" style="width: 200px !important">Dermaga</th>
                        <!-- Kolom 2 hingga kolom 32 -->
                        @for ($i = 1; $i <= 31; $i++)
                            <th class="border border-gray-300 text-center text-[8px]" style="width: 24px;">{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach ($scheduling_plan as $key => $plan)
                    <tr class="relative" style="height:24px;">
                        <td class="border border-gray-300 px-3 truncate" style="width: 200px; position: relative;">
                            {{ $key }}
                        </td>
                        @for ($i = 1; $i <= 31; $i++)
                            <td class="border border-gray-300" style="width: 24px; position: relative;">
                                <!-- Ini adalah tempat untuk konten dalam kolom -->
                            </td>
                        @endfor
                    </tr>
                    <tr class="relative">
                        <td style="position: relative;">
                            @php
                                $shipPositions = [];
                                $mt = 0; // Mulai dari 0 untuk menyesuaikan posisi
                                $daysInMonth = array_fill(1, 31, []);
                            @endphp

                            @foreach ($plan as $p)
                                @php
                                    $bg_color = generateRandomColor();
                                @endphp
                                @foreach ($p as $ship)
                                    @php
                                        // Menghitung selisih waktu dalam menit
                                        $start_date = $ship->start_date;
                                        $end_date = $ship->end_date;
                                        $startTimestamp = strtotime($start_date);
                                        $endTimestamp = strtotime($end_date);
                                        $durationInMinutes = ($endTimestamp - $startTimestamp) / 60; // Durasi dalam menit
                                        $pxPerMinute = 31 / 1440; // 1 hari = 1440 menit
                                        $totalPx = (int) floor($durationInMinutes * $pxPerMinute);
                                        $dayOfMonth = (int) date('d', strtotime($ship->start_date));
                                        $leftPosition = ($dayOfMonth - 1) * 30; // Posisi left dalam px
                                        $startHour = (int) date('H', strtotime($start_date));
                                        $startMinute = (int) date('i', strtotime($start_date));
                                        $skipMinutes = ($startHour * 60) + $startMinute; // Total menit
                                        $skipPx = (int) floor($skipMinutes * $pxPerMinute); // Konversi ke piksel
                                        $leftPosition += $skipPx;

                                        if ($dayOfMonth >= 1 && $dayOfMonth <= 31) {
                                            $daysInMonth[$dayOfMonth][] = $ship->capacity;
                                        }

                                        // Simpan posisi dan warna
                                        $shipPositions[] = [
                                            'id' => $ship->id,
                                            'left' => $leftPosition,
                                            'width' => $totalPx,
                                            'bg_color' => $bg_color,
                                            'day' => $dayOfMonth,
                                            'mt' => $mt,
                                            'date' => $start_date . ' - ' . $end_date,
                                        ];
                                    @endphp
                                @endforeach
                                @php
                                    $mt += 24;
                                @endphp
                            @endforeach

                                <!-- Menggambar div berdasarkan posisi yang telah disimpan -->
                                @foreach ($shipPositions as $position)
                                    <a href="{{ route('scheduling.edit', ['id' => $position['id']]) }}" title="{{ $position['date'] }}" class="absolute bg-[{{ $position['bg_color'] }}] hover:scale-110"
                                        style="height: {{ count($plan) * 24 }}px;z-index: 100; height: 20px; top:-24px; left: {{ 260 + $position['left'] }}px; width: {{ $position['width'] }}px;">
                                    </a>
                                @endforeach
                        </td>
                    </tr>
                    <tr class="relative">
                        <th class="border border-gray-300 px-4 py-2 text-center" style="width: 200px !important"></th>
                        <!-- Kolom 2 hingga kolom 32 -->
                        @foreach ($daysInMonth as $day => $total)
                        <td class="border border-gray-300 text-center text-[8px]" style="width: 24px;">
                            <div class="hideshow hidden"> <!-- Elemen yang akan disembunyikan/ditampilkan -->
                                @foreach ($total as $t)
                                    {{ $t }} <!-- Menampilkan kapasitas -->
                                    <br>
                                @endforeach
                            </div>
                            <span class="font-bold">{{ count($total) > 0 ? array_sum($total) : 0 }}</span> <!-- Menampilkan jumlah kapasitas atau 0 -->
                        </td>
                        @endforeach
                    </tr>


                    @endforeach
                </tbody>

            </table>

            <div>
                <div class="w-full flex justify-center mb-6 bg-white">
                    <div class="p-4 rounded-lg shadow-sm w-[500px]">
                        <h1 class="text-center font-bold">Filter Pemakaian Permasok</h1>
                        <div class="flex gap-4 items-center mb-4">
                            <label for="filter_type">Pemasok:</label>
                            <select class="select-2 w-full border h-[40px] rounded-lg supplier-select" name="pemasok">
                                <option value="">Pilih Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-4 items-center mb-4">
                            <label for="filter_type">Filter:</label>
                            <select class="w-full border h-[40px] rounded-lg filter_type" id="filter_type" name="filter_type">
                                <option value="month">Bulan</option>
                                <option value="year">Tahun</option>
                            </select>
                        </div>

                        <div id="month-fields" class="filter-field">
                            <select name="tahun" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md month-input">
                                <option value="">Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div id="year-fields" class="filter-field" style="display: none;">
                            <div class="w-full mb-4">
                                <label for="start_year">Tahun Awal:</label>
                                <select name="start_year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md start_year">
                                    <option value="">Tahun</option>
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="w-full mb-4">
                                <label for="end_year">Tahun Akhir:</label>
                                <select name="end_year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md end_year">
                                    <option value="">Tahun</option>
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="w-full flex justify-end mt-3 gap-3">
                            <button id="loadChart" type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg">Submit</button>
                        </div>
                    </div>

                </div>
                <div class="w-full flex justify-center mb-6 bg-white chart-supplier" style="display:none">
                    <div class="p-4 rounded-lg shadow-sm">
                        <canvas id="myChart" width="700" height="600"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil referensi elemen
        const toggleButton = document.getElementById('toggleButton');
        const hideshowElements = document.querySelectorAll('.hideshow'); // Ambil semua elemen hideshow

        // Event listener untuk tombol
        toggleButton.addEventListener('click', function() {
            hideshowElements.forEach(function(element) {
                // Toggle kelas hidden
                element.classList.toggle('hidden');

                // Ubah teks tombol sesuai dengan status
                if (element.classList.contains('hidden')) {
                    toggleButton.textContent = 'Tampilkan Kapasitas';
                } else {
                    toggleButton.textContent = 'Sembunyikan Kapasitas';
                }
            });
        });
    });
</script>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterTypeSelect = document.getElementById('filter_type');
        const monthFields = document.getElementById('month-fields');
        const yearFields = document.getElementById('year-fields');

        function updateFields() {
            const filterType = filterTypeSelect.value;

            // Sembunyikan semua input terlebih dahulu
            monthFields.style.display = 'none';
            yearFields.style.display = 'none';

            // Tampilkan input yang sesuai dengan filter_type
            if (filterType === 'month') {
                monthFields.style.display = 'block';
            } else if (filterType === 'year') {
                yearFields.style.display = 'block';
            }
        }

        // Inisialisasi tampilan berdasarkan nilai saat ini
        updateFields();

        // Perbarui tampilan saat filter_type berubah
        filterTypeSelect.addEventListener('change', updateFields);
    });
</script>
<script>
    $(document).ready(function(){
        let chart;

        $('#loadChart').click(function() {
            let supplier_id  =  $('.supplier-select').find(":selected").val();
            let type  =  $('.filter_type').find(":selected").val();
            let month  = $('.month-input').val();
            let startYear  = $('.start_year').val();
            let endYear  = $('.end_year').val();
            let token = "{{ csrf_token() }}"
            console.log('ok');
            if(chart) {
                chart.destroy(); // Hancurkan chart sebelumnya jika ada
            }

            $.ajax({
                url: '{{ route('chartDataReceipt') }}',
                method: 'get',
                data: {
                    _token:token,
                    supplier_id:supplier_id,
                    type:type,
                    year:month,
                    startYear:startYear,
                    endYear:endYear,
                },
                success: function(response) {
                    $('.chart-supplier').show()

                    const ctx = document.getElementById('myChart').getContext('2d');
                    chart = new Chart(ctx, {
                        type: 'bar', // atau tipe lain sesuai kebutuhan
                        data: response, // Menggunakan data dari response
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
@endsection

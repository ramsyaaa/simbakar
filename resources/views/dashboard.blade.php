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
<div x-data="{sidebar:true}" class="w-screen h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
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

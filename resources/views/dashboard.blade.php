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
                <div class="font-bold text-[28px] mb-4">
                    Scheduling Plan {{ $text_title }}
                </div>
                <div>
                    <a href="{{ route('scheduling.create') }}" class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg">Tambah Data</a>
                    <!-- Tombol untuk Hide/Show -->
                    <button id="toggleButton" class="px-4 py-2 text-white bg-blue-500 rounded mb-4">
                        Tampilkan Kapasitas
                    </button>
                </div>
                <div class="flex justify-center mb-6 bg-white w-[250px]">
                    <form action="{{ route('administration.dashboard') }}">
                        <div class="p-4 rounded-lg shadow-sm w-full">
                            <h1 class="text-center font-bold">Filter Jadwal</h1>
                            <div class="flex gap-4 items-center mb-4">
                                <label for="filter_type">Filter:</label>
                                <select class="w-full border h-[40px] rounded-lg filter_type" id="filter_typeSchedule" name="filter_typeSchedule">
                                    <option {{ $type == 'month' ? 'selected' : '' }} value="month">Bulan</option>
                                    <option {{ $type == 'month between' ? 'selected' : '' }} value="month between">Pilih Tanggal</option>
                                </select>
                            </div>

                            <div id="month-fields-schedule" class="filter-field">
                                <input type="month" name="month_schedule" id="" value="{{ $month_value }}" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md month-input">
                            </div>

                            <div id="month-between-fields-schedule" class="filter-field" style="display: none;">
                                <div class="w-full mb-4">
                                    <label for="start_date_schedule">Tanggal Awal:</label>
                                    <input type="date" name="start_date_schedule" value="{{ isset(request()->start_date_schedule) ? request()->start_date_schedule : null }}" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md start_date_schedule">
                                </div>

                                <div class="w-full mb-4">
                                    <label for="end_date_schedule">Tanggal Akhir:</label>
                                    <input type="date" name="end_date_schedule" value="{{ isset(request()->end_date_schedule) ? request()->end_date_schedule : null }}" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md end_date_schedule">
                                </div>
                            </div>

                            <div class="w-full flex justify-end mt-3 gap-3">
                                <button type="submit" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div>
                    @php
                        $width = 48;
                        $totalWidth = $totalDay * $width + 350; // Total width untuk semua kolom
                    @endphp
                    <div class="overflow-auto pb-4">
                        @if(count($scheduling_plan) > 0)
                        <div class="w-full" style="min-width: {{ $totalWidth }}px; white-space: nowrap;">
                            <div class="flex">
                                <!-- Lebar tetap untuk kolom 'Dermaga' dengan box-sizing -->
                                <div class="border border-gray-400 text-center" style="width: 350px; box-sizing: border-box;">
                                    Dermaga
                                </div>
                                @for($i = 0; $i < $totalDay; $i++)
                                <!-- Lebar tetap untuk setiap kolom nomor dengan box-sizing -->
                                <div class="border-x border-t border-gray-400 text-center" style="width: {{ $width }}px; box-sizing: border-box;">
                                    @if($type == 'month')
                                    {{ $i + 1 }}
                                     @elseif($type == 'month between')
                                    @php
                                        $startDate = request()->start_date_schedule;
                                        $currentDate = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->addDays($i);
                                        echo $currentDate->day;
                                    @endphp
                                    @endif
                                </div>
                                @endfor
                            </div>

                            @foreach ($scheduling_plan as $key => $plan)
                            @php
                                $array = array_fill(0, $totalDay, []);
                            @endphp
                            <div class="relative flex" style="height: 32px;">
                                <!-- Lebar tetap untuk kolom keterangan dengan box-sizing -->
                                <div class="border border-gray-300 truncate" style="width: 350px; box-sizing: border-box;">
                                    {{ $key }}
                                </div>
                                @for ($i = 1; $i <= $totalDay; $i++)
                                <!-- Lebar tetap untuk setiap kolom konten dengan box-sizing -->
                                <div class="border border-gray-300" style="height: 32px;width: {{ $width }}px; box-sizing: border-box;">
                                    <!-- Tempat untuk konten dalam kolom -->
                                </div>
                                @endfor
                                @foreach ($plan as $p)
                                    @php
                                    $background = generateRandomColor();
                                    $totalDivWidth = 0;
                                    $text_left = 0;
                                    @endphp
                                    @foreach ($p as $index => $perDay)
                                    @php
                                        $left = 350;
                                        $start = new DateTime($start_date_filter);
                                        $end = new DateTime($perDay->start_date);
                                        $end_this_date = new DateTime($perDay->end_date);

                                        $interval = $start->diff($end);
                                        $intervalDay = $interval->days;
                                        $left += ($intervalDay * $width);

                                        $startOfDay = new DateTime($end->format('Y-m-d') . ' 00:00:00');
                                        $interval = $startOfDay->diff($end);
                                        // Mendapatkan total jam dan menit dari selisih
                                        $totalHours = $interval->h + ($interval->i / 60); // Mengonversi menit ke jam
                                        $totalDaysDecimal = $totalHours / 24;
                                        $left += round($totalDaysDecimal * $width);
                                        $interval = $end->diff($end_this_date);
                                        // Mendapatkan total jam dan menit dari selisih
                                        $totalHours = $interval->h + ($interval->i / 60); // Mengonversi menit ke jam
                                        $totalDaysDecimal = $totalHours / 24;
                                        $dayWidth = round( $totalDaysDecimal * $width);
                                        $totalDivWidth += $dayWidth;
                                        $array[$intervalDay][] = $perDay->capacity;
                                        if($index == 0){
                                            $text_left = $left;
                                        }
                                        if(isset($perDay->schedulingPlan->supplier->bg_color) && $perDay->schedulingPlan->supplier->bg_color != null){
                                            $background = $perDay->schedulingPlan->supplier->bg_color;
                                        }
                                    @endphp
                                    <a href="{{ route('scheduling.edit', ['id' => $perDay->id]) }}">
                                        <div title="{{ $perDay->start_date }} - {{ $perDay->end_date }}" class="absolute hover:scale-110 left-[{{ $left }}px] top-[4px] h-[24px] bg-[{{ $background }}]" style="width: {{ $dayWidth }}px; box-sizing: border-box; z-index: 100;">
                                            {{--  --}}
                                        </div>
                                    </a>
                                    @endforeach
                                    <div class="absolute text-white left-[{{ $text_left }}px] top-[4px] h-fit text-[10px] truncate" style="box-sizing: border-box; z-index: 101;">
                                        @if(count($p) > 0)
                                        {{-- @dd($p[0]->schedulingPlan->supplier->name ) --}}
                                        @php
                                            $ship_name = '-';
                                            if(isset($p[0]->schedulingPlan->ship)){
                                                $ship_name = $p[0]->schedulingPlan->ship->acronym != null ? $p[0]->schedulingPlan->ship->acronym : $p[0]->schedulingPlan->ship->name;
                                            }

                                            $supplier_name = '-';
                                            if(isset($p[0]->schedulingPlan->supplier)){
                                                $supplier_name = $p[0]->schedulingPlan->supplier->acronym != null ? $p[0]->schedulingPlan->supplier->acronym : $p[0]->schedulingPlan->ship->name;
                                            }
                                        @endphp
                                        {{ $supplier_name }}, {{ isset($p[0]->schedulingPlan->calor) ? $p[0]->schedulingPlan->calor : '' }}, {{ $ship_name }}
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="relative flex">
                                <!-- Lebar tetap untuk kolom keterangan dengan box-sizing -->
                                <div class="border-x border-b border-gray-300 truncate font-bold" style="width: 350px; box-sizing: border-box;">

                                </div>
                                @for ($i = 0; $i < count($array); $i++)
                                <!-- Lebar tetap untuk setiap kolom konten dengan box-sizing -->
                                <div class="border border-gray-300" style="width: {{ $width }}px; box-sizing: border-box;">
                                    <span class="text-gray-400 text-[10px] text-center flex flex-col gap-1 justify-center items-center">
                                        @foreach ($array[$i] as $total)
                                            <div class="hideshow">{{ $total }}</div>
                                        @endforeach
                                            <div class="font-bold">{{ array_sum($array[$i]) }}</div>
                                    </span>

                                </div>
                                @endfor
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="w-full font-bold mb-10 text[24px] text-center">
                            Data jadwal tidak ditemukan
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <div class="w-full flex justify-center mb-6 bg-white">
                    <div class="p-4 rounded-lg shadow-sm w-[500px]">
                        <h1 class="text-center font-bold">Filter Penerimaan Permasok</h1>
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
                            <select class="w-full border h-[40px] rounded-lg filter_type_pemasok" id="filter_type" name="filter_type">
                                <option value="month">Bulan</option>
                                <option value="year">Tahun</option>
                            </select>
                        </div>

                        <div id="month-fields" class="filter-field">
                            <select name="tahun" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md month-input-pemasok">
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
            <div>
                <div class="w-full flex justify-center mb-6 bg-white">
                    <div class="p-4 rounded-lg shadow-sm w-[500px]">
                        <h1 class="text-center font-bold">Filter Pasokan</h1>
                        <div class="field">
                            <select name="tahun" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md year-pasokan">
                                <option value="">Tahun</option>
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>


                        <div class="w-full flex justify-end mt-3 gap-3">
                            <button id="loadPasokan" type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg">Submit</button>
                        </div>
                    </div>

                </div>
                <div class="w-full flex justify-center mb-6 bg-white chart-pasokan" style="display:none">
                    <div class="p-4 rounded-lg shadow-sm">
                        <canvas id="pasokanChart" width="700" height="600"></canvas>
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


    // script for filter scheduling
    document.addEventListener('DOMContentLoaded', function() {
        const filterTypeSelectSchedule = document.getElementById('filter_typeSchedule');
        const monthFieldsSchedule = document.getElementById('month-fields-schedule');
        const monthBetweenFieldsSchedule = document.getElementById('month-between-fields-schedule');

        function updateFieldsSchedule() {
            const filterType = filterTypeSelectSchedule.value;

            // Sembunyikan semua input terlebih dahulu
            monthFieldsSchedule.style.display = 'none';
            monthBetweenFieldsSchedule.style.display = 'none';

            // Tampilkan input yang sesuai dengan filter_type
            if (filterType === 'month') {
                monthFieldsSchedule.style.display = 'block';
            } else if (filterType === 'month between') {
                monthBetweenFieldsSchedule.style.display = 'block';
            }
        }

        // Inisialisasi tampilan berdasarkan nilai saat ini
        updateFieldsSchedule();

        // Perbarui tampilan saat filter_type berubah
        filterTypeSelectSchedule.addEventListener('change', updateFieldsSchedule);
    });
</script>
<script>
    $(document).ready(function(){
        let chart;

        $('#loadChart').click(function() {
            let supplier_id  =  $('.supplier-select').find(":selected").val();
            let type  =  $('.filter_type_pemasok').find(":selected").val();
            let month  = $('.month-input-pemasok').val();
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
<script>
    $(document).ready(function(){
        let chartPasokan;

        $('#loadPasokan').click(function() {
            let year  = $('.year-pasokan').val();
            let token = "{{ csrf_token() }}"
            console.log('ok');
            if(chartPasokan) {
                chartPasokan.destroy(); // Hancurkan chart sebelumnya jika ada
            }

            $.ajax({
                url: '{{ route('chartDataPasokan') }}',
                method: 'get',
                data: {
                    _token:token,
                    year:year,
                },
                success: function(response) {
                    $('.chart-pasokan').show()

                    const ctx = document.getElementById('pasokanChart').getContext('2d');
                    chartPasokan = new Chart(ctx, {
                        type: 'bar', // atau tipe lain sesuai kebutuhan
                        data: {
                            labels: response.labels, // Nama-nama bulan
                            datasets: response.datasets // Dua dataset: Penerimaan dan Penggunaan Batubara
                        },

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

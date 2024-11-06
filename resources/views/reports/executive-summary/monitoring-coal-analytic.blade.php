@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="flex items-end justify-between mb-2">
                <div>
                    {{-- <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Analisa</span>
                    </div> --}}
                </div>
            </div>
            <div class="w-full flex justify-center mb-6">
                <form method="GET" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                    @csrf
                    <div class="flex gap-4 items-center mb-4">
                        <label for="filter_type">Filter:</label>
                        <select class="w-full border h-[40px] rounded-lg" id="filter_type" name="filter_type">
                            <option value="kontrak" {{ $filter_type == 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                            <option value="tahunan" {{ $filter_type == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                            <option value="periodik" {{ $filter_type == 'periodik' ? 'selected' : '' }}>Periodik</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="supplier_id" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md supplier-select">
                            <option selected disabled>Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{request('supplier_id') == $supplier->id ? 'selected' : ''}}> {{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="unit_id" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option selected disabled>Pilih Parameter</option>
                            @foreach ($units as $unit)
                                <option value="{{$unit->id}}" {{request('unit_id') == $unit->id ? 'selected' : ''}}> {{$unit->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <select name="basis" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                            <option selected disabled>Pilih Basis</option>
                            <option {{request('basis') == 'AR' ? 'selected' : ''}}>AR</option>
                            <option {{request('basis') == 'ADB' ? 'selected' : ''}}>ADB</option>
                        </select>
                    </div>
                    <div id="kontrak-fields" class="filter-field mb-6" style="display: none;">
                        <div class="mb-4">
                            <select name="contract_id" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md select-contract">
                                @if (request('contract_id'))
                                    @isset($numbers)
                                        @foreach ($numbers as $number)
                                            <option value="{{$number->id}}"  {{request('contract_id') == $number->id ? 'selected' : ''}}>{{$number->contract_number}}</option>
                                        @endforeach
                                    @endisset

                                @endif
                            </select>
                        </div>
                    </div>

                    <div id="tahunan-fields" class="filter-field" style="display: none;">
                        <div class="flex gap-3">
                            <div class="w-full mb-4">
                                <label for="start_year">Tahun Awal:</label>
                                <select name="start_year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                    <option value="">Tahun</option>
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option {{request()->start_year == $i ? 'selected' :''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="w-full mb-4">
                                <label for="end_year">Tahun Akhir:</label>
                                <select name="end_year" id="" class="w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                    <option value="">Tahun</option>
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option {{request()->end_year == $i ? 'selected' :''}}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="periodik-fields" class="filter-field" style="display: none;">
                        <div class="flex gap-3">

                            <div class="w-full mb-4">
                                <label for="start_year">Tanggal Awal:</label>
                                <input type="month" id="start_year" class="border h-[40px] w-full rounded-lg px-3" name="month_start"  min="2000" max="2100" value="{{request('month_start')}}">
                            </div>

                            <div class="w-full mb-4">
                                <label for="end_year">Tanggal Akhir:</label>
                                <input type="month" id="end_year" name="month_end" class="border h-[40px] w-full rounded-lg px-3"  min="2000" max="2100" value="{{request('month_end')}}">
                            </div>
                        </div>
                    </div>

                    <div class="w-full flex justify-end gap-3">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button type="button" class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="ExportToExcel('xlsx')">Download</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                        <a href="{{route('reports.executive-summary.index')}}" class="bg-pink-900 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
                    </div>
                </form>
            </div>

            @isset($coals)

            <div id="my-pdf">

                <div class="bg-white rounded-lg p-6 body">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <img src="{{asset('logo.png')}}" alt="" width="200">
                            <p class="text-right">UBP SURALAYA</p>
                        </div>
                        <div class="text-center text-[20px] font-bold">
                           <p>Monitoring Perbandingan Analisa Kualitas Batu Bara <br> {{$pemasok->name}} <br>
                            @if (request('filter_type') == 'kontrak')
                            No Kontrak {{$contract->contract_number }}
                            @endif
                            @if (request('filter_type') == 'tahunan')
                                {{request('start_year')}} s/d {{request('end_year')}}
                            @endif
                            @if (request('filter_type') == 'periodik')
                            {{request('month_start')}} s/d {{request('month_end')}}
                            @endif

                        </p>
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-auto max-w-full">
                        <table class="min-w-max" id="table">
                            <thead>
                                <tr>
                                    <th class="border bg-[#F5F6FA]" rowspan="2">No</th>
                                    <th class="border bg-[#F5F6FA]" rowspan="2">Tanggal Selesai Bongkar</th>
                                    @if (request('filter_type') != 'kontrak')
                                        <th class="border bg-[#F5F6FA]" rowspan="2">Kontrak</th>
                                    @endif
                                    <th class="border bg-[#F5F6FA]" rowspan="2">Kapal</th>
                                    <th class="border bg-[#F5F6FA]" rowspan="2">Terima ( TUG 3 ) ( Kg )</th>
                                    <th class="border bg-[#F5F6FA]" colspan="3">{{$parameter->name}} ( {{request('basis')}} )</th>
                                </tr>
                                <tr>
                                    <th class="border bg-[#F5F6FA]">Loading</th>
                                    <th class="border bg-[#F5F6FA]">Unloading</th>
                                    <th class="border bg-[#F5F6FA]">Labor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coals as $coal)
                                    <tr>
                                        <td class="border text-center">{{$loop->iteration}}</td>
                                        <td class="border text-center">
                                            {{ date('d-m-Y', strtotime($coal->end_date))}} 
                                        </td>
                                        @if (request('filter_type') != 'kontrak')
                                            <td class="border  text-center">{{$coal->contract->contract_number ?? ''}}</td>
                                        @endif
                                        <td class="border text-center">{{$coal->ship->name ?? ''}}</td>
                                        <td class="border text-center">{{number_format($coal->tug_3_accept)}}</td>
                                        <td class="border text-center">{{$coal->loading != null ? number_format($coal->loading, 2) : ''}}</td>
                                        <td class="border text-center">{{$coal->unloading != null ? number_format($coal->unloading, 2) : ''}}</td>
                                        <td class="border text-center">{{$coal->labor != null ? number_format($coal->labor, 2) : ''}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="{{request()->filter_type == 'kontrak' ? '4': '5'}}">Total</td>
                                    <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="3">{{ number_format($coals->sum('tug_3_accept')) }}</td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="{{request()->filter_type == 'kontrak' ? '4': '5'}}">Rata Rata Tertimbang</td>
                                    @php
                                        $loadingavg = $coals->sum('sum_loading') / $coals->sum('tug_3_accept');
                                        $unloadingavg = $coals->sum('sum_unloading') / $coals->sum('tug_3_accept');
                                        $laboravg = $coals->sum('sum_labor') / $coals->sum('tug_3_accept');
                                    @endphp

                                        <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($loadingavg,2) }}</td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($unloadingavg,2) }}</td>

                                        <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($laboravg,2) }}</td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="{{request()->filter_type == 'kontrak' ? '4': '5'}}">Hasil Analisa Tertinggi</td>

                                        <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->max('loading'),2) }}</td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->max('unloading'),2) }}</td>


                                        <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->max('labor'),2) }}</td>
                                </tr>
                                <tr>
                                    <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black" colspan="{{request()->filter_type == 'kontrak' ? '4': '5'}}">Hasil Analisa Terendah</td>

                                        <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->min('loading'),2) }}</td>
                                        <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->min('unloading'),2) }}</td>

                                        <td class="h-[36px] text-[16px] font-normal border px-2 text-center font-black">{{ number_format($coals->min('labor'),2) }}</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
         @endisset
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterTypeSelect = document.getElementById('filter_type');
        const kontrakFields = document.getElementById('kontrak-fields');
        const tahunanFields = document.getElementById('tahunan-fields');
        const periodikFields = document.getElementById('periodik-fields');

        function updateFields() {
            const filterType = filterTypeSelect.value;

            // Sembunyikan semua input terlebih dahulu
            kontrakFields.style.display = 'none';
            tahunanFields.style.display = 'none';
            periodikFields.style.display = 'none';

            // Tampilkan input yang sesuai dengan filter_type
            if (filterType === 'kontrak') {
                kontrakFields.style.display = 'block';
            } else if (filterType === 'tahunan') {
                tahunanFields.style.display = 'block';
            } else if (filterType === 'periodik') {
                periodikFields.style.display = 'block';
            }
        }

        // Inisialisasi tampilan berdasarkan nilai saat ini
        updateFields();

        // Perbarui tampilan saat filter_type berubah
        filterTypeSelect.addEventListener('change', updateFields);
    });
</script>

@endsection
@section('scripts')
<script>
    $('.supplier-select').change(function(){
        let id  = $(this).val();
        let token = "{{ csrf_token() }}"
        $(".select-contract").empty()
        $(".select-analysis").empty()
        $.ajax({
            method: "post",
            url: "{{route('getContract')}}",
            data: {
                _token:token,
                id:id,
                },
            success: function (response) {
                var contracts = response
                $(".select-contract").append(
                         `<option selected disabled>Pilih nomor kontrak</option>`
                            )
                contracts.forEach(contract=>{
                    $(".select-contract").append(
                         `<option value="${contract.id}">${contract.contract_number}</option>`
                            )
                        })
                    }
                 })
            })
</script>

@endsection

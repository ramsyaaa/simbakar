@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="flex items-end justify-between mb-2">
            </div>
            <div class="w-full flex justify-center mb-6">
                <form method="get" action="" class="p-4 bg-white rounded-lg shadow-sm w-[500px]">
                    <div class="mb-4">
                        <select name="supplier_id" id="" class="select-2 w-full lg:w-full h-[44px] text-[19px] text-[#8A92A6] border rounded-md supplier-select">
                            <option selected disabled>Pilih Supplier</option>
                            <option value="0" {{request('supplier_id') == 0 ? 'selected' : ''}}> Semua Pemasok</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}" {{request('supplier_id') == $supplier->id ? 'selected' : ''}}> {{$supplier->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="date" class="font-bold text-[#232D42] text-[16px]">Tanggal</label>
                        <div class="relative">
                            <input required type="month" name="date" value="{{ request('date') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                        </div>
                    </div>
                    <div class="flex gap-4 w-full mb-4">
                        @if(!empty($analytic))
                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasidata-awal-tahun" name="analytic[]" value="unloading" {{ in_array('unloading', $analytic) ? 'checked' :''  }}>
                                <label class="form-check-label" for="inisiasidata-awal-tahun">
                                Unloading
                                </label>
                            </div>
                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasipenerimaan-batu-bara" name="analytic[]" value="loading" {{ in_array('loading', $analytic) ? 'checked' :''  }}>
                                <label class="form-check-label" for="inisiasipenerimaan-batu-bara">
                                Loading
                                </label>
                            </div>
                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasipemakaian" name="analytic[]" value="labor" {{ in_array('labor', $analytic) ? 'checked' :''  }}>
                                <label class="form-check-label" for="inisiasipemakaian">
                                Labor
                                </label>
                            </div>
                        @else

                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasidata-awal-tahun" name="analytic[]" value="unloading" checked>
                                <label class="form-check-label" for="inisiasidata-awal-tahun">
                                Unloading
                                </label>
                            </div>
                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasipenerimaan-batu-bara" name="analytic[]" value="loading" checked>
                                <label class="form-check-label" for="inisiasipenerimaan-batu-bara">
                                Loading
                                </label>
                            </div>
                            <div class="pt-1">
                                <input class="mr-2 leading-tight" type="checkbox" id="inisiasipemakaian" name="analytic[]" value="labor" checked>
                                <label class="form-check-label" for="inisiasipemakaian">
                                Labor
                                </label>
                            </div>
                        @endisset

                    </div>

                    <div class="w-full flex justify-end gap-4">
                        <button type="button" class="bg-[#2E46BA] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="printPDF()">Print</button>
                        <button type="button" class="bg-[#1aa222] px-4 py-2 text-center text-white rounded-lg shadow-lg" onclick="ExportToExcel('xlsx')">Download</button>
                        <button class="bg-blue-500 px-4 py-2 text-center text-white rounded-lg shadow-lg" type="submit">Filter</button>
                        <a href="{{route('reports.coal-quality.index')}}" class="bg-pink-900 px-4 py-2 text-center text-white rounded-lg shadow-lg">Back</a>
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
                            {{-- <p>Perbandingan Hasil Analisa Kualitas Batu Bara Kapal {{$ship->name ?? ''}}</p>
                            <p>{{$pemasok->name ?? ''}} Tanggal {{date('d F Y', strtotime($contract->receipt_date))}}</p> --}}
                            {{-- <p>No: {{$tug->bpb_number}}/IBPB/UBPSLA/PBB/{{date('Y')}}</p> --}}
                        </div>
                        <div></div>
                    </div>
                    <div class="overflow-x-auto max-w-full" style="font-size:12px;">
                        <table class="min-w-max" style="font-size: 12px;" id="table">
                            <thead>
                                <tr class="text-center">
                                    <th class="border border-gray-400" rowspan="2">Nama Pemasok</th>
                                    <th class="border border-gray-400" rowspan="2">Kapal</th>
                                    <th class="border border-gray-400" rowspan="2">Tanggal Tiba</th>
                                    <th class="border border-gray-400" rowspan="2">Tanggal Selesai Bongkar</th>
                                    <th class="border border-gray-400" rowspan="2">Analisa</th>
                                    <th class="border border-gray-400" colspan="7">Proximate Analysis ( ASTM D-1372 )</th>
                                    <th class="border border-gray-400" colspan="4">Ultimate Analysis ( ASTM D-3176 )</th>
                                    <th class="border border-gray-400" colspan="4">Ash Fusion Temperature ( ASTM D-1857 )</th>
                                    <th class="border border-gray-400" colspan="11">Ash Analysis ( ASTM D-3682 )</th>
                                    <th class="border border-gray-400" colspan="5">Ukuran Butiran Batubara ( ASTM D-197 )</th>
                                    <th class="border border-gray-400" colspan="1">Lainnya</th>
                                </tr>
                                <tr>
                                    <th class="border border-gray-400">Total Moisture</th>
                                    <th class="border border-gray-400">Ad Moisture</th>
                                    <th class="border border-gray-400">Ash</th>
                                    <th class="border border-gray-400">Volatile</th>
                                    <th class="border border-gray-400">Fix Carbon</th>
                                    <th class="border border-gray-400">Total Sulfur</th>
                                    <th class="border border-gray-400">Kalor</th>
                                    <th class="border border-gray-400">Carbon</th>
                                    <th class="border border-gray-400">Hydrogen</th>
                                    <th class="border border-gray-400">Nitrogen</th>
                                    <th class="border border-gray-400">Oxygen</th>
                                    <th class="border border-gray-400">IDEF</th>
                                    <th class="border border-gray-400">Softening</th>
                                    <th class="border border-gray-400">Hemispherical</th>
                                    <th class="border border-gray-400">Fluid</th>
                                    <th class="border border-gray-400">SiO2</th>
                                    <th class="border border-gray-400">Al2O3</th>
                                    <th class="border border-gray-400">Fe2O3</th>
                                    <th class="border border-gray-400">CaO</th>
                                    <th class="border border-gray-400">MgO</th>
                                    <th class="border border-gray-400">Na2O</th>
                                    <th class="border border-gray-400">K2O</th>
                                    <th class="border border-gray-400">TiO2</th>
                                    <th class="border border-gray-400">SO3</th>
                                    <th class="border border-gray-400">P2O5</th>
                                    <th class="border border-gray-400">Mn3O4</th>
                                    <th class="border border-gray-400">Size > 70 </th>
                                    <th class="border border-gray-400">Size > 50 </th>
                                    <th class="border border-gray-400">Size > 32 - 50 </th>
                                    <th class="border border-gray-400">Size < 50 </th>
                                    <th class="border border-gray-400">Size < 2,38 </th>
                                    <th class="border border-gray-400">HGI </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coals as $coal)

                                   <tr>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400" rowspan="{{count($analytic) + 1}}">{{$coal->supplier->name ?? ''}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400" rowspan="{{count($analytic) + 1}}">{{$coal->ship->name ?? ''}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400" rowspan="{{count($analytic) + 1}}">{{$coal->arrived_date}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400" rowspan="{{count($analytic) + 1}}">{{$coal->end_date}}</td>
                                   </tr>
                                   @if (in_array('loading',$analytic))
                                   <tr>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">Loading : {{$coal->loading->surveyor->name}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->moisture_total}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->air_dried_moisture}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->ash}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->volatile_matter}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->fixed_carbon}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->total_sulfur}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->calor}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->carbon}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->hydrogen}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->nitrogen}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->oxygen}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->initial_deformation}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->softening}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->hemispherical}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->fluid}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->sio2}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->al2o3}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->fe2o3}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->cao}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->mgo}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->na2o}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->k2o}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->tlo2}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->so3}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->p2o5}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->mn3o4}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->butiran_70}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->butiran_50}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->butiran_32_50}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->butiran_32_50}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->butiran_238}}</td>
                                        <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->loading->hgi}}</td>
                                    </tr>
                                    @endif
                                   @if (in_array('unloading',$analytic))
                                   <tr>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">Unloading : {{$coal->unloading->surveyor->name}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->moisture_total}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->air_dried_moisture}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->ash}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->volatile_matter}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->fixed_carbon}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->total_sulfur}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->calor}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->carbon}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->hydrogen}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->nitrogen}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->oxygen}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->initial_deformation}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->softening}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->hemispherical}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->fluid}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->sio2}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->al2o3}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->fe2o3}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->cao}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->mgo}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->na2o}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->k2o}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->tlo2}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->so3}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->p2o5}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->mn3o4}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->butiran_70}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->butiran_50}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->butiran_32_50}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->butiran_32_50}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->butiran_238}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->unloading->hgi}}</td>
                                </tr>
                               @endif

                               @if (in_array('labor',$analytic))
                                <tr>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">Labor : </td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->moisture_total}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->air_dried_moisture}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->ash}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->volatile_matter}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->fixed_carbon}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->total_sulfur}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->calor}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->carbon}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->hydrogen}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->nitrogen}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->oxygen}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->initial_deformation}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->softening}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->hemispherical}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->fluid}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->sio2}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->al2o3}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->fe2o3}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->cao}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->mgo}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->na2o}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->k2o}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->tlo2}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->so3}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->p2o5}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->mn3o4}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->butiran_70}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->butiran_50}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->butiran_32_50}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->butiran_32_50}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->butiran_238}}</td>
                                    <td class="h-[36px] text-[12px] font-normal border border-gray-400">{{$coal->labor->hgi}}</td>
                                </tr>
                               @endif

                               @endforeach
                            </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </div>
</div>
@endsection
@section('scripts')

@endsection

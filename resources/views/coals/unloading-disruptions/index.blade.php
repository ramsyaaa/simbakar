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
                        List Gangguan Pembongkaran Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="cursor-pointer">Pembongkaran Batu Bara </span>/ <span class="text-[#2E46BA] cursor-pointer">Gangguan Pembongkaran</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('coals.unloadings.disruptions.create',['unloadingId'=>$unloading->id]) }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>

            </div>
            <div class="bg-white rounded-lg p-6 h-full">
              <div class="desc border border-slate-300  rounded shadow w-full lg:w-1/2 p-5 mb-4">
                <span> Kapal : {{$unloading->ship->name}}</span> <br/>
                <span> Tanggal Bongkar  : {{$unloading->unloading_date}}</span><br/>
                <span> BL(Kg) : {{number_format($unloading->bl)}}</span>
              </div>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Jenis Gangguan</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Waktu</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Durasi</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unloadings as $unloading)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $unloading->kind_disruption }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $unloading->start_disruption_date }} s/d {{$unloading->end_disruption_date}}</td>
                                @php
                                  $timestamp1 = $unloading->start_disruption_date;
                                  $timestamp2 = $unloading->end_disruption_date;

                                  $time1 = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp1);
                                  $time2 = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp2);

                                  $differenceInMinutes = $time1->diffInMinutes($time2);
                              @endphp

                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{$differenceInMinutes}} Menit</td>
                                <td class="h-[108px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('coals.unloadings.disruptions.edit', ['unloadingId'=>$unloading->id,'id' => $unloading->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('coals.unloadings.disruptions.destroy', ['unloadingId'=>$unloading->id,'id' => $unloading->id]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="bg-[#C03221] text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $unloadings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

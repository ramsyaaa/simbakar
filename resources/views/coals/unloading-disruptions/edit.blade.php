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
                        Ubah Gangguan Pembongkaran Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('coals.unloadings.disruptions.index',['unloadingId' => $unloading->id]) }}" class="cursor-pointer">Gangguan Pembongkaran Batu Bara</a> / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Ubah Gangguan Pembongkaran Batu Bara ?')" action="{{ route('coals.unloadings.disruptions.update',['unloadingId' => $unloading->id,'id'=>$unloadDisruption]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                        <div class="unloadings">
                            <div class="p-4 bg-white rounded-lg w-full">
                                <div class="w-full mb-5">
                                    <input type="hidden" name="unloading_id" value="{{$unloading->id}}">
                                    <label for="kind_disruption" class="font-bold text-[#232D42] text-[16px]">Jenis Gangguan</label>
                                    <div class="relative">
                                        <select name="kind_disruption" id="kind_disruption" class="select-2-tag select-disruption w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Jenis Gangguan</option>
                                            @foreach ($disruptions as $disruption)
                                                <option {{ $unloadDisruption->kind_disruption == $disruption->name ? 'selected':''}}>{{ $disruption->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('kind_disruption')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="group_disruption" class="font-bold text-[#232D42] text-[16px]">Kelompok Gangguan</label>
                                    <div class="relative">
                                        <select name="group_disruption" id="group_disruption" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                            <option selected disabled>Pilih Kelompok Gangguan</option>
                                            <option {{ $unloadDisruption->group_disruption == 'UBP Suralaya' ? 'selected':''}}>UBP Suralaya</option>
                                            <option {{ $unloadDisruption->group_disruption == 'Gangguan Kapal' ? 'selected':''}}>Gangguan Kapal</option>
                                        </select>
                                        @error('group_disruption')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="start_disruption_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Pembongkaran</label>
                                    <div class="relative">
                                        <input required type="datetime-local" name="start_disruption_date" value="{{$unloadDisruption->start_disruption_date}}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('start_disruption_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="w-full">
                                    <label for="end_disruption_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Pembongkaran</label>
                                    <div class="relative">
                                        <input required type="datetime-local" name="end_disruption_date" value="{{$unloadDisruption->end_disruption_date}}" class="w-full lg:w-96 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        @error('end_disruption_date')
                                        <div class="absolute -bottom-1 left-1 text-red-500">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="flex gap-3">

                            <a href="{{session('back_url')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                            <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

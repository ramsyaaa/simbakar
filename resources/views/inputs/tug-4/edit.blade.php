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
                        Ubah TUG 4
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('inputs.tug-4.index') }}" class="cursor-pointer">TUG - 4 </a> / <span class="text-[#2E46BA] cursor-pointer">Edit</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Ubah TUG 4 ?')" action="{{ route('inputs.tug-4.update',['id' => $tug->id]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                        <div class="unloadings">
                            <div class="p-4 bg-white rounded-lg w-full">
                                    <div class="w-full mb-5">
                                        <label for="bpb_number" class="font-bold text-[#232D42] text-[16px]">No BPB</label>
                                        <div class="relative">
                                            <input required type="text" value="{{$tug->bpb_number}}" name="bpb_number" class="w-full lg:w-46 border rounded-md mt-3 h-[40px] px-3">
                                            <small>Diperoleh dari BPB penerimaan, tapi dapat di edit</small>
                                            @error('bpb_number')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <label for="inspection_date" class="font-bold text-[#232D42] text-[16px]">Tanggal Periksa</label>
                                        <div class="relative">
                                            <input required type="date" value="{{$tug->inspection_date}}" name="inspection_date" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">

                                            @error('inspection_date')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full mb-5">
                                        <label for="user_inspection" class="font-bold text-[#232D42] text-[16px]">Pemeriksa</label>
                                        <div class="relative">
                                            @foreach ($pics as $pic)
                                                <div class="pt-1">
                                                    <input class="mr-2 leading-tight" type="checkbox" id="inspectionuser{{$loop->iteration}}" name="user_inspections[]" value="{{$pic->id}}"
                                                    @if ($tug->user_inspections)
                                                        @foreach (json_decode($tug->user_inspections) as $item)
                                                            {{($item == $pic->id) ? 'checked':''}}
                                                        @endforeach
                                                    @endif
                                                    >
                                                    <label class="form-check-label" for="inspectionuser{{$loop->iteration}}">
                                                    {{$pic->name}} - {{$pic->structural_position}} - {{$pic->functional_role}}
                                                    </label>
                                                </div>
                                            @endforeach

                                            @error('user_inspection')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full mb-5">
                                        <label for="tug_number" class="font-bold text-[#232D42] text-[16px]">No TUG 3</label>
                                        <div class="relative">
                                            <input required type="text" value="{{$tug->tug_number}}" name="tug_number" class="w-full lg:w-46 border rounded-md mt-3 h-[40px] px-3">
                                            @error('tug_number')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full mb-5">
                                        <label for="bunker_id" class="font-bold text-[#232D42] text-[16px]">Gudang</label>
                                        <div class="relative">
                                            <select name="bunker_id" id="bunker_id" class="w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option value="">Pilih</option>
                                                @foreach ($bunkers as $item)
                                                    <option value="{{ $item->id }}" {{ $tug->bunker_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('bunker_id')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full mb-5">
                                        <label for="general_manager" class="font-bold text-[#232D42] text-[16px]">PLT General Manager</label>
                                        <div class="relative">
                                            <select name="general_manager" id="general_manager" class="select-2 w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option value="">Pilih</option>
                                                @foreach ($pics as $manager)
                                                    <option value="{{ $manager->id }}" {{ $tug->general_manager == $manager->id ? 'selected' : '' }}>{{ $manager->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('general_manager')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="w-full mb-5">
                                        <label for="senior_manager" class="font-bold text-[#232D42] text-[16px]">PLT Senior Manager</label>
                                        <div class="relative">
                                            <select name="senior_manager" id="senior_manager" class="select-2 w-full lg:w-46 border rounded-md mt-3 mb-5 h-[40px] px-3">
                                                <option value="">Pilih</option>
                                                @foreach ($pics as $senior)
                                                    <option value="{{ $senior->id }}" {{ $tug->senior_manager == $senior->id ? 'selected' : '' }}>{{ $senior->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('senior_manager')
                                            <div class="absolute -bottom-1 left-1 text-red-500">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                            </div>
                        </div>
                            <div class="flex gap-3">

                            <a href="{{route('inputs.tug-4.index')}}" class="bg-[#C03221] text-center w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                            <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

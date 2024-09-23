@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        List Adendum Denda Penolakan Kontrak Batu Bara {{ $contract->contract_number}}
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> <span class="cursor-pointer"> <a href="{{ route('contracts.adendum-coal-contracts.index',['contractId' => $adendum->contract_id]) }}"> / Adendum Kontrak Batu Bara / </a>Adendum Denda Penolakan Kontrak Batu Bara </span> / <span class="text-[#2E46BA] cursor-pointer">{{$contract->contract_number}} </span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('contracts.adendum-coal-contracts.penalty-clause.create',['adendumId'=> $adendum->id]) }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <div class="desc border border-slate-300  rounded shadow w-full lg:w-1/2 p-5 mb-4">
                        <span> Masa Kontrak : {{$contract->contract_start_date}} s/d {{$contract->contract_end_date}}</span> <br/>
                        <span> Perpanjangan Kontrak ( Adendum )  :</span><br/>
                        <span> Volume Total : {{number_format($contract->total_volume)}}</span>
                    </div>
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">No</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Name</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penalties as $penalty)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">Bila {{$penalty->unit->name}} {{$penalty->penalty_will_get_if_sign}} {{$penalty->penalty_will_get_if_number}} sehingga harga turun 
                                    @if ($penalty->penalty_price_type_number == 'percentage')
                                    {{ $penalty->penalty_price_number}} %
                                    @else
                                    Rp .{{ $penalty->penalty_price_number}}
                                    @endif
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 ">
                                    <div class="flex items-center justify-center gap-2">

                                        <a href="{{ route('contracts.adendum-coal-contracts.penalty-clause.edit', ['adendumId'=>$adendum->id,'id' => $penalty->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                            Edit
                                        </a>
                                        <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('contracts.adendum-coal-contracts.penalty-clause.destroy', ['adendumId'=>$adendum->id,'id' => $penalty->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="bg-[#C03221] text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $penalties->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

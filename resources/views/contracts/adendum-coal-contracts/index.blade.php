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
                        List Adendum Kontrak Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Adendum Kontrak Batu Bara</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <form onsubmit="return confirmSubmit(this, 'Tambah data Adendum?')" action="{{ route('contracts.adendum-coal-contracts.store', ['contractId' => $contractId]) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-fit px-2 lg:px-0 lg:w-[300px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                            Tambah Data Adendum
                        </button>
                    </form>

                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">No</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Adendum</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Nomor Kontrak</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]"></th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]"></th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adendums as $adendum)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">Adendum Ke - {{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">
                                    <a href="{{route('contracts.adendum-coal-contracts.createContract',['contractId'=>$contractId,'adendumId' => $adendum->id])}}" class="text-sky-700">
                                        {{ $adendum->contract->contract_number }}
                                    </a>
                                    <br/>
                                    <span>Jenis : {{$adendum->contractAdendum->kind_contract ?? ''}}</span>
                                    <br/>

                                    <br/>
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">
                                    <ul class="text-center">
                                        <li>
                                            <a href="{{route('contracts.adendum-coal-contracts.spesification.index',['adendumId' => $adendum->id])}}" class="text-sky-700 hover:text-sky-900">
                                                Spesifikasi Batubara ( {{$adendum->spesifications->count()}} )
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('contracts.adendum-coal-contracts.delivery-clause.index',['adendumId' => $adendum->id])}}" class="text-sky-700 hover:text-sky-900">
                                                Klausul Pengiriman
                                            </a>

                                        </li>
                                        <li>
                                            <a href="{{route('contracts.adendum-coal-contracts.adjusment-clause.index',['adendumId' => $adendum->id])}}" class="text-sky-700 hover:text-sky-900">
                                                Klausul Penyesuaian
                                            </a>

                                        </li>
                                    </ul>
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">
                                    <ul class="text-center">
                                        <li>
                                            <a href="{{route('contracts.adendum-coal-contracts.penalty-clause.index',['adendumId' => $adendum->id])}}" class="text-sky-700 hover:text-sky-900">
                                                Klausul Denda Penolakan
                                            </a>

                                        </li>
                                    </ul>
                                </td>

                                <td class="h-[36px] text-[16px] font-normal border px-2 ">
                                    <div class="flex items-center justify-center gap-2">

                                        <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="#" method="POST">
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
                    {{ $adendums->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

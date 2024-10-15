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
                        List Pembongkaran Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="cursor-pointer">BBM </span>/ <span class="text-[#2E46BA] cursor-pointer">Pembongkaran</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('coals.unloadings.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                </div>

            </div>
            <div class="bg-white rounded-lg p-6 h-full">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('coals.unloadings.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <label for="" class="font-bold text-[#232D42] text-[16px]"> Kapan selesai di bongkar pada bulan </label>
                        <div class="w-full mb-2 lg:mb-0">
                            <input name="date" type="month" value="{{ request()->date ?? '' }}" class="w-full lg:w-1/2 h-[44px] rounded-md border px-2" placeholder="Cari Data" autofocus>
                        </div>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Tanggal</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Pemasok Kapal</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Dermaga</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Detail</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unloadings as $unloading)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    <span>Tiba : {{date('d-m-Y H:i:s', strtotime($unloading->arrived_date))}}</span><br/>
                                    <span>Bongkar : {{date('d-m-Y H:i:s', strtotime($unloading->unloading_date))}}</span><br/> 
                                    <span>Selesai : {{date('d-m-Y H:i:s', strtotime($unloading->end_date))}}</span>
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    <span>Pemasok : {{$unloading->supplier->name}}</span><br/>
                                    <span>Kapal : <span class="text-sky-700 cursor-pointer hover:text-sky-800 ship-modal"
                                    data-nama_kapal="{{$unloading->ship->name ?? ''}}"
                                    data-bendera="{{$unloading->ship->flag ?? ''}}"
                                    data-grt="{{$unloading->ship->grt ?? ''}}"
                                    data-dwt="{{$unloading->ship->dwt ?? ''}}"
                                    data-loa="{{$unloading->ship->loa ?? ''}}"
                                    >
                                    {{$unloading->ship->name ?? ''}}</span></span><br/>
                                    <span>BL : {{ number_format($unloading->bl)}}</span>
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    {{ $unloading->dock->name  ?? ''}}
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    <span>TUG3 : {{$unloading->tug_number}}</span><br/>
                                        <a href="#" class="text-sky-700 hover:text-sky-800 unloading-modal"
                                        data-analysis="{{$unloading->analysis_loading_id}}"
                                        data-company="{{$unloading->company->name ?? ''}}"
                                        data-dock="{{$unloading->dock->name ?? ''}}"
                                        data-supplier="{{$unloading->supplier->name ?? ''}}"
                                        data-ship="{{$unloading->ship->name ?? ''}}"
                                        data-bl="{{$unloading->bl}}"
                                        data-loading_date="{{$unloading->loading_date}}"
                                        data-arrived_date="{{$unloading->arrived_date}}"
                                        data-dock_ship_date="{{$unloading->dock_ship_date}}"
                                        data-unloading_date="{{$unloading->unloading_date}}"
                                        data-end_date="{{$unloading->end_date}}"
                                        data-departure_date="{{$unloading->departure_date}}"
                                        data-note="{{$unloading->note}}"
                                        data-tug_number="{{$unloading->tug_number}}"
                                        > Detail Pembongkaran</a><br/>

                                    </div>
                                    <a href="{{route('coals.unloadings.disruptions.index',['unloadingId'=>$unloading->id])}}" class="text-sky-700"> Gangguan Pembongkaran</a><br/>
                                </td>
                                <td class="h-[108px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('coals.unloadings.edit', ['id' => $unloading->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('coals.unloadings.destroy', ['id' => $unloading->id]) }}" method="POST">
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

  <!-- Modal -->
  <div id="myModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-lg p-6 lg:w-1/2 w-full">
      <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Detail Kapal</h2>
      <p id="modalContent" class="mb-4">This is a modal example with Tailwind CSS.</p>
      <button id="closeModalBtn" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600 focus:outline-none">
        Close
      </button>
    </div>
  </div>

  <!-- Modal -->
  <div id="unloading-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-lg p-6 lg:w-1/2 w-full">
      <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Detail Pembongkaran</h2>
      <p id="modalContent-unloading" class="mb-4">This is a modal example with Tailwind CSS.</p>
      <button id="closeModalBtn-unloading" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600 focus:outline-none">
        Close
      </button>
    </div>
  </div>

  <script>
    // Get all open modal buttons
    const openModalBtns = document.querySelectorAll('.ship-modal');

    // Add click event listeners to all buttons
    openModalBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        document.getElementById('modalContent').innerHTML ='';
        const name = this.getAttribute('data-nama_kapal');
        const flag = this.getAttribute('data-bendera');
        const grt = this.getAttribute('data-grt');
        const dwt = this.getAttribute('data-dwt');
        const loa = this.getAttribute('data-loa');

        // Set modal content based on button data attributes
        document.getElementById('modalContent').innerHTML = `
        <span>Nama Kapal : ${name} </span><br/>
        <span>Flag : ${flag}</span><br/>
        <span>Grt : ${grt}</span><br/>
        <span>Dwt : ${dwt}</span><br/>
        <span>Loa : ${loa}</span><br/>
        `;

        // Show the modal
        document.getElementById('myModal').classList.remove('opacity-0', 'pointer-events-none');
      });
    });

    // Close modal button
    document.getElementById('closeModalBtn').addEventListener('click', function() {
      document.getElementById('myModal').classList.add('opacity-0', 'pointer-events-none');
    });

    // Close the modal when clicking outside of it
    window.addEventListener('click', function(event) {
      const modal = document.getElementById('myModal');
      if (event.target === modal) {
        modal.classList.add('opacity-0', 'pointer-events-none');
      }
    });
  </script>
  <script>
    // Get all open modal buttons
    const modalBtn = document.querySelectorAll('.unloading-modal');

    // Add click event listeners to all buttons
    modalBtn.forEach(btn => {
      btn.addEventListener('click', function() {

        document.getElementById('modalContent-unloading').innerHTML ='';

        const analysis = this.getAttribute('data-analysis');
        const company = this.getAttribute('data-company');
        const dock = this.getAttribute('data-dock');
        const supplier = this.getAttribute('data-supplier');
        const ship = this.getAttribute('data-ship');
        const bl = this.getAttribute('data-bl');
        const loading_date = this.getAttribute('data-loading_date');
        const arrived_date = this.getAttribute('data-arrived_date');
        const dock_ship_date = this.getAttribute('data-dock_ship_date');
        const unloading_date = this.getAttribute('data-unloading_date');
        const end_date = this.getAttribute('data-end_date');
        const departure_date = this.getAttribute('data-departure_date');
        const note = this.getAttribute('data-note');
        const tug_number = this.getAttribute('data-tug_number');



        // Set modal content based on button data attributes
        document.getElementById('modalContent-unloading').innerHTML = `
        <span>Analisis : ${analysis} </span><br/>
        <span>PMB : ${dock} </span><br/>
        <span>Pemasok : ${supplier} </span><br/>
        <span>Dermaga : ${ship} </span><br/>
        <span>Kapal : ${ship} </span><br/>
        <span>BL : ${bl} </span><br/>
        <span>Tanggal Loading : ${loading_date} </span><br/>
        <span>Tanggal Tiba : ${arrived_date} </span><br/>
        <span>Tanggal Sandar : ${dock_ship_date} </span><br/>
        <span>Tanggal Pembongkaran : ${unloading_date} </span><br/>
        <span>Tanggal Selesai : ${end_date} </span><br/>
        <span>Tanggal Berangkat : ${departure_date} </span><br/>
        <span>Catatan : ${note} </span><br/>
        <span>TUG : ${tug_number} </span><br/>

        `;

        // Show the modal
        document.getElementById('unloading-modal').classList.remove('opacity-0', 'pointer-events-none');
      });
    });

    // Close modal button
    document.getElementById('closeModalBtn-unloading').addEventListener('click', function() {
      document.getElementById('unloading-modal').classList.add('opacity-0', 'pointer-events-none');
    });

    // Close the modal when clicking outside of it
    window.addEventListener('click', function(event) {
      const modal = document.getElementById('unloading-modal');
      if (event.target === modal) {
        modal.classList.add('opacity-0', 'pointer-events-none');
      }
    });
  </script>
@endsection

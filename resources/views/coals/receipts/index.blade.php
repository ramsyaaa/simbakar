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
                        List Penerimaan Batu Bara
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="cursor-pointer">Batu Bara </span>/ <span class="text-[#2E46BA] cursor-pointer">Penerimaan</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 h-full">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('coals.receipts.index') }}" method="GET" id="filterForm">
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
                            @foreach ($receipts as $receipt)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
<<<<<<< HEAD
                                    <span>Tiba : {{$receipt->arrived_date}}</span><br/>
                                    <span>Bongkar : {{$receipt->unloading_date}}</span><br/>
                                    <span>Selesai : {{$receipt->end_date}}</span>

=======
                                  <span>Tiba : {{date('d-m-Y H:i:s', strtotime($receipt->arrived_date))}}</span><br/>
                                  <span>Bongkar : {{date('d-m-Y H:i:s', strtotime($receipt->unloading_date))}}</span><br/> 
                                  <span>Selesai : {{date('d-m-Y H:i:s', strtotime($receipt->end_date))}}</span>
                                    
>>>>>>> baaeb297ce18bf5ed78fbc02a0c27cdd1f52f3d6
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    <span>Pemasok : {{$receipt->supplier->name}}</span><br/>
                                    <span>Kapal : <span class="text-sky-700 cursor-pointer hover:text-sky-800 ship-modal"
                                    data-nama_kapal="{{$receipt->ship->name}}"
                                    data-bendera="{{$receipt->ship->flag}}"
                                    data-grt="{{$receipt->ship->grt}}"
                                    data-dwt="{{$receipt->ship->dwt}}"
                                    data-loa="{{$receipt->ship->loa}}"
                                    >
                                    {{$receipt->ship->name}}</span></span><br/>
                                    <span>BL : {{ number_format($receipt->bl)}}</span>
                                    <div class="flex gap-3">
                                      @if ($receipt->analysis_loading_id == null)
                                        <div class="analysis text-red-700">[A.Loading Belum]</div>
                                      @endif
                                      @if ($receipt->analysis_unloading_id == null)
                                        <div class="analysis text-red-700">[A.Unloading Belum]</div>
                                      @endif
                                      @if ($receipt->analysis_labor_id == null)
                                        <div class="analysis text-red-700">[A.Labor Belum]</div>
                                      @endif
                                    </div>
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    {{ $receipt->dock->name ?? '' }}
                                </td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">
                                    <span>TUG3 : {{$receipt->tug_number}}</span><br/>
                                        <a href="#" class="text-sky-700 hover:text-sky-800 unloading-modal"
                                        data-analysis="{{$receipt->analysis_loading_id}}"
                                        data-company="{{$receipt->company->name}}"
                                        data-dock="{{$receipt->dock->name ?? ''}}"
                                        data-supplier="{{$receipt->supplier->name}}"
                                        data-ship="{{$receipt->ship->name}}"
                                        data-bl="{{$receipt->bl}}"
                                        data-loading_date="{{$receipt->loading_date}}"
                                        data-arrived_date="{{$receipt->arrived_date}}"
                                        data-dock_ship_date="{{$receipt->dock_ship_date}}"
                                        data-unloading_date="{{$receipt->unloading_date}}"
                                        data-end_date="{{$receipt->end_date}}"
                                        data-departure_date="{{$receipt->departure_date}}"
                                        data-note="{{$receipt->note}}"
                                        data-tug_number="{{$receipt->tug_number}}"
                                        > Detail</a><br/>

                                    </div>
                                    <a href="{{route('coals.receipts.quality',['id' => $receipt->id])}}" class="text-sky-700"> Analisa Kualitas</a><br/>
                                </td>
                                <td class="h-[108px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('coals.receipts.edit', ['id' => $receipt->id]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('coals.receipts.destroy', ['id' => $receipt->id]) }}" method="POST">
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
                    {{ $receipts->links() }}
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
      <h2 id="modalTitle" class="text-2xl font-semibold mb-4">Detail</h2>
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

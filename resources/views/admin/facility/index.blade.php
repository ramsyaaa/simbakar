@extends('admin.layouts.app')
@section('content')
<div class="content-inner container-fluid pb-0" id="page_layout">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
        <div class="d-flex flex-column">
            <h3>Facility</h3>
            <p class="text-primary mb-0">List Facility</p>
        </div>

        <div class="col-sm-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Table Facility</h4>
                  </div>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table id="datatable" class="table table-striped" data-toggle="data-table">
                        <thead>
                           <tr>
                              <th>No</th>
                              <th>Kota</th>
                              <th>Tipe</th>
                              <th>Nama</th>
                              <th>Nomor Whatsapp</th>
                              <th>Alamat</th>
                              <th>Note</th>
                              <th>Titik Map</th>
                              <th>User yang berkontribusi</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                            @foreach ($facilities as $facility)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$facility->city->name ?? ''}}</td>
                                <td>{{$facility->facility_type}}</td>
                                <td>{{$facility->facility_name  }}</td>
                                <td>{{$facility->whatsapp_number  }}</td>
                                <td>{{$facility->address}}</td>
                                <td>{{substr($facility->note,0,100)}}...</td>
                                <td>{{$facility->longitude}} , {{$facility->latitude}}</td>
                                <td>{{$facility->user->name ?? ''}}</td>
                                <td>
                                    {{-- <a href="#" class="btn btn-primary">Edit</a>
                                    <form action="{{route('admin.facility.destroy',['id'=>$facility->id])}}" method="POST" class="d-inline" id="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="deleteItem(this)">
                                            Delete
                                             </button>
                                    </form> --}}
                                </td>
                            </tr>
                            @endforeach
                         
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
@stop
@section('scripts')
<script>
    function deleteItem(e){
                // console.log(form);
                Swal.fire({
                    title: 'Hapus Data',
                    text: "Apakah kamu ingin menghapus data ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya !'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(e).parent().submit();
                    }
                })
            }
    
    </script>
@endsection
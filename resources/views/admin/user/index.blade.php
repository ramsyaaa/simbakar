@extends('admin.layouts.app')
@section('content')
<div class="content-inner container-fluid pb-0" id="page_layout">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
        <div class="d-flex flex-column">
            <h3>User</h3>
            <p class="text-primary mb-0">List user</p>
        </div>

        <div class="col-sm-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Table User</h4>
                  </div>
               </div>
               <div class="col-md-4 ms-4 pt-3">   
                   <a href="{{route('admin.user.create')}}" class="btn btn-primary">Tambah</a>
                </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table id="datatable" class="table table-striped" data-toggle="data-table">
                        <thead>
                           <tr>
                              <th>No</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Username</th>
                              <th>NID</th>
                              <th>Status</th>
                              <th>Role</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->nid}}</td>
                                <td>{{($user->status == true ? 'Active' : 'Nonactive')}}</td>
                                <td>{{$user->role->name ?? ''}}</td>
                                <td>
                                    <a href="{{route('admin.user.edit',['id'=>$user->id])}}" class="btn btn-primary">Edit</a>
                                    <form action="{{route('admin.user.destroy',['id'=>$user->id])}}" method="POST" class="d-inline" id="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="deleteItem(this)">
                                            Delete
                                             </button>
                                    </form>
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
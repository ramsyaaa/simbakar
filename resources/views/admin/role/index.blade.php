@extends('admin.layouts.app')
@section('content')
<div class="content-inner container-fluid pb-0" id="page_layout">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
        <div class="d-flex flex-column">
            <h3>Role</h3>
            <p class="text-primary mb-0">List Role</p>
        </div>

        <div class="col-sm-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Table Role</h4>
                  </div>
               </div>
                <div class="col-md-4 pt-3" >
                    <a href="{{route('admin.role.create')}}" class="btn btn-primary text-white" style="margin-left:30px;">
                        <i class="fas fa-plus"></i> Add Role</i>
                     </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                       <table id="datatable" class="table table-striped" data-toggle="data-table">
                          <thead>
                        <tr>
                            <th>No</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <th>{{$loop->iteration}}</th>
                                <td>{{$role->name}}</td>
                                <td>
                                    <a href="{{route('admin.role.edit',['id'=>$role->id])}}" class="btn btn-primary">
                                        Edit
                                    </a>
                                    <form action="{{route('admin.role.destroy',['id'=>$role->id])}}" method="POST" class="d-inline" id="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="deleteItem(this)">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

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
@stop

@extends('admin.layouts.app')
@section('content')
<div class="content-inner container-fluid pb-0" id="page_layout">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
        <div class="d-flex flex-column">
            <h3>User</h3>
            <p class="text-primary mb-0">Tambah user</p>
        </div>

        <div class="col-sm-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Buat User</h4>
                  </div>
               </div>
               <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{route('admin.user.store')}}">
                    @csrf
                    <div class="form-group row">
                        <label class="control-label col-sm-2 align-self-center mb-0" for="email11">Name</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2 align-self-center mb-0" for="email11">Email</label>
                        <div class="col-sm-10">
                        <input type="email" class="form-control" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2 align-self-center mb-0" for="email11">Username</label>
                        <div class="col-sm-10">
                        <input type="email" class="form-control" name="username">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2 align-self-center mb-0" for="email11">NID</label>
                        <div class="col-sm-10">
                        <input type="email" class="form-control" name="nid">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2 align-self-center mb-0" for="choices-single-default">Status</label>
                        <div class="col-sm-10">

                            <select class="form-select" name="status">
                                <option selected disabled>Pilih Status</option>
                                <option value="1">Active</option>
                                <option value="0">Non Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2 align-self-center mb-0" for="email11">Password</label>
                        <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="password" name="password">
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="control-label col-sm-2 align-self-center mb-0" for="choices-single-default">Role</label>
                        <div class="col-sm-10">

                            <select class="form-select" name="role_id">
                                <option selected disabled>Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                    <div class="form-group float-end">
                        <a href="{{route('admin.user.index')}}" class="btn btn-danger">Cancel</a>
                        <button type="button" class="btn btn-primary" onclick="submit()">Submit</button>
                    </div>
                </form>
               </div>
            </div>
         </div>
      </div>
@stop
@section('scripts')
<script>
    function submit(){
                // console.log(form);
                // Swal.fire({
                //     title: 'Hapus Data',
                //     text: "Apakah kamu ingin menghapus data ?",
                //     icon: 'warning',
                //     showCancelButton: true,
                //     confirmButtonColor: '#3085d6',
                //     cancelButtonColor: '#d33',
                //     confirmButtonText: 'Iya !'
                // }).then((result) => {
                //     if (result.isConfirmed) {
                //         $(e).parent().submit();
                //     }
                // })
                console.log('ok');
            }
    
    </script>
@endsection
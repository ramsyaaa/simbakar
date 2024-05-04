@extends('admin.layouts.app')
@section('content')
<div class="content-inner container-fluid pb-0" id="page_layout">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
        <div class="d-flex flex-column">
            <h3>Role</h3>
            <p class="text-primary mb-0">Edit Role</p>
        </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="container pe-5 ps-5">
                <form action="{{route('admin.role.update',['id'=>$role->id])}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <h6 class="page-title">Edit Roles</h6>
                        <div class="name-role">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$role->name}}">
                            </div>
                        </div>
                        <div class="user-role pt-3">
                            <h6 class="page-title">User</h6>
                            <div class="container">
                                <div class="row">
                                    <div class="form-check col-md-2">
                                        <input class="form-check-input" type="checkbox" id="userview" name="user[]" value="user view" {{$role->hasPermissionTo('user view') ?'checked':''}}>
                                        <label class="form-check-label" for="userview">
                                        view
                                        </label>
                                    </div>
                                    <div class="form-check col-md-2">
                                        <input class="form-check-input" type="checkbox" id="usercreate" name="user[]" value="user create" {{$role->hasPermissionTo('user create') ?'checked':''}}>
                                        <label class="form-check-label" for="usercreate">
                                        create
                                        </label>
                                    </div>
                                    <div class="form-check col-md-2">
                                        <input class="form-check-input" type="checkbox" id="useredit" name="user[]" value="user edit" {{$role->hasPermissionTo('user edit') ?'checked':''}}>
                                        <label class="form-check-label" for="useredit">
                                        edit
                                        </label>
                                    </div>
                                    <div class="form-check col-md-2">
                                        <input class="form-check-input" type="checkbox" id="userdelete" name="user[]" value="user delete" {{$role->hasPermissionTo('user delete') ?'checked':''}}>
                                        <label class="form-check-label" for="userdelete">
                                        delete
                                        </label>
                                    </div>
                                </div>
                            </div> 
                        </div>      
                        <div class="button-save d-flex justify-content-center pt-5">
                            <a href="{{route('admin.role.index')}}" class="btn btn-danger me-3"> Back</a>
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>   
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

@stop
@section('scripts')
@stop

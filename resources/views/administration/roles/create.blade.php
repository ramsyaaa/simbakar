@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen h-screen flex bg-[#E9ECEF] overflow-auto hide-scrollbar">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        Tambah Role
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('administration.roles.index') }}" class="cursor-pointer">Roles</a> / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="w-full bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan Role?')" action="{{ route('administration.roles.store') }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="name" class="font-bold text-[#232D42] text-[16px]">Nama</label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('name')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="user-role pb-10">
                                <h6 class="font-bold text-[#232D42] text-[16px]">User</h6>
                                <div class="container">
                                    <div class="grid grid-cols-12 gap-20">
                                        <div class="col-span-3">
                                            <input class="mr-2 leading-tight" type="checkbox" id="userview" name="user[]" value="user view">
                                            <label class="form-check-label" for="userview">
                                            view
                                            </label>
                                        </div>
                                        <div class="col-span-3">
                                            <input class="mr-2 leading-tight" type="checkbox" id="usercreate" name="user[]" value="user create">
                                            <label class="form-check-label" for="usercreate">
                                            create
                                            </label>
                                        </div>
                                        <div class="col-span-3">
                                            <input class="mr-2 leading-tight" type="checkbox" id="useredit" name="user[]" value="user edit">
                                            <label class="form-check-label" for="useredit">
                                            edit
                                            </label>
                                        </div>
                                        <div class="col-span-3">
                                            <input class="mr-2 leading-tight" type="checkbox" id="userdelete" name="user[]" value="user delete">
                                            <label class="form-check-label" for="userdelete">
                                            delete
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                            </div>  
                        </div>
                        <a href="{{route('administration.roles.index')}}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

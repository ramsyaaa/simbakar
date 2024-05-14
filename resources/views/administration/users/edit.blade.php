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
                        Edit User
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <a href="{{ route('administration.users.index') }}" class="cursor-pointer">Users</a> / <span class="text-[#2E46BA] cursor-pointer">Edit</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Update User?')" action="{{ route('administration.users.update', ['uuid' => $user->uuid]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="name" class="font-bold text-[#232D42] text-[16px]">Nama</label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') ? old('name') : $user->name }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('name')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="" class="font-bold text-[#232D42] text-[16px]">Username</label>
                                <div class="relative">
                                    <input type="text" name="username" value="{{ old('username') ? old('username') : $user->username }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('username')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="email" class="font-bold text-[#232D42] text-[16px]">Email</label>
                                <div class="relative">
                                    <input type="email" name="email" value="{{ old('email') ? old('email') : $user->email }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('email')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="nid" class="font-bold text-[#232D42] text-[16px]">NID</label>
                                <div class="relative">
                                    <input type="text" name="nid" value="{{ old('nid') ? old('nid') : $user->nid }}" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('nid')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="role_id" class="font-bold text-[#232D42] text-[16px]">Role</label>
                                <div class="relative">
                                    <select name="role_id" id="role_id" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option selected disabled>Pilih role</option>
                                        @foreach ($roles as $role)
                                            <option @if ($role->id == $user->role_id) selected @endif value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="role_id" class="font-bold text-[#232D42] text-[16px]">Status</label>
                                <div class="relative">
                                    <select name="role_id" id="role_id" class="w-full lg:w-[600px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                        <option selected disabled>Pilih Status</option>
                                        <option value="1" {{($user->status == 1) ? 'selected' :'' }}>Aktif</option>
                                        <option value="0" {{($user->status == 0) ? 'selected' :'' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{route('administration.users.index')}}" class="bg-[#C03221] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3 px-3">Back</a>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

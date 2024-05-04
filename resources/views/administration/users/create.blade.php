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
                        Tambah User
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('dashboard') }}">Home</a> / <a href="{{ route('administration.users.index') }}" class="cursor-pointer">Users</a> / <span class="text-[#2E46BA] cursor-pointer">Create</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form onsubmit="return confirmSubmit(this, 'Tambahkan User?')" action="{{ route('administration.users.store') }}" method="POST">
                    @csrf
                    <div class="p-4 bg-white rounded-lg w-full">
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="name" class="font-bold text-[#232D42] text-[16px]">Nama</label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
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
                                    <input type="text" name="username" value="{{ old('username') }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
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
                                    <input type="email" name="email" value="{{ old('email') }}" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('email')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="lg:flex items-center justify-between">
                            <div class="w-full">
                                <label for="password" class="font-bold text-[#232D42] text-[16px]">Password</label>
                                <div class="relative">
                                    <input type="password" name="password" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('password')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="w-full">
                                <label for="confirmation-password" class="font-bold text-[#232D42] text-[16px]">Konfirmasi Password</label>
                                <div class="relative">
                                    <input type="password" name="confirmation_password" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                                    @error('confirmation_password')
                                    <div class="absolute -bottom-1 left-1 text-red-500">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Tambah User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

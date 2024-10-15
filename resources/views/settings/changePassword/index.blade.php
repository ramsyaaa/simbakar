@extends('layouts.app')

@section('content')
<div  x-data="{
        sidebar : true,
        width : (window.innerWidth > 0) ? window.innerWidth : screen.width,
        bodyHeight: screen.height,
        }"
    @resize.window="
    width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    sidebar = false;
    " class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="text-[#135F9C] text-[40px] font-bold">
                Ubah Password
            </div>
            <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                Settings / <span class="text-[#2E46BA] cursor-pointer">Ubah Password</span>
            </div>
            <form action="{{ route('settings.change-password.post') }}" method="POST">
                @csrf
                <div class="p-4 bg-white rounded-lg w-full">
                    <label for="old-password" class="font-bold text-[#232D42] text-[16px]">Password Lama</label>
                    <div class="relative">
                        <input type="password" name="old_password" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                        @error('old_password')
                        <div class="absolute -bottom-1 left-1 text-red-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <label for="new-password" class="font-bold text-[#232D42] text-[16px]">Password Baru</label>
                    <div class="relative">
                        <input type="password" name="new_password" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                        @error('new_password')
                        <div class="absolute -bottom-1 left-1 text-red-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <label for="confirmation-password" class="font-bold text-[#232D42] text-[16px]">Konfirmasi Password</label>
                    <div class="relative">
                        <input type="password" name="confirmation_password" class="w-full lg:w-[300px] border rounded-md mt-3 mb-5 h-[40px] px-3">
                        @error('confirmation_password')
                        <div class="absolute -bottom-1 left-1 text-red-500">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button class="bg-[#2E46BA] w-full lg:w-[300px] py-3 text-[white] text-[16px] font-semibold rounded-lg mt-3">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

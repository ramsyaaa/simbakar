@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen h-screen flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-10 px-8">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        List Users
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Users</span>
                    </div>
                </div>
                <div class="flex gap-2 items-center">
                    <a href="{{ route('administration.users.create') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#222569] rounded-md text-[12px] lg:text-[19px] text-center">
                        Tambah Data
                    </a>
                    <a target="_blank" href="{{ route('administration.users.export-data') }}" class="w-fit px-2 lg:px-0 lg:w-[200px] py-1 lg:py-2 text-white bg-[#135F9C] rounded-md text-[12px] lg:text-[19px] text-center cursor-pointer">
                        Export Data
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6">
                <form x-data="{ submitForm: function() { document.getElementById('filterForm').submit(); } }" x-on:change="submitForm()" action="{{ route('administration.users.index') }}" method="GET" id="filterForm">
                    <div class="lg:flex items-center justify-between gap-2 w-full mb-3">
                        <div class="w-full mb-2 lg:mb-0">
                            <input name="name" type="text" value="{{ $name }}" class="w-full h-[44px] rounded-md border px-2" placeholder="Cari Data" autofocus>
                        </div>
                        <div class="mb-2 lg:mb-0">
                            <select name="role" id="" class="w-full lg:w-[200px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Role</option>
                                <option @if($role == 'Admin') selected @endif value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-2 lg:mb-0">
                            <select name="status" id="" class="w-full lg:w-[300px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">User dengan status</option>
                                <option @if($status == 'Aktif') selected @endif value="Aktif">Aktif</option>
                                <option @if($status == 'Tidak Aktif') selected @endif value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Role</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Nama</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">Status</th>
                                <th class="border  bg-[#F5F6FA] h-[52px] text-[#8A92A6]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">Admin</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $user->name }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">Aktif</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 flex items-center justify-center gap-2">
                                    <a href="{{ route('administration.users.edit', ['uuid' => $user->uuid]) }}" class="bg-[#1AA053] text-center text-white w-[80px] h-[25px] text-[16px] rounded-md">
                                        Edit
                                    </a>
                                    <form onsubmit="return confirmSubmit(this, 'Hapus Data?')" action="{{ route('administration.users.destroy', ['uuid' => $user->uuid]) }}" method="POST">
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div x-data="{sidebar:true}" class="w-screen overflow-hidden flex bg-[#E9ECEF]">
    @include('components.sidebar')
    <div class="max-h-screen overflow-hidden" :class="sidebar?'w-10/12' : 'w-full'">
        @include('components.header')
        <div class="w-full py-20 px-8 max-h-screen hide-scrollbar overflow-y-auto">
            <div class="flex items-end justify-between mb-2">
                <div>
                    <div class="text-[#135F9C] text-[40px] font-bold">
                        List Users
                    </div>
                    <div class="mb-4 text-[16px] text-[#6C757D] font-normal no-select">
                        <a href="{{ route('administration.dashboard') }}">Home</a> / <span class="text-[#2E46BA] cursor-pointer">Users</span>
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
                            <input name="find" type="text" value="{{ $find }}" class="w-full h-[44px] rounded-md border px-2" placeholder="Cari Data" autofocus>
                        </div>
                        <div class="mb-2 lg:mb-0">
                            <select name="role" id="" class="w-full lg:w-[200px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option value="">Role</option>
                                @foreach ($roles as $user_role)
                                <option @if($user_role->id == $role) selected @endif value="{{ $user_role->id }}">{{ $user_role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2 lg:mb-0">
                            <select name="status" id="" class="w-full lg:w-[300px] h-[44px] text-[19px] text-[#8A92A6] border rounded-md">
                                <option selected disabled>User dengan status</option>
                                <option @if($status == 1) selected @endif value="1">Aktif</option>
                                <option @if($status == 0) selected @endif value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="hidden">Search</button>
                </form>
                <div class="overflow-auto hide-scrollbar max-w-full">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Role</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Email</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Nama</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Username</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">NID</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">Status</th>
                                <th class="border text-white bg-[#047A96] h-[52px]">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{$user->role->name ?? ''}}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $user->email }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $user->name }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $user->username }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2">{{ $user->nid }}</td>
                                <td class="h-[36px] text-[16px] font-normal border px-2 text-center">{{ $user->status ? 'Aktif' : 'Tidak Aktif' }}</td>
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

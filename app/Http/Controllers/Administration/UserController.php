<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $data['role'] = $request->input('role');
        $data['status'] = $request->input('status');
        $data['roles'] = Role::get();

        $query = User::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%')
            ->orWhere('email', 'like', '%' . $data['find'].'%')
            ->orWhere('username', 'like', '%' . $data['find'].'%')
            ->orWhere('nid', 'like', '%' . $data['find'].'%');
        }
        if ($data['role']) {
            $query->where('role_id', $data['role']);
        }

        if ($data['status']) {
                $query->where('status', $data['status']);
        }

        $data['users'] = $query->paginate(10);
        $data['users']->appends(request()->query());
        return view('administration.users.index', $data);
    }

    public function create(){
        $data['roles'] = Role::get();
        return view('administration.users.create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'nid' => 'required|unique:users',
            'role_id' => 'required',
            'password' => 'required',
            'confirmation_password' => 'required|same:password',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'role_id.required' => 'Role wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'nid.required' => 'NID wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.unique' => 'Email sudah digunakan.',
            'nid.unique' => 'NID sudah digunakan.',
            'password.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
            'confirmation_password.required' => 'Konfirmasi kata sandi wajib diisi.',
            'confirmation_password.same' => 'Konfirmasi kata sandi harus sama dengan kata sandi.',
        ]);

        User::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'username' => $request->username,
            'nid' => $request->nid,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
            'status' => 1
        ]);

        return redirect(route('administration.users.index'))->with('success', 'User baru berhasil dibuat.');
    }

    public function destroy($uuid){
        User::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('administration.users.index'))->with('success', 'User berhasil dihapus.');
    }

    public function edit($uuid){
        $data['user'] = User::where([
            'uuid' => $uuid,
        ])->first();
        $data['roles'] = Role::get();
        return view('administration.users.edit', $data);
    }

    public function update(Request $request, $uuid){
        $user = User::where([
            'uuid' => $uuid,
        ])->first();

        $validate_username = 'required|unique:users';
        $validate_email = 'required|unique:users';
        $validate_nid = 'required|unique:users';
        if($user->username == $request->username){
            $validate_username = 'required';
        }
        if($user->email == $request->email){
            $validate_email = 'required';
        }
        if($user->nid == $request->nid){
            $validate_nid = 'required';
        }

        $request->validate([
            'name' => 'required',
            'role_id' => 'required',
            'nid' => $validate_nid,
            'username' => $validate_username,
            'email' => $validate_email,
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'nid.required' => 'NID wajib diisi.',
            'role_id.required' => 'Role wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nid.unique' => 'NID sudah digunakan.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        User::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'nid' => $request->nid,
            'role_id' => $request->role_id,
        ]);

        return redirect(route('administration.users.index'))->with('success', 'Update user berhasil dilakukan.');
    }

    public function export()
{
    return Excel::download(new UsersExport, 'users.xlsx');
}
}

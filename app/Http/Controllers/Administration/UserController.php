<?php

namespace App\Http\Controllers\Administration;

use App\User;
use Illuminate\Support\Str;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

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

       $user = User::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'username' => $request->username,
            'nid' => $request->nid,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
            'access_token' => Str::uuid(),
            'status' => 1
        ]);
        $role = Role::find($request->role_id);
        
        $user->assignRole($role->name);

        return redirect(route('administration.users.index'))->with('success', 'User baru berhasil dibuat.');
    }

    public function destroy($uuid){
        
        $user = User::where('uuid', $uuid)->first();
        $role = Role::where('id', $user->role_id)->first();

        $user->removeRole($role->name);
        $user->delete();

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

        //remove old role from user
        $oldRole = Role::where('id', $user->role_id)->first();
        $user->removeRole($oldRole->name);

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
            'status' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'nid.required' => 'NID wajib diisi.',
            'role_id.required' => 'Role wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'status.required' => 'Status wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nid.unique' => 'NID sudah digunakan.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $user = User::where('uuid', $uuid)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->nid = $request->nid;
        $user->role_id = $request->role_id;
        $user->save();

        // assign new role
        $newRole = Role::where('id', $request->role_id)->first();
        $user->assignRole($newRole);

        return redirect(route('administration.users.index'))->with('success', 'Update user berhasil dilakukan.');
    }

    public function export()
{
    return Excel::download(new UsersExport, 'users.xlsx');
}
}

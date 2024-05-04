<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Services\Admin\User\UserService;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        // Validate request data

        $user = $this->userService->index($request->all());
        $data['users'] = $user;
        return view('admin.user.index',$data);
    }

    public function create(Request $request)
    {
        $data['roles'] = Role::all();
        return view('admin.user.create',$data);
    }

    public function store(Request $request)
    {
        // Validate request data

        $user = $this->userService->createUser($request->all());

        if($user == true){
            Alert::success('Success', 'Berhasil menginput data user');
            return redirect()->route('admin.user.index');
        }else{
            Alert::error('Error', 'Gagal menginput data user');
            return redirect()->route('admin.user.index');
        }
    }
    public function edit($userId){

        $data = $this->userService->edit($userId);
        return view('admin.user.edit',$data);
    }

    public function update(Request $request, $userId)
    {
        // Validate request data

        $user = $this->userService->getUserById($userId);
        $user = $this->userService->updateUser($user, $request->all());

        if($user == true){
            Alert::success('Success', 'Berhasil mengubah data user');
            return redirect()->route('admin.user.index');
        }else{
            Alert::error('Error', 'Gagal mengubah data user');
            return redirect()->route('admin.user.index');
        }
        
    }
   

    public function destroy($userId)
    {
        $user = $this->userService->destroy($userId);

        if($user == true){
            Alert::success('Success', 'Berhasil menghapus data user');
            return redirect()->route('admin.user.index');
        }else{
            Alert::error('Error', 'Gagal menghapus data user');
            return redirect()->route('admin.user.index');
    }

    // Add more methods as needed for user management
}
}
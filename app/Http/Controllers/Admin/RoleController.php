<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\Admin\Role\RoleService;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    private $role;
    
    function __construct(RoleService $role)
    {
        $this->role = $role;
    }

    public function index(Request $request)
    {
        $data['roles'] = $this->role->index($request);
        return view('admin.role.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->role->store($request);
        Alert::success('Success', 'Role baru sudah di tambahkan');
        return redirect()->route('admin.role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['role'] = Role::where('id', $id)->first();
        return view('admin.role.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->role->update($request,$id);
        Alert::success('Success', 'Berhasil mengubah data role');
        return redirect()->route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = $this->role->destroy($id);
        if($destroy == true){
            Alert::success('Success', 'Berhasil menghapus data role');
            return redirect()->route('admin.role.index');
        }else{
            Alert::error('Error', 'Gagal menghapus data role');
            return redirect()->route('admin.role.index');
        }
    }
}

<?php

namespace App\Services\Admin\Role;

use App\User;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class RoleService{
    function index($request){
     
        $roles = Role::paginate(25);
        
        return $roles;
    }

    function store($request) {

        $writerRole = Role::create(['name' => $request->name,'guard_name' => 'web']);
        $this->givePermisionToRole($request, $writerRole);

    }

    function update($request,$id){

        $role = Role::where('id',$id)->first();
        $role->name = $request->name;
        $role->save();

        $role->syncPermissions([]);

        $this->givePermisionToRole($request,$role);

    }

    function destroy($id){

        $user = $this->checkUserRoleRelation($id);
        if($user == null){ 
            $role = Role::where('id',$id)->first();
            $permissions =  Permission::all();

            $role->syncPermissions([]);
            $role->delete();

            return true;
        }else{
            return false;
        }
    }

    function checkUserRoleRelation($id){
        return User::where('role_id',$id)->first();
    }

    private function givePermisionToRole($request ,$writerRole){
        if($request->has('administration')){
            foreach ($request->administration as $administration) {
                $existingPermission = Permission::where('name', $administration)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $administration]);
                }
                $writerRole->givePermissionTo($administration);
            }
        }       
        if($request->has('inisiasi')){
            foreach ($request->inisiasi as $inisiasi) {
                $existingPermission = Permission::where('name', $inisiasi)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $inisiasi]);
                }
                $writerRole->givePermissionTo($inisiasi);
            }
        }       
        if($request->has('kontrak')){
            foreach ($request->kontrak as $kontrak) {
                $existingPermission = Permission::where('name', $kontrak)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $kontrak]);
                }
                $writerRole->givePermissionTo($kontrak);
            }
        }       
        if($request->has('data')){
            foreach ($request->data as $data) {
                $existingPermission = Permission::where('name', $data)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $data]);
                }
                $writerRole->givePermissionTo($data);
            }
        }       
        if($request->has('inputan')){
            foreach ($request->inputan as $inputan) {
                $existingPermission = Permission::where('name', $inputan)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $inputan]);
                }
                $writerRole->givePermissionTo($inputan);
            }
        }       
        if($request->has('laporan')){
            foreach ($request->laporan as $laporan) {
                $existingPermission = Permission::where('name', $laporan)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $laporan]);
                }
                $writerRole->givePermissionTo($laporan);
            }
        }       
        if($request->has('batu_bara')){
            foreach ($request->batu_bara as $batu_bara) {
                $existingPermission = Permission::where('name', $batu_bara)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $batu_bara]);
                }
                $writerRole->givePermissionTo($batu_bara);
            }
        }       
        if($request->has('bbm')){
            foreach ($request->bbm as $bbm) {
                $existingPermission = Permission::where('name', $bbm)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $bbm]);
                }
                $writerRole->givePermissionTo($bbm);
            }
        }       
        if($request->has('kapal')){
            foreach ($request->kapal as $kapal) {
                $existingPermission = Permission::where('name', $kapal)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $kapal]);
                }
                $writerRole->givePermissionTo($kapal);
            }
        }       
        if($request->has('pengaturan')){
            foreach ($request->pengaturan as $pengaturan) {
                $existingPermission = Permission::where('name', $pengaturan)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $pengaturan]);
                }
                $writerRole->givePermissionTo($pengaturan);
            }
        }       
        if($request->has('variabel')){
            foreach ($request->variabel as $variabel) {
                $existingPermission = Permission::where('name', $variabel)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $variabel]);
                }
                $writerRole->givePermissionTo($variabel);
            }
        }   

        if($request->has('biomassa')){
            foreach ($request->biomassa as $biomassa) {
                $existingPermission = Permission::where('name', $biomassa)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $biomassa]);
                }
                $writerRole->givePermissionTo($biomassa);
            }
        }       
    }
}
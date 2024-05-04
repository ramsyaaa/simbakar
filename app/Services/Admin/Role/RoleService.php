<?php

namespace App\Services\Admin\Role;

use App\User;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class RoleService{
    function index($request){
     
        $roles = Role::all();
        
        return $roles;
    }

    function store($request) {

        $writerRole = Role::create(['name' => $request->name,'guard_name' => 'api']);
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
        if($request->has('user')){
            foreach ($request->user as $user) {
                $existingPermission = Permission::where('name', $user)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $user]);
                }
                
                $writerRole->givePermissionTo($user);
            }
        }
        if($request->has('facility')){
            foreach ($request->facility as $facility) {
                $existingPermission = Permission::where('name', $facility)->first();
                if (!$existingPermission) {
                    Permission::create(['name' => $facility]);
                }
                
                $writerRole->givePermissionTo($facility);
            }
        }
       
        
    }
}
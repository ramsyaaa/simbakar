<?php

namespace App\Services\Admin\User;

use App\User;
use Exception;
use App\Model\UserProfile;
use Illuminate\Support\Str;
use App\Helpers\ResponseHelper;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function index(){

        $users = User::where('id','!=',Auth::user()->id)->latest()->get();

        return $users;

    }
    
    public function createUser(array $userData)
    {
        DB::beginTransaction();
        try {
            // Create a new user
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'username' => $userData['username'],
                'nid' => $userData['nid'],
                'status' => $userData['status'],
                'role_id' => $userData['role_id'] ?? null,
                'access_token' => Str::uuid(),
                'password' => bcrypt($userData['password']),
            ]);

            // $role = Role::find($userData['role_id']);
        
            // $user->assignRole($role->name);

            DB::commit();
            return true;

        } catch (Exception $e) {

            dd($e);
            DB::rollback();
            return false;
        }
    }

    public function edit($id){

        $data['user'] = User::where('id', $id)->first();
        $data['roles'] = Role::all();

        return $data;
    }
    public function updateUser(User $user, array $userData)
    {
        DB::beginTransaction();
        try {

            $emailRule = [
                'string',
                'email',
                'nullable',
                Rule::unique('users')->ignore($user->id),
            ];
    
            $rules = [
                'username' => 'string|nullable',
                'name' => 'string|nullable',
                'email' => $emailRule,
            ];
            // Update user data

            // //remove old role from user
            // $oldRole = Role::where('id', $user->role_id)->first();
            // $user->removeRole($oldRole->name);

            $user->update([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'username' => $userData['username'],
                'nid' => $userData['nid'],
                'status' => $userData['status'],
                'role_id' => $userData['role_id'] ?? null,
                'password' => $userData['password'] ? bcrypt($userData['password']): $user->password,
            ]);

            //  // assign new role
            //  $newRole = Role::where('id', $userData['role_id'])->first();
            //  $user->assignRole($newRole);
            DB::commit();
            return true;

        } catch (Exception $e) {

            dd($e);
            DB::rollback();
            return false;
        }
    }

    public function deleteUser(User $user)
    {
        try {
            // Delete user
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getUserById($userId)
    {

        return $user = User::findOrFail($userId);
            
    }

    public function destroy($id){
        
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            // $role = Role::where('id', $user->role_id)->first();

            // $user->removeRole($role->name);

            $user->delete();

            DB::commit();

            return true;

        } catch (\Throwable $th) {

            DB::rollback();
            return false;
        }
    }

    // Add more methods as needed for user management
}

<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\UserRole;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserRoleController extends Controller
{
    public function __construct(User $user, UserRole $userRole)
    {
        $this->user = $user;
        $this->userRole = $userRole;
    }

    public function listForCheckbox(Request $request, $userId)
    {
        if ($request->role_query) {
            $results = \DB::select("
                select 
                r.id as role_id,
                r.slug,
                r.name,
                if(ur.user_id is null, false, true) as has_role
                from roles r  
                left join role_user ur on (ur.role_id = r.id and ur.user_id = $userId)
                where r.slug LIKE '%{$request->role_query}%' or r.name LIKE '%{$request->role_query}%'
            ");

        } else {
            $results = \DB::select("
                select 
                r.id as role_id,
                r.slug,
                r.name,
                if(ur.user_id is null, false, true) as has_role
                from roles r  
                left join role_user ur on (ur.role_id = r.id and ur.user_id = $userId)
            ");
        }

        return $results;
    }

    public function attach(Request $request, User $user)
    {

        try {
            $role = Role::findOrFail($request->role_id);
             $this->addRoleWithPermissions($user, $role);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function detach(Request $request, User $user)
    {
        try {
            $role = Role::findOrFail($request->role_id);
             $this->removeRoleWithPermissions($user, $role);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    
    public static function addRoleWithPermissions(User $user, Role $role)
    {
        return DB::transaction(function () use ($user, $role) {
            $user->roles()->attach($role->id);
            activity()
                ->performedOn($user)
                ->causedBy(request()->user())
                ->withProperties(
                    array_merge(['user_id' => $user->id, 'role_id' => $user->id])
                )
                ->log('attach role to a user');
            $role->permissions->each(function($permission) use ($user, $role){
                $user->permissions()->attach($permission->slug, ['role_id' => $role->id]);
                activity()
                    ->performedOn($user)
                    ->causedBy(request()->user())
                    ->withProperties(
                        array_merge(['user_id' => $user->id, 'permission_slug' => $permission->slug, 'role_id' => $user->id])
                    )
                    ->log('attached permission to a user');
            });
        });
    }

    public static function removeRoleWithPermissions(User $user, Role $role)
    {
        return DB::transaction(function () use ($user, $role) {
            $user->roles()->detach($role->id);
            activity()
                ->performedOn($user)
                ->causedBy(request()->user())
                ->withProperties(
                    array_merge(['user_id' => $user->id, 'role_id' => $user->id])
                )
                ->log('detached role from user');
            $role->permissions->each(function($permission) use ($user, $role){
                $user->permissions()->where('role_id', $role->id)->detach($permission->slug);
                activity()
                    ->performedOn($user)
                    ->causedBy(request()->user())
                    ->withProperties(
                        array_merge(['user_id' => $user->id, 'permission_slug' => $permission->slug, 'role_id' => $user->id])
                    )
                    ->log('detached permission from user');
            });
        });
    }

}

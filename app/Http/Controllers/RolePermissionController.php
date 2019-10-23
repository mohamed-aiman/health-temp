<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\UserPermission;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class RolePermissionController extends Controller
{
    public function __construct(Role $role, UserPermission $userPermission)
    {
        $this->role = $role;
        $this->userPermission = $userPermission;
    }

    public function index(Role $role)
    {
        return $role->load('permissions');
    }

    public function listForCheckbox(Request $request, $roleId)
    {
        if ($request->permission_query) {
            $results = \DB::select("
                select 
                    p.slug,
                    p.name,
                    if(rp.permission_slug is null, false, true) as has_permission
                from permissions p  
                left join permission_role rp on (rp.permission_slug = p.slug and rp.role_id = $roleId)
                where p.slug LIKE '%{$request->permission_query}%' or p.name LIKE '%{$request->permission_query}%'
            ");

        } else {
            $results = \DB::select("
                select 
                    p.slug,
                    p.name,
                    if(rp.permission_slug is null, false, true) as has_permission
                from permissions p  
                left join permission_role rp on (rp.permission_slug = p.slug and rp.role_id = $roleId)
            ");
        }

        return $results;
    }

    public function attach(Request $request, Role $role)
    {
        try {
            $permission = Permission::findOrFail($request->slug);
            $this->addPermissionWithUserPermissions($role, $permission);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function detach(Request $request, Role $role)
    {
        try {
            $permission = Permission::findOrFail($request->slug);
            $this->removePermissionWithUserPermissions($role, $permission);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public static function addPermissionWithUserPermissions(Role $role, Permission $permission)
    {
        return DB::transaction(function () use ($role, $permission) {
            $role->permissions()->attach($permission->slug);
            activity()
                ->performedOn($role)
                ->causedBy(request()->user())
                ->withProperties(
                    array_merge(['role_id' => $role->id, 'permission_slug' => $permission->slug])
                )
                ->log('attached permission to role');
            $role->users->each(function($user) use ($role, $permission) {
                $user->permissions()->attach($permission->slug, ['role_id' => $role->id]);
                activity()
                    ->performedOn($user)
                    ->causedBy(request()->user())
                    ->withProperties(
                        array_merge(['user_id' => $user->id, 'role_id' => $role->id, 'permission_slug' => $permission->slug])
                    )
                    ->log('added permission to role and added permission to role users');
            });
        });
    }

    public static function removePermissionWithUserPermissions(Role $role, Permission $permission)
    {
        return DB::transaction(function () use ($role, $permission) {
            $role->permissions()->detach($permission->slug);
            activity()
                ->performedOn($role)
                ->causedBy(request()->user())
                ->withProperties(
                    array_merge(['role_id' => $role->id, 'permission_slug' => $permission->slug])
                )
                ->log('detached permission from role');
            $role->users->each(function($user) use ($role, $permission) {
                $user->permissions()->where('role_id', $role->id)->where('user_id', $user->id)->detach($permission->slug);
                activity()
                    ->performedOn($user)
                    ->causedBy(request()->user())
                    ->withProperties(
                        array_merge(['user_id' => $user->id, 'role_id' => $role->id, 'permission_slug' => $permission->slug])
                    )
                    ->log('removed permission from role and removed permission from role users');
            });
        });
    }
}

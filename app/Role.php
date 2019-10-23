<?php

namespace App;

use App\Permission;
use App\User;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    protected $guarded = [];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_slug')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id')->withTimestamps();
    }
}
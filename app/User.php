<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user', 'user_id', 'permission_slug')->withTimestamps();
    }

    public function hasPermission(string $slug) : bool
    {
        return (boolean) $this->permissions()->where('permission_user.permission_slug', $slug)->first();
    }

    public static function isInspector($userId)
    {
        return self::whereHas('roles', function($query) {
            $query->where('slug', 'inspector');
        })->find($userId);
    }

    public static function isSupervisor($userId)
    {
        return self::whereHas('roles', function($query) {
            $query->where('slug', 'supervisor');
        })->find($userId);
    }
}

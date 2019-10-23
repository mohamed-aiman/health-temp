<?php

namespace App;

use App\Role;
use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'slug';

    protected $fillable = ['slug', 'name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
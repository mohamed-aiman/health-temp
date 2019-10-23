<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class UserPermission extends Model
{
    protected $table  = 'permission_user';

    protected $guarded = [];

}
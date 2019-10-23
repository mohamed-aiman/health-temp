<?php

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    protected $guarded = [];

    use SoftDeletes;

    protected $perPage = 100;
}

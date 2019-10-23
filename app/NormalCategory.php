<?php

namespace App;

use App\NormalPoint;


class NormalCategory extends Model
{
    protected $guarded = [];

    protected $table = 'normal_categories';

    public function normalPoints()
    {
    	return $this->hasMany(NormalPoint::class);
    }
}

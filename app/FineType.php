<?php

namespace App;

use App\Fine;

class FineType extends Model
{
    public function fines()
    {
    	return $this->hasMany(Fine::class);
    }
}

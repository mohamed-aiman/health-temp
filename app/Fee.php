<?php

namespace App;

use App\FeeType;

class Fee extends Model
{
    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
}

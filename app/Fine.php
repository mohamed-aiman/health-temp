<?php

namespace App;

use App\Business;
use App\FineType;
use App\Inspection;
use Carbon\Carbon;


class Fine extends Model
{
    protected $guarded = [];

    public function inspection()
    {
    	return $this->belongsTo(Inspection::class);
    }

    public function business()
    {
    	return $this->belongsTo(Business::class);
    }

    public function fineType()
    {
        return $this->belongsTo(FineType::class);
    }

    public function getFinedOnAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }
}

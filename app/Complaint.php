<?php

namespace App;

use App\Business;


class Complaint extends Model
{
    protected $guarded = [];

    protected $casts = [
    	'complaint_at' => 'datetime'
    ];

    public function business()
    {
    	return $this->belongsTo(Business::class);
    }
}

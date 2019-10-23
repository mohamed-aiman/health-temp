<?php

namespace App;

use App\Business;
use App\Inspection;
use Carbon\Carbon;


class Termination extends Model
{
	protected $guarded = [];

    /**
     * this is used in dropdown for selecting reason
     */
    const ALLOWED_REASONS = [
        "Poor Hygiene standards",
        "Pest issue",
        "License Expired",
        "3 follow up done and still major issues are present",
        "Requested by Owner",
        "Other violation under Food establishment hygiene standard Regulation",
        "Other",
    ];

	protected $casts = [
		'terminated_on' => 'datetime'
	];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function business()
    {
    	return $this->belongsTo(Business::class);
    }

    public function getTerminatedOnAttribute($value)
    {
    	if ($value != null) {
	    	return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d');
    	}

    	return $value;
    }
}

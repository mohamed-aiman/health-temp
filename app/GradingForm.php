<?php

namespace App;

use App\GradingFormPoint;
use App\GradingInspection;


class GradingForm extends Model
{
    protected $guarded = [];

    protected $table = 'grading_forms';

    protected $appends = [
        "inspection_reason",
    ];

    public function gradingInspection()
    {
    	return $this->belongsTo(GradingInspection::class);
    }

    public function gradingFormPoints()
    {
    	return $this->hasMany(GradingFormPoint::class);
    }


    public function getInspectionReasonAttribute()
    {
        return $this['reason'];
        // if ($this['reason']) {
        //     return ucwords(str_replace("_", " ", $this['reason']));
        // }

        // return null;
    }
}

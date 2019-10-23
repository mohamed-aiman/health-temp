<?php

namespace App;

use App\Inspection;
use App\NormalFormPoint;
use App\NormalInspection;


class NormalForm extends Model
{
    protected $guarded = [];

    protected $table = 'normal_forms';

    protected $appends = [
        "applied_reason",
        "inspection_reason",
    ];

    public function normalInspection()
    {
    	return $this->belongsTo(NormalInspection::class, 'normal_inspection_id');
    }

    public function inspection()
    {
        return $this->belongsTo(Inspection::class, 'normal_inspection_id');
    }

    public function normalFormPoints()
    {
    	return $this->hasMany(NormalFormPoint::class);
    }

    public function getAppliedReasonAttribute()
    {
        if ($this['applied_for']) {
            return ucfirst(str_replace("_", " ", $this['applied_for']));
        }

        return null;
    }

    public function getInspectionReasonAttribute()
    {
        if ($this['reason']) {
            return ucwords(str_replace("_", " ", $this['reason']));
        }

        return null;
    }
}

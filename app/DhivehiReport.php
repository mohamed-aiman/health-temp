<?php

namespace App;

use App\DhivehiReportNormalFormPoint;
use App\Inspection;
use App\NormalFormPoint;
use App\User;


class DhivehiReport extends Model
{
    protected $guarded = [];

    protected $table = 'dhivehi_reports';

    protected $appends = [
        "issued_by_name",
    ];

    protected $casts = [
        'food_conclusion_1' => 'boolean',
        'food_conclusion_2' => 'boolean',
        'food_conclusion_3' => 'boolean',
        'food_conclusion_4' => 'boolean',
        'food_conclusion_5' => 'boolean',
        'food_conclusion_6' => 'boolean',

        'tobacco_conclusion_1' => 'boolean',
        'tobacco_conclusion_2' => 'boolean',
        'tobacco_conclusion_3' => 'boolean',

        'phi_head_conclusion_1' => 'boolean',
        'phi_head_conclusion_2' => 'boolean',
        'phi_head_conclusion_3' => 'boolean',
        'phi_head_conclusion_4' => 'boolean',

        'tpcs_head_conclusion_1' => 'boolean',
        'tpcs_head_conclusion_2' => 'boolean',
        'tpcs_head_conclusion_3' => 'boolean',
        'tpcs_head_conclusion_4' => 'boolean',

        'grading' => 'array',
    ];

    public function getCriticalAttribute($value)
    {
        return json_decode($value);
    }

    public function getMajorAttribute($value)
    {
        return json_decode($value);
    }

    public function getMinorAttribute($value)
    {
        return json_decode($value);
    }

    public function getTobaccoAttribute($value)
    {
        return json_decode($value);
    }

    public function getCriticalTotalsAttribute($value)
    {
        return json_decode($value);
    }

    public function getMajorTotalsAttribute($value)
    {
        return json_decode($value);
    }

    public function getMinorTotalsAttribute($value)
    {
        return json_decode($value);
    }

    public function getTobaccoTotalsAttribute($value)
    {
        return json_decode($value);
    }

    public function setCriticalAttribute($value)
    {
        $this->attributes['critical'] = json_encode($value);
    }

    public function setMajorAttribute($value)
    {
        $this->attributes['major'] = json_encode($value);
    }

    public function setMinorAttribute($value)
    {
        $this->attributes['minor'] = json_encode($value);
    }

    public function setTobaccoAttribute($value)
    {
        $this->attributes['tobacco'] = json_encode($value);
    }

    public function setCriticalTotalsAttribute($value)
    {
        $this->attributes['critical_totals'] = json_encode($value);
    }

    public function setMajorTotalsAttribute($value)
    {
        $this->attributes['major_totals'] = json_encode($value);
    }

    public function setMinorTotalsAttribute($value)
    {
        $this->attributes['minor_totals'] = json_encode($value);
    }

    public function setTobaccoTotalsAttribute($value)
    {
        $this->attributes['tobacco_totals'] = json_encode($value);
    }

	public function inspection()
    {
    	return $this->hasOne(Inspection::class);
    }

    public function inspectionBelongsTo()
    {
    	return $this->belongsTo(Inspection::class);
    }

    public function normalFormPoints()
    {
        return $this->belongsToMany(NormalFormPoint::class)->using(DhivehiReportNormalFormPoint::class)->withPivot('no', 'code', 'violation', 'recommendation')->withTimestamps();
    }

    public function points()
    {
        return $this->hasMany(DhivehiReportNormalFormPoint::class);
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }


    public function getissuedByNameAttribute()
    {
        if ($user = $this->issuedBy) {
            return $user->name;
        }

        return null;
    }
}

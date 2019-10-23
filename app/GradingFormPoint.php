<?php

namespace App;

use App\GradingCategory;
use App\GradingForm;
use App\GradingPoint;


class GradingFormPoint extends Model
{
    protected $guarded = [];

    protected $table = 'grading_form_points';

    protected $casts = [
        'value' => 'boolean'
    ];

    public function gradingPoint()
    {
    	return $this->belongsTo(GradingPoint::class);
    }

    public function gradingForm()
    {
    	return $this->belongsTo(GradingForm::class);
    }

    public function gradingCategory()
    {
    	return $this->belongsTo(GradingCategory::class);
    }
}

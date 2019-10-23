<?php

namespace App;

use App\GradingCategory;


class GradingPoint extends Model
{
    protected $guarded = [];

    protected $table = 'grading_points';

    protected $casts = [
    	'is_active' => 'boolean'
    ];

    public function gradingCategory()
    {
    	return $this->belongsTo(GradingCategory::class);
    }
}

<?php

namespace App;

use App\GradingPoint;


class GradingCategory extends Model
{
    protected $guarded = [];

    protected $table = 'grading_categories';

    public function gradingPoints()
    {
    	return $this->hasMany(GradingPoint::class);
    }
}

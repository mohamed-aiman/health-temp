<?php

namespace App;

use App\NormalCategory;
use App\NormalForm;
use App\NormalPoint;


class NormalFormPoint extends Model
{
    protected $guarded = [];

    protected $table = 'normal_form_points';

    protected $casts = [
        'value' => 'boolean'
    ];

    public function normalPoint()
    {
    	return $this->belongsTo(NormalPoint::class);
    }

    public function normalForm()
    {
    	return $this->belongsTo(NormalForm::class);
    }

    public function normalCategory()
    {
    	return $this->belongsTo(NormalCategory::class);
    }
}

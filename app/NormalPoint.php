<?php

namespace App;

use App\NormalCategory;


class NormalPoint extends Model
{
    protected $guarded = [];

    protected $table = 'normal_points';

    protected $casts = [
    	'is_active' => 'boolean'
    ];

    public function normalCategory()
    {
    	return $this->belongsTo(NormalCategory::class);
    }
}

<?php

namespace App;

use App\Inspection;


class InspectionForm extends Model
{
    protected $guarded = [];

    protected $table = 'inspection_forms';

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function inspectionFormPoints()
    {
        // return $this->hasMany(InspectionFormPoint::class);
    }
}

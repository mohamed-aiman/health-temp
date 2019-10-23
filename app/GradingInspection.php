<?php

namespace App;

use App\Application;
use App\Business;
use App\GradingForm;
use App\GradingInspection;


class GradingInspection extends Model
{
    protected $guarded = [];

    protected $table = 'grading_inspections';

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function gradingForm()
    {
        return $this->belongsTo(GradingForm::class);
    }

    public function gradingFormSingle()
    {
        return $this->hasOne(GradingForm::class);
    }

    // public function followUpInspection()
    // {
    //     return $this->belongsTo(Inspection::class, 'follow_up_id');
    // }
    public function fines()
    {
        return $this->hasMany(Fine::class);
    }

    public function followUpInspection()
    {
        return $this->belongsTo(GradingInspection::class, 'follow_up_id');
    }

}

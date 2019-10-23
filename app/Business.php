<?php

namespace App;

use App\Application;
use App\Complaint;
use App\Fee;
use App\Fine;
use App\GradingInspection;
use App\Inspection;
use App\License;
use App\Termination;


class Business extends Model
{
    protected $table = 'businesses';

    // protected $casts = [
    //     'expire_at' => 'datetime'
    // ];
    
    protected $guarded = [];

    public function applications()
    {
    	return $this->hasMany(Application::class);
    }

    public function inspections()
    {
    	return $this->hasMany(Inspection::class);
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }


    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    public function hasALicense()
    {
        return $this->belongsTo(License::class, 'license_id');
    }

    public function activeLicense()
    {
        return $this->belongsTo(License::class, 'license_id');
    }

    public function gradingInspections()
    {
        return $this->hasMany(GradingInspection::class);
    }    

    public function activeApplication()
    {
        return $this->belongsTo(Application::class, 'active_application_id');
    }

    public function termination()
    {
        return $this->belongsTo(Termination::class);
    }

    public function terminations()
    {
        return $this->hasMany(Termination::class);
    }
}

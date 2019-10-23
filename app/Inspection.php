<?php

namespace App;

// use App\DhivehiReport;
use App\Application;
use App\Business;
use App\Complaint;
use App\EnglishReport;
use App\Fine;
use App\NormalForm;
use App\Termination;
use App\User;
use Carbon\Carbon;


class Inspection extends Model
{
    protected $guarded = [];

    protected $appends = [
	    "register_or_renew",
        "inspection_type_reason"
    ];

    protected $casts = [
        'inspection_at' => 'datetime',
        'is_fined' => 'boolean',
        'is_followup_required' => 'boolean',
    ];

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }

    public function normalForm()
    {
        return $this->belongsTo(NormalForm::class);
    }


    public function dhivehiReport()
    {
        return $this->belongsTo(DhivehiReport::class);
    }

    // public function dhivehiReportHasMany()
    // {
    //     return $this->hasMany(DhivehiReport::class);
    // }

    public function englishReport()
    {
        return $this->belongsTo(EnglishReport::class);
    }

    public function fine()
    {
        return $this->hasOne(Fine::class);
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }

    public function termination()
    {
        return $this->hasOne(Termination::class);
    }
    
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function followUpInspection()
    {
        return $this->belongsTo(Inspection::class, 'follow_up_id');
    }

    // public function followUpInspectionOf()
    // {
    //     return $this->belongsTo(Inspection::class, 'follow_up_id');
    // }


    public function getRegisterOrRenewAttribute()
    {
    	if ($this['type'] == '1') {
    		return 'New Registration';
    	}

    	if ($this['type'] == '2') {
    		return 'Renew License';
    	}

    	return null;
    }

    public function getInspectionTypeReasonAttribute()
    {
        if ($this['application_id'] != null) {
            if ($this['type'] == '1') {
                return 'Food (New Registration)';
            }

            if ($this['type'] == '2') {
                return 'Food (Renew License)';
            }

            return 'Tobacco (New Registration)';
        } else {
            return $this['reason'];
        }

    }
}

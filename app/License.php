<?php

namespace App;

use App\Business;



class License extends Model
{    
	protected $guarded = [];

    const LICENSE_TYPES = [1 => 'NEW', 2 => 'RENEW'];
    const SERVICE_TYPES = [1 => 'TOBACCO', 2 => 'FOOD'];

    const NEW_LICENSE = '1';
    const RENEW_LICENSE = '2';

    const TOBACCO = '1';
    const FOOD = '2';


    protected $appends = [
        "register_or_renew",
	    "tobacco_or_food",
        "license_application_type"
    ];

    protected $casts = [
    	'expire_at' => 'date',
    	'issued_at' => 'date',
    ];

    public function getRegisterOrRenewAttribute()
    {
    	if ($this['type'] == self::NEW_LICENSE) {
    		return 'New Registration';
    	}

    	if ($this['type'] == self::RENEW_LICENSE) {
    		return 'Renew License';
    	}

    	return null;
    }


    public function getTobaccoOrFoodAttribute()
    {
        if ($this['service_type'] == self::TOBACCO) {
            return 'Tobacco';
        }

        if ($this['service_type'] == self::FOOD) {
            return 'Food';
        }

        return null;
    }



    public function registrationLicense()
    {
        return ($this['type'] == self::NEW_LICENSE) ? true : false;
    }

    public function renewLicense()
    {
        return ($this['type'] == self::RENEW_LICENSE) ? true : false;
    }

    public function getLicenseApplicationTypeAttribute()
    {

        if ($this['service_type'] == self::TOBACCO) {
            return 'Tobacco';
        }

        if ($this['service_type'] == self::FOOD) {
            $type = 'Food';

            if ($this['type'] == self::NEW_LICENSE) {
                $type .= " (New Registration)";
            } else if ($this['type'] == self::RENEW_LICENSE) {
                $type .= " (Renew License)";
            }

            return $type;
        }

        return "NOT SPECIFIED";

    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

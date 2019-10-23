<?php

namespace App;

use App\Business;
use App\Document;
use App\Inspection;


class Application extends Model
{
    protected $table = 'applications';

    const NEW_LICENSE = '1';
    const RENEW_LICENSE = '2';

    const TOBACCO = '1';
    const FOOD = '2';
   
    protected $fillable = [
    	'business_id',
    	'status',
		'_1applicationType', //1 = than registry kurumah, 2 = hudhdha aakurumah
		'_1date',
		'_1registerPlace', //1,2,3,4  only when _1applicationType = 1
		'_1registrationNumber',
		'_1renewLicense', // 1,2,3 only when _1applicationType = 2
		'_1toRegisterPlace',
		'_1toRenewLicense',
		'_1tobaccoOrFood', //1 = tobacco, 2 = food
		'_1wantLicenseIndhivehi',
		'_1wantLicenseInenglish',
		'_2address',
		'_2idNo',
		'_2name',
		'_2phone',
		'_3address',
		'_3idNo',
		'_3name',
		'_3phone',
		'_4blockNumber',
		'_4numberOfChairs',
		'_4numberOfServingAreas',
		'_4placeAddress',
		'_4placeName',
		'_4road',
		'_5cat101',
		'_5cat101text',
		'_5cat11',
		'_5cat12',
		'_5cat13',
		'_5cat14',
		'_5cat15',
		'_5cat21',
		'_5cat31',
		'_5cat32',
		'_5cat33',
		'_5cat41',
		'_5cat42',
		'_5cat43',
		'_5cat51',
		'_5cat61',
		'_5cat62',
		'_5cat71',
		'_5cat81',
		'_5cat91',
    ];

    protected $casts = [
		'_1toRenewLicense' => 'boolean',
		'_1toRegisterPlace' => 'boolean',
		'_1wantLicenseIndhivehi' => 'boolean',
		'_1wantLicenseInenglish' => 'boolean',
		'_5cat11' => 'boolean',
		'_5cat12' => 'boolean',
		'_5cat13' => 'boolean',
		'_5cat14' => 'boolean',
		'_5cat15' => 'boolean',
		'_5cat21' => 'boolean',
		'_5cat31' => 'boolean',
		'_5cat32' => 'boolean',
		'_5cat33' => 'boolean',
		'_5cat41' => 'boolean',
		'_5cat42' => 'boolean',
		'_5cat43' => 'boolean',
		'_5cat51' => 'boolean',
		'_5cat61' => 'boolean',
		'_5cat62' => 'boolean',
		'_5cat71' => 'boolean',
		'_5cat81' => 'boolean',
		'_5cat91' => 'boolean',
		'_5cat101' => 'boolean',
    ];

    protected $appends = [
	    "permit_type",
	    "register_or_renew",
	    "application_type_slug"
    ];

    public function getRegisterOrRenewAttribute()
    {
    	if ($this['_1tobaccoOrFood'] == '1') {
    		return '-';
    	}

    	if ($this['_1toRegisterPlace']) {
    		return 'New Registration';
    	}

    	if ($this['_1toRenewLicense']) {
    		return 'Renew License';
    	}

    	return null;
    }

    public function getPermitTypeAttribute()
    {
    	switch ($this['_1tobaccoOrFood']) {
    		case '1':
    			return 'Tobacco';
    			break;
    		case '2':
    			return 'Food';
    			break;
    		default:
    			return null;
    			break;
    	}
    }

    public function business()
    {
    	return $this->belongsTo(Business::class);
    }

    public function inspections()
    {
    	return $this->hasMany(Inspection::class);
    }

    public function license()
    {
    	return $this->hasOne(License::class);
    }


    public function getApplicationTypeSlugAttribute()
    {

        if ($this['_1tobaccoOrFood'] == self::TOBACCO) {
            return 'tobacco';
        }

        if ($this['_1tobaccoOrFood'] == self::FOOD) {
            $type = 'food';

            if ($this['_1applicationType'] == self::NEW_LICENSE) {
                $type .= "_new_registration";
            } else if ($this['_1applicationType'] == self::RENEW_LICENSE) {
                $type .= "_renewal";
            }

            return $type;
        }

        return "not_specified";

    }

    public function documents()
    {
    	return $this->belongsToMany(Document::class);
    }
}

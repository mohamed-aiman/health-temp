<?php

namespace App\Helpers;

use App\Business;
use App\Application;


class AutofillLicense
{
	public function __construct(Business $business)
	{
		$this->business = $business;
	}

	public function handle(Application $application)
    {
        $licenseDetails = $this->getLicenseDetails($application);
        
        return array_merge($licenseDetails, ['registration_no' => $this->getRegistrationNo($licenseDetails)]);
    }

    protected function getRegistrationNo($licenseDetails)
    {
        if ($this->business->identification_code) {
            return $this->business->identification_code;
        }

        return (new RegistrationNumberGenerator($this->business))->handle($licenseDetails);
    }

    protected function getLicenseDetails($application)
    {
    	$details = new LicenseDetails();
    	return $details->usingApplication($application)->handle();
    }

}
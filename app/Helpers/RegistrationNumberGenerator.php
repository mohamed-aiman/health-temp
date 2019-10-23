<?php

namespace App\Helpers;

use App\Business;
use Carbon\Carbon;


class RegistrationNumberGenerator
{
    protected $business;

	public function __construct(Business $business)
	{
		$this->business = $business;
	}
	
	public function handle($licenseDetails)
    {
        return 'HPA/' . $this->islandCode() . '/' . $this->categoryCode($licenseDetails) . '/' . Carbon::now()->format('Y') . '/' . $this->number();
    }

    protected function islandCode()
    {
        return 'T-10';
    }

    protected function categoryCode($licenseDetails)
    {
        return $licenseDetails['category_code'];
    }

    protected function number()
    {
        return $this->business->id;     
    }

}
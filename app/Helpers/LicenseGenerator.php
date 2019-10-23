<?php

namespace App\Helpers;

use App\Application;
use Carbon\Carbon;

class LicenseGenerator
{
	public function __construct(Application $application)
	{
		$this->application = $application;
	}

	public function generate()
	{
		return 'HPA-PHID/' . $this->islandCode() . '/' . Carbon::now()->format('Y') .  $this->number();
    }

    protected function islandCode()
    {
        return 'T-10';
    }

    protected function number()
    {
        return $this->application->id;
	}   
}
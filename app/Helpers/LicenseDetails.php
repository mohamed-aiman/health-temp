<?php

namespace App\Helpers;

use App\Application;
use App\Business;
use App\Helpers\LicenseGenerator;
use App\Inspection;
use App\NormalForm;

class LicenseDetails
{
	public function usingApplication(Application $application)
	{
		$this->application = $application;

		return $this;
	}

	public function usingForm(NormalForm $form)
	{
		//we need application to identify the category
		return $this->usingApplication($this->getFormApplication($form));
	}

	public function usingBusiness(Business $business)
	{
		//we need application to identify the category
		return $this->usingApplication($this->getBusinessApplication($business));
	}


	public function handle()
    {
    	$details = $this->getCommonDetails($this->application);

    	if (in_array($this->application->application_type_slug, ['food_new_registration', 'food_renewal'])) {
			return array_merge($details, self::getFoodPermitDetails($this->application));
    	}

    	if (in_array($this->application->application_type_slug, ['tobacco'])) {
			return array_merge($details, self::getTobaccoPermitDetails($this->application));
    	}
    }

	protected function getCommonDetails($application)
	{
		$categories = [
			'_5cat11' => [
				'category_dv' => 'ހޮޓާ',
				'category_code' => 'C1',
				'amount'  => 2000,
			],
			'_5cat12' => [
				'category_dv' => 'ކެފޭ',
				'category_code' => 'C1',
				'amount'  => 2000,
			],
			'_5cat13' => [
				'category_dv' => 'ރެސްޓޯރަންޓް',
				'category_code' => 'C1',
				'amount'  => 2000,
			],
			'_5cat14' => [
				'category_dv' => 'ކެންޓީން',
				'category_code' => 'C1',
				'amount'  => 2000,
			],
			'_5cat15' => [
				'category_dv' => 'ކޮފީ ޝޮޕް',
				'category_code' => 'C1',
				'amount'  => 2000,
			],
			'_5cat21' => [
				'category_dv' => 'ކޭޓަރިންގ ސރވިސަސް',
				'category_code' => 'C2',
				'amount'  => 2000,
			],
			'_5cat31' => [
				'category_dv' => 'ޕޭސްޓްރީ ޝޮޕް/ޓޭކްއަވޭ(ބަދިގެއާއި އެކު)',
				'category_code' => 'C3',
				'amount'  => 2000,
			],
			'_5cat32' => [
				'category_dv' => 'ބޭކަރީ',
				'category_code' => 'C3',
				'amount'  => 2000,
			],
			'_5cat33' => [
				'category_dv' => 'ބަދިގެ',
				'category_code' => 'C3',
				'amount'  => 2000,
			],
			'_5cat41' => [
				'category_dv' => 'ހެދިކާ ވިއްކާ ތަންތަން',
				'category_code' => 'C4',
				'amount'  => 1000,
			],
			'_5cat42' => [
				'category_dv' => 'ޕޭސްޓްރީ ޝޮޕް/ޓޭކްއަވޭ(ބަދިގެނުލާ)',
				'category_code' => 'C4',
				'amount'  => 2000,
			],
			'_5cat43' => [
				'category_dv' => 'ޖޫސް ފަދަ ލުއިބުއިންތައް އެކަނި ވިއްކާތަންތަން',
				'category_code' => 'C4',
				'amount'  => 1000,
			],
			'_5cat51' => [
				'category_dv' => 'ކާބޯތަކެތި ބަންދުކުރާ ކުދިވިޔަފާރި ކުރާ ތަންތަން',
				'category_code' => 'C5',
				'amount'  => 500,
			],
			'_5cat61' => [
				'category_dv' => 'ކާބޯތަކެތި ބަންދުކުރާ މެދުފަންތީގެވިޔަފާރި ކުރާ ތަންތަން',
				'category_code' => 'C6',
				'amount'  => 1000,
			],
			'_5cat62' => [
				'category_dv' => 'މަގުމަތީގައި ކާނާ ވިއްކާ ތަންތަނާއި ތަކެއްޗާއި އުޅަނދުތައް',
				'category_code' => 'C6',
				'amount'  => 1000,
			],
			'_5cat71' => [
				'category_dv' => 'ވަގުތީގޮތުން ހިންގާ ފެއާރތަކާއި ކެންޓީންފަދަ ތަންތަން',
				'category_code' => 'C7',
				'amount'  => 200,
			],
			'_5cat81' => [
				'category_dv' => 'ނައަމްސޫފި ކަތިލުމުގެ ޚިދުމަތްދޭ ތަންތަން',
				'category_code' => 'C8',
				'amount'  => 0,
			],
			'_5cat91' => [
				'category_dv' => 'ދައުލަތުގެ ފަރާތުން ނުވަތަ އަމިއްލަ ޖަމާއަތަކުން ކުދިންނާއި މީހުން ބަލަހައްޓާ ތަންތަނާއި ހިލޭ ސާބަހައް ކާބޯތަކެތި ތައްޔާރުކޮށް ފޯރުކޮށްދޭ ތަންތަން',
				'category_code' => 'C9',
				'amount'  => 0,
			],
			'_5cat101' => [
				'category_dv' => 'އެހެނިހެން ތަންތަން',
				'category_code' => 'C10',
				'amount'  => 0,
			],
		];


		$details = [];

		foreach ($categories as $category => $amount) {
		 	if ($application->{$category}) {
		 		$details = $categories[$category];
		 	}
		}

    	return array_merge($details, [
    		'license_type' => $application->application_type_slug,
    		'license_no' => $this->getLicenseNumber($application),
    	]);
	}


	protected function getFoodPermitDetails($application)
	{
		$categories = [
			'_5cat11' => ['amount'  => 2000,],
			'_5cat12' => ['amount'  => 2000,],
			'_5cat13' => ['amount'  => 2000,],
			'_5cat14' => ['amount'  => 2000,],
			'_5cat15' => ['amount'  => 2000,],
			'_5cat21' => ['amount'  => 2000,],
			'_5cat31' => ['amount'  => 2000,],
			'_5cat32' => ['amount'  => 2000,],
			'_5cat33' => ['amount'  => 2000,],
			'_5cat41' => ['amount'  => 1000,],
			'_5cat42' => ['amount'  => 2000,],
			'_5cat43' => ['amount'  => 1000,],
			'_5cat51' => ['amount'  => 500,],
			'_5cat61' => ['amount'  => 1000,],
			'_5cat62' => ['amount'  => 1000,],
			'_5cat71' => ['amount'  => 200,],
			'_5cat81' => ['amount'  => 0,],
			'_5cat91' => ['amount'  => 0,],
			'_5cat101' => ['amount'  => 0,],
		];

		foreach ($categories as $category => $amount) {
		 	if ($application->{$category}) {
		 		return $categories[$category];
		 	}
		}
	}

	protected function getTobaccoPermitDetails($application)
	{
		return [ 'amount'  => 1000 ];
	}

	protected function getLicenseNumber($application)
	{
		return (new LicenseGenerator($application))->generate();
	}

	protected function getFormApplication($form)
	{
		$inspection = Inspection::findOrFail($form->normal_inspection_id);

		//for new registration/renew/tobacco
		if ($inspection->application_id) {
			return $inspection->application;
		}

		if ($inspection->business_id) {
			$business = $inspection->business;

			return $this->getBusinessApplication($business);
		}

		throw new \Exception("unable to identify the business");
		
	}

	protected function getBusinessApplication(Business $business)
	{
		if ($activeApplication = $business->activeApplication) {
			return $activeApplication;
		}

		return $business->applications()->where('_1tobaccoOrFood', '2')->orderBy('updated_at', 'desc')->first();
	}
}
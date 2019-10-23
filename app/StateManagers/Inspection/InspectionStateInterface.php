<?php
namespace App\StateManagers\Inspection;

interface InspectionStateInterface
{
	public function created(); //administrative
	public function scheduled(); //inspection level
	public function ongoing(); //fillingChecklist(); //inspection started //inspection level
	public function completed(); //checklistFilled(); //inspection level
	public function decisionMade(); //fine,termination,followup,licen - //supervisory level
	// public function paymentsClearedIfAny(); //fine,termination,followup,licen - //supervisory level

	// public function reportGenerated(); //inspection level
	// public function reportPrepared(); //inspection level
	// public function reportApproved(); //supervisory level
	// public function reportHandedOver(); //inspection level
	public function finished();
	public function closed(); //supervisory level
}

<?php
namespace App\StateManagers\Inspection\States;

use App\StateManagers\Inspection\InspectionState;

//Opened FillingChecklist for first time
class Started  extends InspectionState
{

	public function created()
	{
		echo 'trying from started -> created' . PHP_EOL;
		return false;
	}

	public function scheduled()
	{
		echo 'trying from started -> scheduled' . PHP_EOL;
		return false;
	}

	public function started()
	{
		echo 'trying from started -> started' . PHP_EOL;
		return false;
	}

	public function ongoing()
	{
		// echo 'trying from started -> ongoing' . PHP_EOL;
		return true;
	}

	public function completed()
	{
		echo 'trying from started -> completed' . PHP_EOL;
        return false;
	}

	public function decisionMade()
	{
		echo 'trying from started -> decisionMade' . PHP_EOL;
		return false;
	}

	public function finished()
	{
		echo 'trying from started -> finished' . PHP_EOL;
		return false;
	}

	public function closed()
	{
		echo 'trying from started -> closed' . PHP_EOL;
		return false;
	}
}
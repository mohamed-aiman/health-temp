<?php
namespace App\StateManagers\Inspection\States;

use App\StateManagers\Inspection\InspectionState;

class Scheduled  extends InspectionState
{
    public function created()
	{
		echo 'trying from scheduled -> created' . PHP_EOL;
		return false;
	}

	public function scheduled()
	{
		echo 'trying from scheduled -> scheduled' . PHP_EOL;
		return false;
	}

	public function started()
	{
		// echo 'trying from scheduled -> started' . PHP_EOL;
		return true;
	}

    public function ongoing()
    {
		// echo 'trying from scheduled -> ongoing' . PHP_EOL;
        return true;
    }

	public function completed()
	{
		echo 'trying from scheduled -> completed' . PHP_EOL;
		return false;
	}

	public function decisionMade()
	{
		echo 'trying from scheduled -> decisionMade' . PHP_EOL;
		return false;
	}

	public function finished()
	{
		echo 'trying from scheduled -> finished' . PHP_EOL;
		return false;
	}

	public function closed()
	{
		echo 'trying from scheduled -> closed' . PHP_EOL;
		return false;
	}
}

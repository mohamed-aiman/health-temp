<?php
namespace App\StateManagers\Inspection\States;

use App\StateManagers\Inspection\InspectionState;

class Closed  extends InspectionState
{

    public function created()
	{
		echo 'trying from closed -> created' . PHP_EOL;
		return false;
	}

	public function scheduled()
	{
		echo 'trying from closed -> scheduled' . PHP_EOL;
		return false;
	}

	public function started()
	{
		echo 'trying from closed -> started' . PHP_EOL;
		return false;
	}

    public function ongoing()
    {
		echo 'trying from closed -> ongoing' . PHP_EOL;
		return false;
    }

	public function completed()
	{
		echo 'trying from closed -> completed' . PHP_EOL;
		return false;
	}

	public function decisionMade()
	{
		echo 'trying from closed -> decisionMade' . PHP_EOL;
		return false;
	}

	public function finished()
	{
		echo 'trying from closed -> finished' . PHP_EOL;
		return false;
	}

	public function closed()
	{
		echo 'trying from closed -> closed' . PHP_EOL;
		return false;
	}
}

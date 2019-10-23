<?php
namespace App\StateManagers\Inspection\States;

use App\StateManagers\Inspection\InspectionState;

class Created extends InspectionState
{
	public function created()
	{
		echo 'trying from created -> created' . PHP_EOL;
		return false;
	}

	public function scheduled()
	{
		return true;
        // $this->context->changeState(StatesMapper::SCHEDULED);
	}

	public function started()
	{
		echo 'trying from created -> started' . PHP_EOL;
		return false;
	}

	public function ongoing()
	{
		echo 'trying from created -> ongoing' . PHP_EOL;
		return false;
	}

	public function completed()
	{
		echo 'trying from created -> completed' . PHP_EOL;
		return false;
	}

	public function decisionMade()
	{
		echo 'trying from created -> decisionMade' . PHP_EOL;
		return false;
	}

	public function finished()
	{
		echo 'trying from created -> finished' . PHP_EOL;
		return false;
	}

	public function closed()
	{
		echo 'trying from created -> closed' . PHP_EOL;
		return false;
	}
}
<?php
namespace App\StateManagers\Inspection\States;

use App\StateManagers\Inspection\InspectionState;

class DecisionMade extends InspectionState
{
	public function created()
	{
		echo 'trying from decision_made -> created' . PHP_EOL;
		return false;
	}

	public function scheduled()
	{
		echo 'trying from decision_made -> scheduled' . PHP_EOL;
		return false;
	}

	public function started()
	{
		echo 'trying from decision_made -> started' . PHP_EOL;
		return false;
	}

	public function ongoing()
	{
		echo 'trying from decision_made -> ongoing' . PHP_EOL;
		return false;
	}

	public function completed()
	{
		echo 'trying from decision_made -> completed' . PHP_EOL;
		return false;
	}

	public function decisionMade()
	{
		echo 'trying from decision_made -> decisionMade' . PHP_EOL;
		return false;
	}
	
	public function finished()
	{
        return true;
        // $this->context->changeState(StatesMapper::FINISHED);
	}

	public function closed()
	{
		echo 'trying from decision_made -> closed' . PHP_EOL;
		return false;
	}
}
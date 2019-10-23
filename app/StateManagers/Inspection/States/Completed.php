<?php
namespace App\StateManagers\Inspection\States;

use App\StateManagers\Inspection\InspectionState;

// ChecklistFilled
class Completed  extends InspectionState
{
	public function created()
	{
		echo 'trying from completed -> created' . PHP_EOL;
		return false;
	}

	public function scheduled()
	{
		echo 'trying from completed -> scheduled' . PHP_EOL;
		return false;
	}

	public function started()
	{
		echo 'trying from completed -> started' . PHP_EOL;
		return false;
	}

	public function ongoing()
	{
		// echo 'trying from completed -> ongoing' . PHP_EOL;
		return true;
	}

	public function completed()
	{
		// echo 'trying from completed -> completed' . PHP_EOL;
		return true;
	}

	public function decisionMade()
	{
        return true;
        // $this->context->changeState(StatesMapper::DECISION_MADE);
	}

	public function finished()
	{
		echo 'trying from completed -> finished' . PHP_EOL;
		return false;
	}

	public function closed()
	{
		echo 'trying from completed -> closed' . PHP_EOL;
		return false;
	}

}
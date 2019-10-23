<?php
namespace App\StateManagers\Inspection\States;

use App\StateManagers\Inspection\InspectionState;

//FillingChecklist
class Ongoing  extends InspectionState
{

	public function created()
	{
		echo 'trying from ongoing -> created' . PHP_EOL;
		return false;
	}

	public function scheduled()
	{
		echo 'trying from ongoing -> scheduled' . PHP_EOL;
		return false;
	}

	public function started()
	{
		echo 'trying from ongoing -> started' . PHP_EOL;
		return false;
	}

	public function ongoing()
	{
		// echo 'trying from ongoing -> ongoing' . PHP_EOL;
        return true;
	}

	public function completed()
	{
        return true;
        // $this->context->changeState(StatesMapper::COMPLETED);
	}

	public function decisionMade()
	{
		echo 'trying from ongoing -> decisionMade' . PHP_EOL;
		return false;
	}

	public function finished()
	{
		echo 'trying from ongoing -> finished' . PHP_EOL;
		return false;
	}

	public function closed()
	{
		echo 'trying from ongoing -> closed' . PHP_EOL;
		return false;
	}
}
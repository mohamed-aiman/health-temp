<?php
namespace App\StateManagers\Inspection\States;

use App\StateManagers\Inspection\InspectionState;

class Finished  extends InspectionState
{

    public function created()
	{
		echo 'trying from finished -> created' . PHP_EOL;
		return false;
	}

	public function scheduled()
	{
		echo 'trying from finished -> scheduled' . PHP_EOL;
		return false;
	}

	public function started()
	{
		echo 'trying from finished -> started' . PHP_EOL;
		return false;
	}

    public function ongoing()
    {
		echo 'trying from finished -> ongoing' . PHP_EOL;
		return false;
    }

	public function completed()
	{
		echo 'trying from finished -> completed' . PHP_EOL;
		return false;
	}

	public function decisionMade()
	{
		echo 'trying from finished -> decisionMade' . PHP_EOL;
		return false;
	}

	public function finished()
	{
		echo 'trying from finished -> finished' . PHP_EOL;
		return false;
	}

	public function closed()
	{
        return true;
        // $this->context->changeState(StatesMapper::CLOSED);
	}
}

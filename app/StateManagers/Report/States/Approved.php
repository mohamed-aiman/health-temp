<?php
namespace App\StateManagers\Report\States;

use App\StateManagers\Report\ReportState;
use App\StateManagers\Report\StatesMapper;

class Approved  extends ReportState
{
	public function generated()
	{
		echo 'WIP - trying from approved -> generated' . PHP_EOL;
		return false;
	}

	public function prepared()
	{
		echo 'WIP - trying from approved -> prepared' . PHP_EOL;
		return false;
	}

	public function approved()
	{
		echo 'WIP - trying from approved -> approved' . PHP_EOL;
		return false;
	}

	public function handedOver()
	{
		echo 'WIP - trying from approved -> handedOver' . PHP_EOL;
		return true;
	}

}

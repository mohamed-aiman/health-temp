<?php
namespace App\StateManagers\Report\States;

use App\StateManagers\Report\ReportState;
use App\StateManagers\Report\StatesMapper;

class Generated  extends ReportState
{
	public function generated()
	{
		echo 'WIP - trying from generated -> generated' . PHP_EOL;
		return false;
	}

	public function prepared()
	{
		echo 'WIP - trying from generated -> prepared' . PHP_EOL;
		return true;
	}

	public function approved()
	{
		echo 'WIP - trying from generated -> approved' . PHP_EOL;
		return false;
	}

	public function handedOver()
	{
		echo 'WIP - trying from generated -> handedOver' . PHP_EOL;
		return false;
	}
}

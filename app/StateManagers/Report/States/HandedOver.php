<?php
namespace App\StateManagers\Report\States;

use App\StateManagers\Report\ReportState;
use App\StateManagers\Report\StatesMapper;

class HandedOver extends ReportState
{
	public function generated()
	{
		echo 'WIP - trying from handed_over -> generated' . PHP_EOL;
		return false;
	}

	public function prepared()
	{
		echo 'WIP - trying from handed_over -> prepared' . PHP_EOL;
		return false;
	}

	public function approved()
	{
		echo 'WIP - trying from handed_over -> approved' . PHP_EOL;
		return false;
	}

	public function handedOver()
	{
		echo 'WIP - trying from handed_over -> handedOver' . PHP_EOL;
		return false;
	}
}

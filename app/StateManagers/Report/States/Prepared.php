<?php
namespace App\StateManagers\Report\States;

use App\StateManagers\Report\ReportState;
use App\StateManagers\Report\StatesMapper;

class Prepared  extends ReportState
{
	public function generated()
	{
		echo 'WIP - trying from prepared -> generated' . PHP_EOL;
		return false;
	}

	public function prepared()
	{
		echo 'WIP - trying from prepared -> prepared' . PHP_EOL;
		return false;
	}

	public function approved()
	{
		echo 'WIP - trying from prepared -> approved' . PHP_EOL;
		return true;
	}

	public function handedOver()
	{
		echo 'WIP - trying from prepared -> handedOver' . PHP_EOL;
		return false;
	}
}

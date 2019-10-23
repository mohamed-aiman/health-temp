<?php
namespace App\StateManagers\Inspection;

use App\StateManagers\Inspection\InspectionStateInterface;
use App\StateManagers\State;

abstract class InspectionState extends State implements InspectionStateInterface
{
	public function created()
	{
		echo "Need to override " . get_class($this) . " -> created method" . PHP_EOL;
		return false;
	}

	public function scheduled()
	{
		echo "Need to override " . get_class($this) . " -> scheduled method" . PHP_EOL;
		return false;
	}

	public function started()
	{
		echo "Need to override " . get_class($this) . " -> started method" . PHP_EOL;
		return false;
	}

	public function ongoing()
	{
		echo "Need to override " . get_class($this) . " -> ongoing method" . PHP_EOL;
		return false;
	}

	public function completed()
	{
		echo "Need to override " . get_class($this) . " -> completed method" . PHP_EOL;
		return false;
	}

	public function decisionMade()
	{
		echo "Need to override " . get_class($this) . " -> decisionMade method" . PHP_EOL;
		return false;
	}

	public function finished()
	{
		echo "Need to override " . get_class($this) . " -> finished method" . PHP_EOL;
		return false;
	}

	public function closed()
	{
		echo "Need to override " . get_class($this) . " -> closed method" . PHP_EOL;
		return false;
	}
}

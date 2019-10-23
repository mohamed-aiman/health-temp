<?php
namespace App\StateManagers\Report;

// use App\Report;
use App\StateManagers\Context;
use App\StateManagers\Report\StatesMapper;

class ReportContext extends Context
{
	public function generated()
	{
		return $this->state->generated() ? $this->changeState(StatesMapper::GENERATED) : false;
	}

	public function prepared()
	{
		return $this->state->prepared() ? $this->changeState(StatesMapper::PREPARED) : false;
	}

	public function approved()
	{
		return $this->state->approved() ? $this->changeState(StatesMapper::APPROVED) : false;
	}

	public function handedOver()
	{
		return $this->state->handedOver() ? $this->changeState(StatesMapper::HANDED_OVER) : false;
	}

	public function setMapper()
	{
		$this->mapper = new StatesMapper();
	}

	// public function setState($model)
	// {
	// 	$this->state = StatesMapper::getMappedClassObject($model->state, $this);
	// }
	
	// public function changeState(string $state)
	// {
	// 	echo 'STATE CHANGED TO:' . $state . PHP_EOL;

	// 	StatesMapper::checkStateExistance($state);

	// 	if ($model = tap($this->model)->update([
	// 		'state' => $state
	// 	])) {
	// 		$this->setState($model);
	// 		return $model;
	// 	}

	// 	return false;

	// }
}
<?php
namespace App\StateManagers\Inspection;

use App\Inspection;
use App\StateManagers\Context;
use App\StateManagers\Inspection\StatesMapper;
use Illuminate\Support\Str;

class InspectionContext extends Context
{
	public function created()
	{
		return $this->state->created() ? $this->changeState(StatesMapper::CREATED) : false;
	}

	public function scheduled()
	{
		return $this->state->scheduled() ? $this->changeState(StatesMapper::SCHEDULED) : false;
	}

	public function started()
	{
		return $this->state->started() ? $this->changeState(StatesMapper::STARTED) : false;
	}

	public function ongoing()
	{
		return $this->state->ongoing() ? $this->changeState(StatesMapper::ONGOING) : false;
	}

	public function completed()
	{
		return $this->state->completed() ? $this->changeState(StatesMapper::COMPLETED) : false;
	}

	public function decisionMade()
	{
		return $this->state->decisionMade() ? $this->changeState(StatesMapper::DECISION_MADE) : false;
	}

	public function finished()
	{
		return $this->state->finished() ? $this->changeState(StatesMapper::FINISHED) : false;
	}

	public function closed()
	{
		return $this->state->closed() ? $this->changeState(StatesMapper::CLOSED) : false;
	}

	public function setMapper()
	{
		$this->mapper = new StatesMapper();
	}
	
	// public function setState($model)
	// {
	// 	echo 'Current State:' . $model->state . PHP_EOL;
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

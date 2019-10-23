<?php
namespace App\StateManagers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


abstract class Context
{
	protected $model = null;

	protected $state = null;

	protected $mapper;


	public function __construct(Model $model)
	{
		$this->model = $model;
		$this->setMapper();
		$this->setState($model);
	}

	public function getModel()
	{
		return $this->model;
	}

	public function canChangeTo($state)
	{
		return call_user_func(array($this->state, Str::studly($state)));
	}
	
	/**
	 * initial state
	 * @param [type] $model [description]
	 */
	// abstract function setState($model);
	// $this->state = StatesMapper::getMappedClassObject($model->state, $this);
	
	abstract function setMapper();

	// abstract function changeState(string $state);

	public function setState($model)
	{
		// echo 'Current State:' . $model->state . PHP_EOL;
		$this->state = $this->mapper->getMappedClassObject($model->state, $this);
	}


	public function changeState(string $state)
	{
		// echo 'STATE CHANGED TO:' . $state . PHP_EOL;

		$this->mapper->checkStateExistance($state);

		if ($model = tap($this->model)->update([
			'state' => $state
		])) {
			$this->setState($model);
			$this->log($state, $model);
			return $model;
		}

		return false;

	}

	public function log($state, $model = null)
	{
		$model = ($model) ? $model : $this->model;

        activity()
            ->performedOn($model)
            ->causedBy(request()->user())
            ->withProperties($model->toArray())
            ->log('state changed to ' . $state);
	}
}
<?php
namespace App\StateManagers;

abstract class State
{
	public function __construct(Context $context)
	{
		$this->context = $context;
	}
}
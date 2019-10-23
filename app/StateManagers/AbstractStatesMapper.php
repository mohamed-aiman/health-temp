<?php
namespace App\StateManagers;

use Exception;

abstract class AbstractStatesMapper
{
	const STATE_MAPPINGS = [];
	
	public static function getMappedClassObject($state, $context)
	{
		$class = static::STATE_MAPPINGS[$state];

		return new $class($context);
	}

	public static function checkStateExistance($state)
	{
		if (!in_array($state, array_keys(static::STATE_MAPPINGS))) {
			throw new Exception("State: {$state} does not exist.");
		}
	}

}

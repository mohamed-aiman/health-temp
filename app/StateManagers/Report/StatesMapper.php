<?php
namespace App\StateManagers\Report;

use App\StateManagers\AbstractStatesMapper;
use App\StateManagers\Report\States\Approved;
use App\StateManagers\Report\States\Generated;
use App\StateManagers\Report\States\HandedOver;
use App\StateManagers\Report\States\Prepared;
use Exception;

class StatesMapper extends AbstractStatesMapper
{
	const GENERATED = 'generated';
	const PREPARED = 'prepared';
	const APPROVED = 'approved';
	const HANDED_OVER = 'handed_over';

	const STATE_MAPPINGS = [
		'generated' => Generated::class,
		'prepared' => Prepared::class,
		'approved' => Approved::class,
		'handed_over' => HandedOver::class,
	];
}

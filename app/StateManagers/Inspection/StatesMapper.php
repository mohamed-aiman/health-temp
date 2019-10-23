<?php
namespace App\StateManagers\Inspection;

use App\StateManagers\AbstractStatesMapper;
use App\StateManagers\Inspection\States\Closed;
use App\StateManagers\Inspection\States\Completed;
use App\StateManagers\Inspection\States\Created;
use App\StateManagers\Inspection\States\DecisionMade;
use App\StateManagers\Inspection\States\Finished;
use App\StateManagers\Inspection\States\Ongoing;
use App\StateManagers\Inspection\States\Scheduled;
use App\StateManagers\Inspection\States\Started;
use Exception;

class StatesMapper extends AbstractStatesMapper
{
	const CREATED = 'created';
	const SCHEDULED = 'scheduled';
	const STARTED = 'started';
	const ONGOING = 'ongoing';
	const COMPLETED = 'completed';
	const DECISION_MADE = 'decision_made';
	const FINISHED = 'finished';
	const CLOSED = 'closed';

	const STATE_MAPPINGS = [
		'created' => Created::class,
		'scheduled' => Scheduled::class,
		'started' => Started::class,
		'ongoing' => Ongoing::class,
		'completed' => Completed::class,
		'decision_made' => DecisionMade::class,
		'finished' => Finished::class,
		'closed'   => Closed::class
	];
}

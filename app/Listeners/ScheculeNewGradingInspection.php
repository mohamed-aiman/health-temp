<?php

namespace App\Listeners;

use App\Events\NewBusinessRegistered;
use App\Inspection;
use App\License;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ScheculeNewGradingInspection
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Inspection $gradingInspection)
    {
        $this->gradingInspection = $gradingInspection;
    }

    /**
     * Handle the event.
     *
     * @param  NewBusinessRegistered  $event
     * @return void
     */
    public function handle(NewBusinessRegistered $event)
    {
        $this->scheduleGradingInspection($event->license);
    }

    protected function scheduleGradingInspection($license)
    {
        $business = $license->business;
        if ($gradingInspection = $this->gradingInspection->create([
            'business_id' => $license->business_id,
            'application_id' => null,
            'inspection_at' => self::calculateScheduleTime($license),
            'status' => 'created',
            'state' => 'created',
            'normal_form_id' => null,
            'follow_up_id' => null,
            'reason' => 'Routine',
            'is_graded' => true,
        ])) {
            activity()
                ->performedOn($gradingInspection)
                ->causedBy(request()->user())
                ->withProperties(
                    array_merge(['license_id' => $license->id], $gradingInspection->toArray())
                )
                ->log('created a new grading inspection for new food permit');
        }
    }

    public static function calculateScheduleTime(License $license)
    {
        return $license->issued_at->addMonths(6);
    }
}

<?php

namespace App\Http\Controllers;

use App\Application;
use App\Inspection;
use App\User;
use Illuminate\Http\Request;

class ApplicationInspectionController extends Controller
{
    public function __construct(Application $application, Inspection $inspection)
    {
        $this->application = $application;
    	$this->inspection = $inspection;
    }


    public function store(Request $request, Application $application)
    {
        if ($application->status != 'pending') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => ['application should be in pending state.'],
            ]);
        }

        if ($request->inspector_id && !User::isInspector($request->inspector_id )) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => ['only users with inspector role can be assigned.'],
            ]);
        }

        if (!$inspection = $this->inspection->where('application_id', '=', $application->id)->first()) {
            if ($inspection = $this->inspection->create([
                'business_id' => $application->business_id,
                'application_id' => $application->id,
                //if food set application type(register or renew)
                'type' => ($application->_1tobaccoOrFood == "2") ? $application->_1applicationType : null,
                'inspection_at' => $request->inspection_at,
                'status' => 'created',
                'state' => 'created',
                'inspector_id' => $request->inspector_id ? $request->inspector_id : null,
            ])) {
                activity()
                    ->performedOn($inspection)
                    ->causedBy($request->user())
                    ->withProperties(array_merge(
                    ['application_id' => $application->id],
                    $inspection->toArray()
                    ))->log('inspection created for the application');
            }


        } else {
            return response()->json([
                'message' => 'There is an existing inspection scheduled for the application'
            ], 422);
        }

        return $this->application->with(['inspections' => function($q) use ($application) {
            $q->where('inspections.application_id', $application->id);
        }, 'business' ])->findOrFail($application->id);
    }
}

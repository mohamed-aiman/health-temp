<?php

namespace App\Http\Controllers;

use App\Application;
use App\Business;
use Illuminate\Http\Request;

class ApplicationBusinessController extends Controller
{
    public function __construct(Application $application, Business $business)
    {
        $this->application = $application;
    	$this->business = $business;
    }

    
    public function store(Request $request, Application $application)
    {
        if ($application->status != 'draft') {
            return $this->notEditableResponse();
        }
        
        $messages = [
            'name.required'    => 'The english name field is required'
        ];

        $rules = [
            "name" => 'required',
            "name_dv" => 'required',
            "phone" => 'required|numeric',
            "registration_no" => 'required|unique:businesses,registration_no'
        ];

        validator($request->all(), $rules, $messages)->validate();

        if ($application->business_id == null) {
            if ($business = $this->business->create([
                "name" => $request->name,
                "name_dv" => $request->name_dv,
                "phone" => $request->phone,
                "registration_no" => $request->registration_no,
            ])) {
                $application->business_id = $business->id;
                if ($application->save()) {
                    activity()
                       ->performedOn($business)
                       ->causedBy($request->user())
                       ->withProperties(array_merge(
                        ['application_id' => $application->id, 'application_business_id' => $business->id],
                        $business->toArray()
                        )
                        )->log('application business created and attached');
                }
        
            }

        } 


        $application = $application->with(['business', 'inspections'])->findOrFail($application->id);

        return response()->json($application->toArray(), 201);
    }

    public function detach(Request $request, Application $application)
    {
        if ($application->status != 'draft') {
            return $this->notEditableResponse();
        }

        \DB::transaction(function () use ($request, $application){

            activity()
               ->performedOn($application)
               ->causedBy($request->user())
               ->withProperties(['business_id' => $application->business_id])
                ->log('business detached from application');

            $application->business_id = null;
            if ($application->save()) {

            }

            if ($business = $application->business) {
                $business->active_application_id = ($application->id) ? null : $business->active_application_id;
                $business->save();
            }

        });

        return $application->with(['business', 'inspections'])->findOrFail($application->id);
    }

    public function attach(Request $request, Application $application, $business)
    {
        if ($application->status != 'draft') {
            return $this->notEditableResponse();
        }

        \DB::transaction(function () use ($request, $application, $business){
            activity()
               ->performedOn($application)
               ->causedBy($request->user())
               ->withProperties(['business_id' => $business])
               ->log('business attached to application');

            $application->business_id = $business;
            $application->save();

            $business = $application->business;
            $business->active_application_id = $application->id;
            $business->save();
        });

        return $application->with(['business', 'inspections'])->findOrFail($application->id);
    }

    protected function notEditableResponse()
    {
        return response()->json([
            'message' => 'application should be in draft state.'
        ], 422);
    }
}

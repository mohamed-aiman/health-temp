<?php

namespace App\Http\Controllers;

use App\Business;
use App\Inspection;
use Illuminate\Http\Request;

class BusinessInspectionController extends Controller
{
    public function __construct(Business $business, Inspection $inspection)
    {
        $this->business = $business;
    	$this->inspection = $inspection;
    }

    
    public function store(Request $request, Business $business)
    {
        if ($request->reason == 'Complaint' && !$request->complaint_id) {
            throw \Illuminate\Validation\ValidationException::withMessages([
               'message' => ['complaint type inspections can only be created for a specific complaint!'],
            ]);
        }

        if ($inspection = $this->inspection->create([
            'business_id' => $business->id,
            'inspection_at' => $request->inspection_at,
            'reason' => $request->reason,
            'remarks' => $request->remarks,
            'status' => 'scheduled',
            'state' => 'scheduled',
            'complaint_id' => ($request->complaint_id) ? $business->complaints()->findOrFail($request->complaint_id)->id : null,
        ])) {
            activity()
                ->performedOn($inspection)
                ->causedBy($request->user())
                ->withProperties(array_merge(
                ['business_id' => $business->id],
                $inspection->toArray()
                ))->log('created an inspection for the business');    
        }

        return $this->business->with(['inspections' => function($q) use ($business) {
            $q->where('inspections.business_id', $business->id);
        }])->findOrFail($business->id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Business;
use App\Complaint;
use Illuminate\Http\Request;

class BusinessComplaintController extends Controller
{
    public function __construct(Business $business, Complaint $complaint)
    {
        $this->business = $business;
    	$this->complaint = $complaint;
    }

    
    public function store(Request $request, Business $business)
    {
        if ($complaint = $this->complaint->create([
            'business_id' => $business->id,
            'complaint_at' => $request->complaint_at,
            'summary' => $request->summary,
            'reference' => $request->reference
        ])) {
            activity()
                ->performedOn($complaint)
                ->causedBy($request->user())
                ->withProperties(array_merge(
                ['business_id' => $business->id],
                $complaint->toArray()
                ))->log('created an complaint for the business');    
        }

        return $this->business->with([
            'inspections' => function($q) use ($business) {
                $q->where('inspections.business_id', $business->id);
            },
            'complaints' => function($q) use ($business) {
                $q->where('complaints.business_id', $business->id);
            },
        ])->findOrFail($business->id);
    }
}

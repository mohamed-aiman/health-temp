<?php

namespace App\Http\Controllers;

use App\Inspection;
use Illuminate\Http\Request;

class InspectionFollowupInspectionsController extends Controller
{
    public function __construct(Inspection $inspection)
    {
    	$this->inspection = $inspection;
    }

    
    public function store(Request $request, Inspection $inspection)
    {
        if ($inspection->follow_up_id != null) {
            return response()->json([
                'message' => 'there is an existing followup inspection for this inspection'
            ], 422);
        }

        $request->validate([
            'inspection_at' => 'required'
        ]);

        \DB::transaction(function() use ($inspection, $request) {
            $followUpInspection = $this->inspection->create([
                'business_id' => $inspection->business_id,
                'application_id' => $inspection->application_id,
                'inspection_at' => $request->inspection_at,
                'reason' => $request->reason,
                'remarks' => $request->remarks,
                'followed_to_id' => $inspection->id,
                'status' => 'scheduled',
            ]);

            $inspection->follow_up_id = $followUpInspection->id;
            if ($inspection->save()) {
                activity()
                   ->performedOn($followUpInspection)
                   ->causedBy($request->user())
                   ->withProperties(array_merge(
                    ['inspection_id' => $inspection->id],
                    $followUpInspection->toArray()
                    )
                    )->log('followup inspection created for the inspection');
            }

            return $followUpInspection;
        });
    }

    public function destroy(Request $request, Inspection $inspection)
    {
        $followUpInspection = $this->inspection->findOrFail($inspection->follow_up_id);
        if ($this->isEditable($followUpInspection)) {
            \DB::transaction(function() use ($inspection, $followUpInspection, $request) {
                    $inspection->follow_up_id = null;
                    $inspection->save();
                    $logModel = $followUpInspection;
                    if ($followUpInspection->delete()) {
                        activity()
                           ->performedOn($logModel)
                           ->causedBy($request->user())
                           ->withProperties(['inspection_id' => $inspection->id])
                           ->log('followup inspection detached from inspection and deleted followup inspection');
                    }
            });
        }
        else {
            return $this->notEditableErrorResponse();
        }
    }

    protected function isEditable($inspection)
    {
        return ($inspection->normal_form_id == null) ? true : false;
    }

    protected function notEditableErrorResponse()
    {
        return response()->json([
            'message' => 'unable to delete. inspection has inspection form attached to it. detach it first.'
        ], 422);
    }
}

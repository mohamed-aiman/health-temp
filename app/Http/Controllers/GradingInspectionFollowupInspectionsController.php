<?php

namespace App\Http\Controllers;

use App\GradingInspection;
use Illuminate\Http\Request;

class GradingInspectionFollowupInspectionsController extends Controller
{
    public function __construct(GradingInspection $inspection)
    {
    	$this->inspection = $inspection;
    }

    
    public function store(Request $request, GradingInspection $inspection)
    {
        if ($inspection->follow_up_id != null) {
            return response()->json([
                'message' => 'there is an existing followup inspection for this inspection'
            ], 422);
        }

        \DB::transaction(function() use ($inspection, $request) {
            $followUpGradingInspection = $this->inspection->create([
                'business_id' => $inspection->business_id,
                'application_id' => $inspection->application_id,
                'inspection_at' => $request->inspection_at,
                // 'followed_to_id' => $inspection->id,
                'status' => 'scheduled',
            ]);

            $inspection->follow_up_id = $followUpGradingInspection->id;
            if ($inspection->save()) {
                activity()
                   ->performedOn($followUpGradingInspection)
                   ->causedBy($request->user())
                   ->withProperties(array_merge(
                    ['grading_inspection_id' => $inspection->id],
                    $followUpGradingInspection->toArray()
                    )
                    )->log('followup grading inspection created for the inspection');
            }

            return $followUpGradingInspection;
        });
    }

    public function destroy(Request $request, GradingInspection $inspection)
    {
        $followUpGradingInspection = $this->inspection->findOrFail($inspection->follow_up_id);
        if ($this->isEditable($followUpGradingInspection)) {
            \DB::transaction(function() use ($inspection, $followUpGradingInspection, $request) {
                    $inspection->follow_up_id = null;
                    $inspection->save();
                    $logModel = $followUpGradingInspection;
                    if ($followUpGradingInspection->delete()) {
                        activity()
                           ->performedOn($logModel)
                           ->causedBy($request->user())
                           ->withProperties(['grading_inspection_id' => $inspection->id])
                           ->log('followup inspection detached from grading inspection and deleted followup inspection');
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

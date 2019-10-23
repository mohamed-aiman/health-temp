<?php

namespace App\Http\Controllers;

use App\GradingForm;
use Illuminate\Http\Request;

class GradingFormController extends Controller
{
    public function __construct(GradingForm $gradingForm)
    {
        $this->gradingForm = $gradingForm;
    }

    public function getGradingsCalculated(GradingForm $gradingForm)
    {
        return \App\Helpers\GradingCalculator::calculate($gradingForm);
    }


    public function showApi(GradingForm $gradingForm)
    {
        return $gradingForm->load('gradingInspection');
    }

    public function updateApi(Request $request, GradingForm $gradingForm)
    {
        $data = $request->validate([
			"place_name" => '',
			"food_registration_no" => '',
			"owner" => '',
			"inspection_date" => '',
			"permit_limit" => '',
			"phone" => '',
			"reason" => '',
			"information_provider" => '',
        ]);

        $gradingForm->fill($data);

        if ($gradingForm->isDirty()) {
            if ($gradingForm->save()) {
                $gradingForm = $gradingForm->fresh();
                activity()
                   ->performedOn($gradingForm)
                   ->causedBy($request->user())
                   ->withProperties($gradingForm->toArray())
                   ->log('updated grading form');
            }
        }

        return $gradingForm;
    }

    public function sendForProcessing(Request $request, GradingForm $gradingForm)
    {
        $previousStatus = $gradingForm->status;
        if($gradingForm->status == 'draft') {
            $gradingForm->status = 'pending';
            if ($gradingForm->save()) {
                $gradingForm = $gradingForm->fresh();
                activity()
                   ->performedOn($gradingForm)
                   ->causedBy($request->user())
                   ->withProperties(['previous_status' => $previousStatus, 'status' => $gradingForm->status])
                   ->log('grading form sent for processing');
            }
        } else {
            return $this->notEditableResponse();
        }
        

        return $gradingForm;
    }

    public function pendingApi(Request $request)
    {
        $gradingForms = $this->gradingForm
        ->where('status', '=' , 'pending');

        return $gradingForms->orderBy('updated_at', 'desc')->paginate();
    }

    protected function changedStatusToProcessed(Request $request, GradingForm $gradingForm)
    {
        $previousStatus = $gradingForm->status;
        if ($gradingForm->status == 'pending') {
            $gradingForm->status = 'processed';
            if ($gradingForm->save()) {
                $gradingForm = $gradingForm->fresh();
                activity()
                   ->performedOn($gradingForm)
                   ->causedBy($request->user())
                   ->withProperties(['previous_status' => $previousStatus, 'status' => $gradingForm->status])
                   ->log('grading form processed');
            }
        } else {
            return $this->notProcessibleResponse();
        }
    }

    public function sendBackToEditing(Request $request, GradingForm $gradingForm)
    {
        $previousStatus = $gradingForm->status;
        if($gradingForm->status == 'pending') {
            $gradingForm->status = 'draft';
            if ($gradingForm->save()) {
                $gradingForm = $gradingForm->fresh();
                activity()
                   ->performedOn($gradingForm)
                   ->causedBy($request->user())
                   ->withProperties(['previous_status' => $previousStatus, 'status' => $gradingForm->status])
                   ->log('grading form sent back to editing');
            }
        } else {
            return $this->notProcessibleResponse();
        }
        
        return $gradingForm;
    }

    protected function notProcessibleResponse()
    {
        return response()->json([
            'message' => 'form should be in pending state.'
        ], 422);
    }


    protected function notEditableResponse()
    {
        return response()->json([
            'message' => 'form should be in draft state.'
        ], 422);
    }
}

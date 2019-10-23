<?php

namespace App\Http\Controllers;

use App\Inspection;
use App\StateManagers\Inspection\InspectionContext;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function __construct(Inspection $inspection)
    {
        $this->inspection = $inspection;
    }

    public function my(Request $request)
    {
        $inspections = $this->inspection->where('inspector_id', auth()->user()->id);

        if ($request->registrationNo || $request->placeNameDv) {
            $inspections = $this->inspection->whereHas('business', function($business) use ($request) {
                if ($request->registrationNo) {
                    $business = $business->where('registration_no', 'LIKE', "%$request->registrationNo%");
                }

                if ($request->placeNameDv) {
                    $business = $business->where('name_dv', 'LIKE', "%$request->placeNameDv%");
                }

                return $business;
            });
        }

        $inspections = $inspections->with('business','inspector');


        $inspections = $this->basicFilters($inspections, $request);

        return $inspections->orderBy('updated_at', 'desc')->paginate();

    }

    public function indexApi(Request $request)
    {
        $inspections = $this->inspection;

        if ($request->registrationNo || $request->placeNameDv) {
            $inspections = $this->inspection->whereHas('business', function($business) use ($request) {
                if ($request->registrationNo) {
                    $business = $business->where('registration_no', 'LIKE', "%$request->registrationNo%");
                }

                if ($request->placeNameDv) {
                    $business = $business->where('name_dv', 'LIKE', "%$request->placeNameDv%");
                }

                return $business;
            });
        }

        $inspections = $inspections->with('business','inspector');


        $inspections = $this->basicFilters($inspections, $request);

        return $inspections->orderBy('updated_at', 'desc')->paginate();

    }

    protected function basicFilters($inspections, $request)
    {
        if ($request->inspectionId && $request->inspectionId != "") {
            $inspections  = $inspections->where('id', '=', $request->inspectionId);
        }

        if ($request->applicationId && $request->applicationId != "") {
            $inspections  = $inspections->where('application_id', '=', $request->applicationId);
        }

        if ($request->state && $request->state != "") {
            $inspections  = $inspections->where('state', '=', $request->state);
        }

        if ($request->inspectionAt && $request->inspectionAt != "") {
            $inspections  = $inspections->whereDate('inspection_at', '=', $request->inspectionAt);
        }

        if ($request->inspectorId && $request->inspectorId != "") {
            if ($request->inspectorId == 'unassigned') {
                $inspections  = $inspections->whereNull('inspector_id');
            } else {
                $inspections  = $inspections->where('inspector_id', '=', $request->inspectorId);
            }

        }

        return $inspections;
    }


    public function upcomingApi(Request $request)
    {
        $query = $this->inspection->with('business', 'inspector')
            // ->where('inspection_at', '>=', Carbon::now())
            ->whereIn('state', ['scheduled']);

        if ($request->month) {
            $query = $query->where('inspection_at', '<=', Carbon::now()->addMonths($request->month));
        }

        return $query->orderBy('inspection_at', 'asc')->paginate();
    }

    public function showApi($inspection)
    {
        return $this->inspection->with([
            'englishReport',
            'dhivehiReport',
            'business',
            'fines.fineType',
            'complaint',
            'application',
            'application.license',
            'followUpInspection',
            'termination',
            'normalForm',
            'inspector',
            // 'followUpInspectionOf',
        ])->findOrFail($inspection);
    }

    // public function reschedule(Request $request, Inspection $inspection)
    // {
    //     if ($inspection->state != 'scheduled') {
    //         return $this->update($request, $inspection);
    //     }

    //     return $inspection;
    // }


    public function update(Request $request, Inspection $inspection)
    {
        $data = [
            // 'reason' => $request->reason,
            'remarks' => $request->remarks,
            'inspection_at' => $request->inspection_at,
        ];

        if ($request->inspector_id && ($request->inspector_id != $inspection->inspector_id)) {
            $data['inspector_id'] = $this->getInspectorId($request, $inspection);
        }

        if ($request->state && ($request->state != $inspection->state)) {
            $data['state'] = $this->getState($request, $inspection);
        }

        if ($this->isEditable($inspection)) {
            $inspection->fill($data);

            if ($inspection->isDirty()) {
                if ($inspection->save()) {
                    $inspection = $inspection->fresh();
                    activity()
                       ->performedOn($inspection)
                       ->causedBy($request->user())
                       ->withProperties($inspection->toArray())
                       ->log('updated inspection');
                }
            }

            return $inspection;
        } else {
            return $this->notEditableErrorResponse('is not editable. inspection has inspection form attached to it. detach it first.');
        }
        // return $this->inspection->with('business')->findOrFail($inspection->id);
    }

    protected function getState(Request $request, Inspection $inspection)
    {
        if (in_array($request->state, ['created', 'scheduled'])) {
            return $request->state;
        }

        return $inspection->state;
    }

    protected function getInspectorId(Request $request, Inspection $inspection)
    {
        if ($request->inspector_id == 'unassigned') {
            return null;
        }

        if ($inspector = User::isInspector($request->inspector_id)) {
            return $inspector->id;
        }

        return $inspection->inspector_id;
    }

    public function updateFined(Request $request, Inspection $inspection)
    {
        // $inspection->report_handed_over_at = $request->
        $inspection->is_fined = filter_var($request->fined, FILTER_VALIDATE_BOOLEAN);

        if(!$inspection->save()) {
            throw new \Exception("Error Saving fined: ");
        } else {
            $inspection = $inspection->fresh();
            activity()
               ->performedOn($inspection)
               ->causedBy($request->user())
               ->withProperties(['is_fined' => $inspection->is_fined])
               ->log('updated inspection is fined');
        }
        return $inspection;
    }

    public function updateFollowup(Request $request, Inspection $inspection)
    {
        $inspection->is_followup_required = filter_var($request->followup, FILTER_VALIDATE_BOOLEAN);
        if(!$inspection->save()) {
            throw new \Exception("Error Saving followup required: ");
        } else {
            $inspection = $inspection->fresh();
            activity()
               ->performedOn($inspection)
               ->causedBy($request->user())
               ->withProperties(['is_fined' => $inspection->is_followup_required])
               ->log('updated inspection is followup required');
        }
        return $inspection;
    }

    /**
     * handover and undo handover
     */
    public function handOverReports(Request $request, Inspection $inspection)
    {
        $inspection->report_handed_over_at = $request->report_handed_over_at;
        if ($inspection->save()) {
            activity()
               ->performedOn($inspection)
               ->causedBy($request->user())
               ->withProperties(['report_handed_over_at' => $inspection->report_handed_over_at])
               ->log('handover reports');
        }

        //create followup inspection if report has is_folllowup reuired
        if ($inspection->report_handed_over_at) {
            if ($inspection->is_followup_required) {
                $this->deleteFollowupInspections($inspection, $request);
                if ($newFollowupInspection = $this->inspection->create([
                    'business_id' => $inspection->business_id,
                    'application_id' => $inspection->application_id,
                    'inspection_at' => $inspection->inspection_at->addDays(5),
                    'type' => $inspection->type,
                    'is_fined' => false,
                    'is_followup_required' => false,
                    'report_handed_over_at' => null,
                    'status' => 'scheduled',
                    'dhivehi_report_id' => null,
                    'english_report_id' => null,
                    'follow_up_id' => null,
                ])) {
                    activity()
                       ->performedOn($newFollowupInspection)
                       ->causedBy($request->user())
                       ->withProperties(
                        array_merge(['inspection_id' => $inspection->id], $newFollowupInspection->toArray())
                        )->log('followup inspection created while reports were handed over');
                }

                $inspection->follow_up_id = $newFollowupInspection->id;
                if ($inspection->save()) {
                    activity()
                       ->performedOn($inspection)
                       ->causedBy($request->user())
                       ->withProperties(['inspection_id' => $inspection->id, 'follow_up_id' => $newFollowupInspection->id])
                       ->log('followup inspection attached to the inspection');
                }
            }
        } else {
            $this->deleteFollowupInspections($inspection, $request);
        }
    }

    protected function deleteFollowupInspections($parent, $request)
    {
        DB::beginTransaction();
        try {
            $followUpId = $parent->follow_up_id;
            $parent->follow_up_id = null;
            if ($parent->save()) {
                activity()
                   ->performedOn($parent)
                   ->causedBy($request->user())
                   ->withProperties(['inspection_id' => $parent->id, 'follow_up_id' => $followUpId])
                   ->log('followup inspection detached from inspection. followup inspection deleted');
            }
            $this->inspection->where('id', $followUpId)->delete();
        } catch (\Exception $e) {
                DB::rollBack();
        }
        DB::commit();
    }


    public function close(Request $request, Inspection $inspection)
    {
        $previousStatus = $inspection->status;
        $inspection->status = 'finished';
        if ($inspection->save()) {
            activity()
               ->performedOn($inspection)
               ->causedBy($request->user())
                ->withProperties(['previous_status' => $previousStatus, 'status' => 'finished'])
               ->log('inspection closed');
        }
    }

    public function destroy(Request $request, Inspection $inspection)
    {
        $logModel = $inspection;
        // \DB::transaction(function() use ($inspection) {
            if ($this->isEditable($inspection)) {
                $this->deleteFollowupInspections($inspection, $request);
                // $this->detachFromFollowedInspection($inspection);
                if ($inspection->delete()) {
                    activity()
                       ->performedOn($logModel)
                       ->causedBy($request->user())
                       ->log('deleted inspection');
                }
            } else {
                return $this->notEditableErrorResponse();
            }
        // });
    }

    protected function isEditable($inspection)
    {
        return ($inspection->normal_form_id == null) ? true : false;
    }

    protected function notEditableErrorResponse($message = null)
    {
        if (!$message) {
            $message = 'unable to delete. inspection has inspection form attached to it. detach it first.';
        }

        return response()->json([
            'message' => $message
        ], 422);
    }

    public function changedStatusToOngoing(Request $request, Inspection $inspection)
    {
        check_is_inspector($inspection);

        with(new InspectionContext($inspection))->ongoing();
    }

    public function decisionMade(Request $request, Inspection $inspection)
    {
        if ($inspection = with(new InspectionContext($inspection))->decisionMade()) {
            return $inspection;
        }
    }

    public function uploadGradingCertificate(Request $request, Inspection $inspection)
    {
        if ($path = $request->file('image')->store('/inspections/grading-certificates')) {
            $inspection->grading_certificate_path = $path;
            if ($inspection->save()) {
                $inspection = $inspection->fresh();
                activity()
                    ->performedOn($inspection)
                    ->causedBy($request->user())
                    ->withProperties(['grading_certificate_path' => $inspection->grading_certificate_path])
                    ->log('uploaded inspection grading certificate');
            }
            
            return $inspection;
        }

        return response()->json([
            'message' => 'unable to upload the file'
        ], 400);
    }

    public function viewGradingCertificate(Inspection $inspection)
    {
        $filePath = storage_path('/app//'. $inspection->grading_certificate_path);
        return $this->getImage($filePath);
    }
}

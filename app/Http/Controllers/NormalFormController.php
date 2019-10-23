<?php

namespace App\Http\Controllers;

use App\Inspection;
use App\NormalForm;
use App\StateManagers\Inspection\InspectionContext;
use Illuminate\Http\Request;
use DB;
use Exception;

class NormalFormController extends Controller
{
    public function __construct(NormalForm $normalForm)
    {
        $this->normalForm = $normalForm;
    }

    public function getGradingsCalculated(NormalForm $normalForm)
    {
        return \App\Helpers\GradingCalculator::calculate($normalForm);
    }

    public function showApi(NormalForm $normalForm)
    {
        return $normalForm->load('normalInspection');
    }

    public function updateApi(Request $request, NormalForm $normalForm)
    {
        check_is_inspector($normalForm->inspection);

        if (!$this->isEditable($normalForm)) {
            return $this->notEditableResponse();
        }

        $data = $request->validate([
            'reason' => '',
            'applied_for' => '',
            'applied_date' => '',
            'place_name_address' => '',
            'registration_no' => '',
            'place_owner_name_address' => '',
            'permit_expiry_date' => '',
            'phone' => 'numeric',
            'chair_count' => 'numeric',
            'serving_area_count' => 'numeric',
            'info_provider_name_no' => '',
            'kitchen_count' => 'numeric',
            'inspected_at' => '',
        ]);

        $normalForm->fill($data);

        if ($normalForm->isDirty()) {
            if ($normalForm->save()) {
                activity()
                    ->performedOn($normalForm)
                    ->causedBy($request->user())
                    ->withProperties($normalForm->toArray())
                    ->log('updated a normal form');
            }
        }

        return $normalForm;
    }

    /**
     * for level 2 users
     */
    public function sendForProcessing(Request $request, NormalForm $normalForm)
    {
        check_is_inspector($normalForm->inspection);

        $previousStatus = $normalForm->status;
        if($normalForm->status == 'draft') {
            $normalForm->status = 'pending';
            if ($normalForm->save()) {
                $normalForm = $normalForm->fresh();
                activity()
                   ->performedOn($normalForm)
                   ->causedBy($request->user())
                   ->withProperties(['previous_status' => $previousStatus, 'status' => $normalForm->status])
                   ->log('normal form sent for processing');

                with(new InspectionContext(Inspection::findOrFail($normalForm->normal_inspection_id)))->completed();
            }
        } else {
            return $this->notEditableResponse();
        }
        

        return $normalForm;
    }

    //forms to be processed
    // public function pending()
    // {
    //     return view('pages.normal-forms-pending');
    // }

    //forms to be processed api
    public function pendingApi(Request $request)
    {
        $normalForms = $this->normalForm
        ->where('status', '=' , 'pending');

        return $normalForms->orderBy('updated_at', 'desc')->paginate();
    }

    /**
     * Show the form for processing
     */
    // public function process($id)
    // {
    //     $form = $this->normalForm
    //     // ->with(['business', 'license'])
    //     ->findOrFail($id);
        
    //     if ($this->isProcessable($form)) {
    //         return view('pages.normal-form-process', compact('form'));
    //     }

    //     return redirect()->route('normal-forms.show', $id);
    // }

    //after processing change the status to processed
    protected function changedStatusToProcessed(Request $request, NormalForm $normalForm)
    {
        $previousStatus = $normalForm->status;
        if ($normalForm->status == 'pending') {
            $normalForm->status = 'processed';
            DB::beginTransaction();
            try {
                if ($normalForm->save()) {
                    $normalForm = $normalForm->fresh();
                    activity()
                       ->performedOn($normalForm)
                       ->causedBy($request->user())
                       ->withProperties(['previous_status' => $previousStatus, 'status' => $normalForm->status])
                       ->log('normal form processed');
                }
            } catch (Exception $e) {
                    DB::rollBack();
            }
            DB::commit();               
        } else {
            return $this->notProcessibleResponse();
        }
    }

    /**
     * not for level 1 users
     */
    public function sendBackToEditing(Request $request, NormalForm $normalForm)
    {
        $previousStatus = $normalForm->status;
        if($normalForm->status == 'pending') {
            $normalForm->status = 'draft';
            DB::beginTransaction();
            try {
                if ($normalForm->save() && $this->changeInspectionToOngoing($normalForm->normal_inspection_id)) {
                    $normalForm = $normalForm->fresh();
                    activity()
                       ->performedOn($normalForm)
                       ->causedBy($request->user())
                       ->withProperties(['previous_status' => $previousStatus, 'status' => $normalForm->status])
                       ->log('normal form sent back to editing');
                }
            } catch (Exception $e) {
                DB::rollBack();
            }
            DB::commit();
        } else {
            return $this->notProcessibleResponse();
        }
        
        return $normalForm;
    }

    protected function changeInspectionToOngoing($inspectionId)
    {
        $inspection = Inspection::findOrFail($inspectionId);
        if ($inspection->dhivehi_report_id) {
            $inspection->dhivehiReport()->delete();
        }

        if ($inspection->english_report_id) {
            $inspection->englishReport()->delete();
        }

        $inspection->english_report_id = null;
        $inspection->dhivehi_report_id = null;
        if ($inspection->save() && with(new InspectionContext($inspection))->ongoing()) {
            return true;
        }

        throw new Exception("unable to change inspection to ongoing");
        
    }


    //forms ready for report generation
    // public function processed()
    // {
    //     return view('pages.normal-forms-processed');
    // }

    //forms ready for report generation api
    public function processedApi(Request $request)
    {
        $normalForms = $this->normalForm
        ->with(['normalInspection'])
        ->where('status', '=' , 'processed');

        return $normalForms->orderBy('updated_at', 'desc')->paginate();
    }




    protected function isProcessable($normalForm)
    {
        return ($normalForm->status == 'pending') ? true : false;
    }

    protected function notProcessibleResponse()
    {
        return response()->json([
            'message' => 'form should be in pending state.'
        ], 422);
    }


    protected function isEditable(NormalForm $normalForm)
    {
        return ($normalForm->status == 'draft') ? true : false;
    }

    protected function notEditableResponse()
    {
        return response()->json([
            'message' => 'form should be in draft state.'
        ], 422);
    }
}

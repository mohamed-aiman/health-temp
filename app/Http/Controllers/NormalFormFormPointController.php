<?php

namespace App\Http\Controllers;

use App\NormalFormPoint;
use App\NormalForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NormalFormFormPointController extends Controller
{
    public function __construct(NormalForm $form, NormalFormPoint $point)
    {
        $this->form = $form;
        $this->point = $point;
    }

    public function valueChanged(Request $request, $formId, NormalFormPoint $formPoint)
    {
        check_is_inspector($this->form->findOrFail($formId)->inspection);

        if (!$this->isEditable($formPoint)) {
            return $this->notEditableResponse();
        }

        if (isset($request->value)) {
            $formPoint->value =  (boolean) $request->value;

            if ($formPoint->isDirty()) {
                if ($formPoint->save()) {
                    $formPoint = $formPoint->fresh();
                    activity()
                        ->performedOn($formPoint)
                        ->causedBy($request->user())
                        ->withProperties(['form_id' => $formId, 'normal_form_point_id' => $formPoint->id, 'form_point_value' => $formPoint->value])
                        ->log('normal form point form point value changed');
                }
            }
        }

        return $formPoint;
    }

    public function notApplicableChanged(Request $request, $formId, NormalFormPoint $formPoint)
    {
        check_is_inspector($this->form->findOrFail($formId)->inspection);

        if (!$this->isEditable($formPoint)) {
            return $this->notEditableResponse();
        }

        if (isset($request->not_applicable)) {
            $formPoint->not_applicable =  (boolean) $request->not_applicable;

            if ($formPoint->isDirty()) {
                if ($formPoint->save()) {
                    $formPoint = $formPoint->fresh();
                    activity()
                        ->performedOn($formPoint)
                        ->causedBy($request->user())
                        ->withProperties(['form_id' => $formId, 'normal_form_point_id' => $formPoint->id, 'form_point_not_applicable' => $formPoint->not_applicable])
                        ->log('normal form point form point not applicable changed');
                }
            }
        }

        return $formPoint;
    }

    public function remarksChanged(Request $request, $formId, NormalFormPoint $formPoint)
    {
        check_is_inspector($this->form->findOrFail($formId)->inspection);
        
        if (!$this->isEditable($formPoint)) {
            return $this->notEditableResponse();
        }

        if (isset($request->remarks)) {
            $formPoint->remarks = $request->remarks;

            if ($formPoint->isDirty()) {
                if ($formPoint->save()) {
                    $formPoint = $formPoint->fresh();
                    activity()
                        ->performedOn($formPoint)
                        ->causedBy($request->user())
                        ->withProperties(['form_id' => $formId, 'normal_form_point_id' => $formPoint->id, 'form_point_remarks' => $formPoint->remarks])
                        ->log('normal form point form point remarks changed');
                }
            }
        }

        return $formPoint;
    }

    protected function isEditable(NormalFormPoint $formPoint)
    {
        return ($formPoint->normalForm->status == 'draft') ? true : false;
    }

    protected function notEditableResponse()
    {
        $error = \Illuminate\Validation\ValidationException::withMessages([
           'point' => ['points form should be in draft state.']
        ]);

        throw $error;
    }

    
    
}

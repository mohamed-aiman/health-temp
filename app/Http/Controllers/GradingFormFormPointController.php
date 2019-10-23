<?php

namespace App\Http\Controllers;

use App\GradingFormPoint;
use App\GradingForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GradingFormFormPointController extends Controller
{
    public function __construct(GradingForm $form, GradingFormPoint $point)
    {
        $this->form = $form;
        $this->point = $point;
    }

    public function valueChanged(Request $request, $formId, GradingFormPoint $formPoint)
    {
        if (isset($request->value)) {
            $formPoint->value =  (boolean) $request->value;

            if ($formPoint->isDirty()) {
                if ($formPoint->save()) {
                    activity()
                       ->performedOn($formPoint)
                       ->causedBy($request->user())
                       ->withProperties(['form_id' => $formId, 'value' => $request->value])
                       ->log('updated grading form form point value');
                }
            }
        }

        return $formPoint;
    }

    public function notApplicableChanged(Request $request, $formId, GradingFormPoint $formPoint)
    {
        if (isset($request->not_applicable)) {
            $formPoint->not_applicable =  (boolean) $request->not_applicable;

            if ($formPoint->isDirty()) {
                if ($formPoint->save()) {
                    activity()
                       ->performedOn($formPoint)
                       ->causedBy($request->user())
                       ->withProperties(['form_id' => $formId, 'not_applicable' => $request->not_applicable])
                       ->log('updated grading form form point not applicable');
                }
            }
        }

        return $formPoint;
    }

    
    
}

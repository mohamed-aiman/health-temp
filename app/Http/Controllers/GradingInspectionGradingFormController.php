<?php

namespace App\Http\Controllers;

use App\GradingCategory;
use App\GradingForm;
use App\GradingFormPoint;
use App\GradingInspection;
use App\GradingPoint;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class GradingInspectionGradingFormController extends Controller
{
    public function __construct(GradingInspection $inspection, GradingForm $form)
    {
        $this->inspection = $inspection;
        $this->form = $form;
    }

    public function show(Request $request, GradingInspection $inspection)
    {
        if (!$formId = $inspection->grading_form_id) {
            if ($form = $this->buildGradingForm($inspection)) {
                activity()
                   ->performedOn($form)
                   ->causedBy($request->user())
                   ->withProperties(
                    array_merge(['grading_inspection_id' => $inspection->id], $form->toArray())   
                    )->log('created a grading form for the grading inspection');
            }
        }

        $formId = ($formId) ? $formId : $inspection->fresh()->grading_form_id;

        $form = $this->form->findOrFail($formId);
        $formPoints = $this->getFormPointsForDisplay($formId);

        return $form;
        // return view('pages.grading-form-show', compact('form'));
    }

    protected function buildGradingForm(GradingInspection $inspection)
    {
        DB::beginTransaction();
        try {
            // if ($form = $this->form->create(['grading_inspection_id' => $inspection->id])) {
            if ($form = $this->getBasicFilledForm($inspection)) {
                $inspection->grading_form_id = $form->id;
                $inspection->save();
                $this->addFieldsToForm($form->id);
            } else {
                throw new \Exception("Error building Grading Form.");
            }
        } catch (Exception $e) {
                DB::rollBack();
        }
        DB::commit();
        return $form;
    }

    protected function getBasicFilledForm(GradingInspection $inspection)
    {
        if (!$form = $this->form->where('grading_inspection_id', '=', $inspection->id)->first()) {
            $form = $this->form->create(['grading_inspection_id' => $inspection->id]);
        }

        return $form;
    }

    protected function addFieldsToForm($gradingFormId)
    {
        $activeGradingCategoriesWithPointsOrdered = GradingCategory::where('is_active', true)
            ->with(['gradingPoints' => function($query) {
                $query->orderBy('order', 'asc');
        }])->orderBy('order', 'asc')->get();

        $gradingFormPoint = new GradingFormPoint;

        $order = 0;
        $activeGradingCategoriesWithPointsOrdered->each(function($gradingCategoryWithPoints) use (&$order, $gradingFormPoint, $gradingFormId) {
            $gradingCategoryWithPoints->gradingPoints->each(function($gradingPoint) use (&$order, $gradingFormPoint, $gradingFormId) {
                $gradingFormPoint->create([
                    'grading_form_id' => $gradingFormId,
                    'grading_point_id' => $gradingPoint->id,
                    'grading_category_id' => $gradingPoint->grading_category_id,
                    'no' => $gradingPoint->no,
                    'code' => $gradingPoint->code,
                    'text' => $gradingPoint->text,
                    'category' => ($gradingPoint->gradingCategory) ? $gradingPoint->gradingCategory->text : null,
                    'order' => ++$order,
                ]);
            });
        });
    }


    public function getFormPointsForDisplay($formId)
    {
        $gradingFormPoint = new GradingFormPoint;

        $gradingFormPoints = $gradingFormPoint->where('grading_form_id', '=', $formId)->orderBy('order', 'asc')->get();

        $categories = [];

        $gradingFormPoints->each(function($point) use (&$categories) {
            $categories[$point->grading_category_id][] = $point->toArray();
        });        

        return $categories;
    }
}

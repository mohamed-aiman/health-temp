<?php

namespace App\Http\Controllers;

use App\Business;
use App\GradingForm;
use App\GradingInspection;
use Illuminate\Http\Request;
use DB;

class BusinessGradingInspectionController extends Controller
{
    public function __construct(Business $business, GradingInspection $inspection)
    {
        $this->business = $business;
    	$this->inspection = $inspection;
    }

    
    public function store(Request $request, Business $business)
    {
        // $business = $this->business->with('activeApplication', 'activeLicense')->findOrFail($business->id);
        DB::transaction(function () use ($request, $business){
            if ($inspection = $this->inspection->create([
                'business_id' => $business->id,
                'inspection_at' => $request->inspection_at,
                'status' => 'scheduled',
            ])) {
                activity()
                    ->performedOn($inspection)
                    ->causedBy($request->user())
                    ->withProperties(array_merge(
                    ['business_id' => $business->id],
                    $inspection->toArray()
                    ))->log('created a grading inspection for the business');    
            }

            if ($gradingForm = $this->createInspectionForm($request, $inspection, $business)) {
                activity()
                    ->performedOn($gradingForm)
                    ->causedBy($request->user())
                    ->withProperties(array_merge(
                    ['inspection_id' => $inspection->id],
                    $gradingForm->toArray()
                    ))->log('created a grading form for the inspection');    
            }
        });

        return $this->business->with([
            'inspections' => function($q) use ($business) {
                $q->where('inspections.business_id', $business->id);
            },
            'gradingInspections' => function($q) use ($business) {
                $q->where('grading_inspections.business_id', $business->id);
            }
        ])->findOrFail($business->id);
    }

    public function createInspectionForm(Request $request, GradingInspection $inspection, Business $business)
    {

        $activeApplication = ($business->activeApplication) ? $business->activeApplication : null;
        $activeLicense = ($business->activeLicense) ? $business->activeLicense : null;



        $gradingForm = GradingForm::create([
            'place_name' => $business->name_dv,
            'food_registration_no' => ($activeLicense) ? $activeLicense->license_no : null,
            'owner' => ($activeApplication) ? $activeApplication->_2name . '/' . $activeApplication->_3address : null,
            'inspection_date' => $inspection->inspection_at,
            'permit_limit' => '',
            'phone' => $business->phone,
            'information_provider' => '',
        // inspection's grading_form_id will be set after adding points to the grading forms
            'grading_inspection_id' => $inspection->id,
            'reason' => $request->reason
        ]);

        // $inspection->grading_form_id = $gradingForm->id;
        // $inspection->save();
        
        return $gradingForm;
    }
}

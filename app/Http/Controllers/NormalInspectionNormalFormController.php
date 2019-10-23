<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\NormalCategory;
use App\NormalForm;
use App\NormalFormPoint;
use App\NormalInspection;
use App\NormalPoint;
use App\StateManagers\Inspection\InspectionContext;
use DB;
use Illuminate\Http\Request;

class NormalInspectionNormalFormController extends Controller
{
    public function __construct(NormalInspection $inspection, NormalForm $form)
    {
        $this->inspection = $inspection;
        $this->form = $form;
    }

    // public function show(NormalInspection $inspection)
    // {
    //     if (!$formId = $inspection->normal_form_id) {
    //         $form = $this->buildNormalForm($inspection);
    //     }

    //     $formId = ($formId) ? $formId : $inspection->fresh()->normal_form_id;

    //     $form = $this->form->findOrFail($formId);
    //     $formPoints = $this->getFormPointsForDisplay($formId);

    //     return view('pages.normal-form-show', compact('form'));
    // }
    
    public function showApi(NormalInspection $inspection)
    {
        if (!$formId = $inspection->normal_form_id) {
            $form = $this->buildNormalForm($inspection);
            //we need to prevent trying to change from ongoing to started state when visited show while inspection on ongoing state
            if ($form && $inspection->state == 'scheduled') {
                with(new InspectionContext($inspection))->started();
            }
        }

        $formId = ($formId) ? $formId : $inspection->fresh()->normal_form_id;

        $form = $this->form->findOrFail($formId);
        // $formPoints = $this->getFormPointsForDisplay($formId);

        return $form;
    }
    

    // public function edit(NormalInspection $inspection)
    // {
    //     if (!$formId = $inspection->normal_form_id) {
    //         $form = $this->buildNormalForm($inspection);
    //     }

    //     $formId = ($formId) ? $formId : $inspection->fresh()->normal_form_id;

    //     $form = $this->form->findOrFail($formId);
    //     $formPoints = $this->getFormPointsForDisplay($formId);

    //     if (!$this->isEditable($form)) {
    //         return redirect()->route('normal-inspections.normalforms.show', $inspection->id);
    //     }

    //     return view('pages.normal-form-edit', compact('form'));
    // }

    protected function isEditable(NormalForm $normalForm)
    {
        return ($normalForm->status == 'draft') ? true : false;
    }

    protected function buildNormalForm(NormalInspection $inspection)
    {
        check_is_inspector($inspection);

        DB::beginTransaction();
        try {
            // if ($form = $this->form->create(['normal_inspection_id' => $inspection->id])) {
            if ($form = $this->getBasicFilledForm($inspection)) {
                $inspection->normal_form_id = $form->id;
                if ($inspection->save()) {
                    activity()
                        ->performedOn($inspection)
                        ->causedBy(request()->user())
                        ->withProperties(['normal_form_id' => $form->id])
                        ->log('attached normal form to inspection');
                }
                if ($createdArr = $this->addFieldsToForm($form->id)) {
                    activity()
                        ->performedOn($form)
                        ->causedBy(request()->user())
                        ->withProperties(['inspection_id' => $inspection->id, 'created_normal_form_point_ids' => $createdArr])
                        ->log('added fields to form');
                }
            } else {
                throw new \Exception("Error building Normal Form.");
            }
        } catch (\Exception $e) {
                DB::rollBack();
        }
        DB::commit();
        return $form;
    }

    protected function getBasicFilledForm(NormalInspection $inspection)
    {
        $lastForm = $this->getLastForm($inspection);

        if (!$form = $this->form->where('normal_inspection_id', '=', $inspection->id)->first()) {
            if ($form = $this->form->create([
                'reason' => $this->getReason($inspection),
                'applied_for' => $this->getAppliedFor($inspection),
                'applied_date' => $inspection->created_at->format('Y-m-d H:i:s'),
                'place_name_address' => $this->getPlaceNameAddress($inspection),
                'registration_no' => $inspection->business->registration_no,
                'place_owner_name_address' => $this->getPlaceOwnerNameAddress($inspection),
                'permit_expiry_date' => $inspection->business->expire_at,//->format('Y-m-d H:i:s'),
                'phone' => $inspection->business->phone,
                'chair_count' => $this->getChairCount($inspection, $lastForm),
                'serving_area_count' => $this->getServingAreaCount($inspection, $lastForm),
                'info_provider_name_no' => $this->getInfoProviderNameNumber($lastForm),
                'kitchen_count' => $this->getKitchenCount($lastForm),
                'inspected_at' => $inspection->inspection_at->format('Y-m-d H:i:s'),
                'normal_inspection_id' => $inspection->id,
                'status' => 'draft',
            ])) {
                activity()
                    ->performedOn($form)
                    ->causedBy(request()->user())
                    ->withProperties(
                        array_merge(['inspection_id' => $inspection->id], $form->toArray())
                    )
                    ->log('created a new normal form for a normal inspection');
            }
        }

        return $form;
    }

    protected function getLastForm($inspection)
    {
        return $this->form->whereHas('normalInspection', function($q) use ($inspection) {
                $q->where('business_id', $inspection->business_id)->orderBy('inspection_at', 'desc');
            })
            // ->whereNotNull('chair_count')
            ->where('status', "!=", 'draft')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    protected function getChairCount(NormalInspection $inspection, $lastForm = null)
    {
        if ($inspection->application) {
            return $inspection->application->_4numberOfChairs;
        }

        if ($lastForm) {
            return $lastForm->chair_count;
        }

        return null;
    }

    protected function getServingAreaCount(NormalInspection $inspection, $lastForm = null)
    {
        if ($inspection->application)  {
            return $inspection->application->_4numberOfServingAreas;
        }

        if ($lastForm) {
            return $lastForm->serving_area_count;
        }

        return null;
    }

    protected function getReason(NormalInspection $inspection)
    {
        //if register or renew
        if (in_array($inspection->type, ['1', '2'])) {
            return 'routine';
        }

        return snake_case(strtolower($inspection->reason));
    }

    protected function getAppliedFor(NormalInspection $inspection)
    {
        //if register or renew
        if ($inspection->type == '1') {
            return "new_registration";
        }

        if ($inspection->type == '2') {
            return "license_renewal";
        }

        return null;
    }

    protected function  getPlaceNameAddress(NormalInspection $inspection)
    {
        //first check whether it's created from application
        //if so get place name and address from application
        if ($application = $inspection->application) {
            return $application->_4placeName . '، ' . $application->_4placeAddress;
        }

        return $inspection->business->name_dv;
    }

    protected function  getPlaceOwnerNameAddress(NormalInspection $inspection, $lastForm = null)
    {
        //first check whether it's created from application
        //if so get owner name and address from application
        if ($application = $inspection->application) {
            return $application->_3name . '، ' . $application->_3address;
        }

        if ($lastForm) {
            return $lastForm->place_owner_name_address;
        }

        return null;
    }

    protected function getInfoProviderNameNumber($lastForm = null)
    {
        if ($lastForm) {
            return $lastForm->info_provider_name_no;
        }

        return null;
    }

    protected function getKitchenCount($lastForm = null)
    {
        if ($lastForm) {
            return $lastForm->kitchen_count;
        }

        return null;        
    }


    protected function addFieldsToForm($normalFormId)
    {
        $activeNormalCategoriesWithPointsOrdered = NormalCategory::where('is_active', true)
            ->with(['normalPoints' => function($query) {
                $query->orderBy('order', 'asc');
        }])->orderBy('order', 'asc')->get();

        $normalFormPoint = new NormalFormPoint;

        $order = 0;
        $createdArr = [];
        $activeNormalCategoriesWithPointsOrdered->each(function($normalCategoryWithPoints) use (&$order, $normalFormPoint, $normalFormId, &$createdArr) {
            $normalCategoryWithPoints->normalPoints->each(function($normalPoint) use (&$order, $normalFormPoint, $normalFormId, &$createdArr) {
                if ($created = $normalFormPoint->create([
                    'normal_form_id' => $normalFormId,
                    'normal_point_id' => $normalPoint->id,
                    'normal_category_id' => $normalPoint->normal_category_id,
                    'no' => $normalPoint->no,
                    'code' => $normalPoint->code,
                    'text' => $normalPoint->text,
                    'category' => ($normalPoint->normalCategory) ? $normalPoint->normalCategory->text : null,
                    'order' => ++$order,
                ])) {
                    $createdArr[] = $created->id;
                }
            });
        });

        return $createdArr;
    }


    public function getFormPointsForDisplay($formId)
    {
        $normalFormPoint = new NormalFormPoint;

        $normalFormPoints = $normalFormPoint->where('normal_form_id', '=', $formId)->orderBy('order', 'asc')->get();

        $categories = [];

        $normalFormPoints->each(function($point) use (&$categories) {
            $categories[$point->normal_category_id][] = $point->toArray();
        });        

        return $categories;
    }
}

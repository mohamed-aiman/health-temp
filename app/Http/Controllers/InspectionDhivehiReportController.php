<?php

namespace App\Http\Controllers;

use App\DhivehiReport;
use App\Http\Controllers\InspectionReportController;
use App\Inspection;
use Illuminate\Http\Request;

class InspectionDhivehiReportController extends InspectionReportController
{
    public function __construct(Inspection $inspection, DhivehiReport $report)
    {
        $this->inspection = $inspection;
        $this->report = $report;
    }
    
    // public function show(Request $request, Inspection $inspection)
    // {
    //     // $inspection = $this->inspection->findOrFail($inspection);
    //     // $inspection = Inspection::findOrFail($inspection);

    //     if (!$reportId = $inspection->dhivehi_report_id) {
    //         if ($report = $this->report->create()) {
    //             $inspection->dhivehi_report_id = $report->id;
    //             if ($inspection->save()) {
    //                 activity()
    //                    ->performedOn($report)
    //                    ->causedBy($request->user())
    //                    ->withProperties(array_merge(
    //                     ['inspection_id' => $inspection->id, 'inspection_dhivehi_report_id' => $report->id],
    //                     $report->toArray()
    //                     )
    //                     )->log('inspection dhivehi report created and attached report to inspection');
    //             }
    //         } else {
    //             throw new \Exception("Error Processing Request");
    //         }
    //     }

    //     $reportId = ($reportId) ? $reportId : $inspection->fresh()->dhivehi_report_id;

    //     $report = $this->report->with(['inspection', 'inspection.business', 'points'])->findOrFail($reportId);

    //     return view('pages.dhivehi-reports-show', compact('report'));
    // }

    // public function showApi(Request $request, Inspection $inspection)
    // {
    //     if (!$reportId = $inspection->dhivehi_report_id) {
    //         if ($report = $this->report->create(['inspection_id' => $inspection->id])) {
    //             $inspection->dhivehi_report_id = $report->id;
    //             if ($inspection->save()) {
    //                 activity()
    //                    ->performedOn($report)
    //                    ->causedBy($request->user())
    //                    ->withProperties(array_merge(
    //                     ['inspection_id' => $inspection->id, 'inspection_dhivehi_report_id' => $report->id],
    //                     $report->toArray()
    //                     )
    //                     )->log('inspection dhivehi report created and attached report to inspection and inspection to report');
    //             }
    //         } else {
    //             throw new \Exception("Error Processing Request");
    //         }
    //     } else {
    //         $reportId = $inspection->dhivehi_report_id;
    //     }

    //     return $report = $this->report->with(['inspection', 'inspection.business', 'points'])->findOrFail($reportId);
    // }

    public function showApi(Request $request, Inspection $inspection)
    {
        \DB::beginTransaction();

        try {
            // $inspection = $this->inspection->findOrFail($inspection);
            // $inspection = Inspection::findOrFail($inspection);
            if (!$reportId = $inspection->dhivehi_report_id) {
                if ($report = $this->buildReport($inspection)) {
                    $inspection->dhivehi_report_id = $report->id;
                    if ($inspection->save()) {
                        activity()
                           ->performedOn($report)
                           ->causedBy($request->user())
                           ->withProperties(array_merge(
                            ['inspection_id' => $inspection->id, 'inspection_dhivehi_report_id' => $report->id],
                            $report->toArray()
                            )
                            )->log('inspection dhivehi report created and attached report to inspection');
                    }
                } else {
                    throw new \Exception("Error Processing Request");
                }
            }

            \DB::commit();
            
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }

        $reportId = ($reportId) ? $reportId : $inspection->fresh()->dhivehi_report_id;

        $report = $this->report->with(['inspection', 'inspection.business', 'points'])->findOrFail($reportId);

        return $report;
    }

    // public function edit(Request $request, Inspection $inspection)
    // {
    //     \DB::beginTransaction();

    //     try {
    //         // $inspection = $this->inspection->findOrFail($inspection);
    //         // $inspection = Inspection::findOrFail($inspection);
    //         if (!$reportId = $inspection->dhivehi_report_id) {
    //             if ($report = $this->buildReport($inspection)) {
    //                 $inspection->dhivehi_report_id = $report->id;
    //                 if ($inspection->save()) {
    //                     activity()
    //                        ->performedOn($report)
    //                        ->causedBy($request->user())
    //                        ->withProperties(array_merge(
    //                         ['inspection_id' => $inspection->id, 'inspection_dhivehi_report_id' => $report->id],
    //                         $report->toArray()
    //                         )
    //                         )->log('inspection dhivehi report created and attached report to inspection');
    //                 }
    //             } else {
    //                 throw new \Exception("Error Processing Request");
    //             }
    //         }

    //         \DB::commit();
            
    //     } catch (\Exception $e) {
    //         \DB::rollback();
    //         throw $e;
    //     }

    //     $reportId = ($reportId) ? $reportId : $inspection->fresh()->dhivehi_report_id;

    //     $report = $this->report->with(['inspection', 'inspection.business', 'points'])->findOrFail($reportId);

    //     if (!$this->isEditable($report)) {
    //         return redirect()->route('inspections.dhivehi-reports.show', $inspection->id);
    //     }

    //     return view('pages.dhivehi-reports-edit', compact('report'));
    // }

    protected function buildReport(Inspection $inspection)
    {
        check_is_inspector($inspection);

        $followUpInspection = $this->getFollowupInspection($inspection);
        $paymentReceipt = $this->getPaymentReceipts($inspection);
        $terminationRequired = $this->isTerminationRequired($inspection);
        //add rem
        $report = $this->report->create([
            'inspection_id' => $inspection->id,
            // 'critical' => $this->getCritical($inspection),
            // 'major' => $this->getMajor($inspection),
            // 'minor' => $this->getMinor($inspection),
            // 'tobacco' => '',
            // 'critical_totals' => '',
            // 'major_totals' => '',
            // 'minor_totals' => '',
            // 'tobacco_totals' => '',
            'fine_slip_numbers' => $this->getFineSlipNumbers($inspection),
            'purpose' => $this->getPurpose($inspection),
            'place_name_address' => $this->getPlaceNameAddress($inspection),
            'place_owner_name_address' => $this->getPlaceOwnerNameAddress($inspection),
            'phone' => $this->getPhone($inspection),
            'information_provider' => $this->getInformationProvider($inspection),
            'number_of_inspections' => $this->getInspectionCount($inspection),
            'time_of_inspection' => $inspection->inspection_at->format('Y-m-d H:i:s'),
            // 'food_conclusion_1' => '',
            // 'food_conclusion_2' => '',
            'food_conclusion_3' => $followUpInspection['exists'],
            'food_conclusion_3_date' => $followUpInspection['inspection_at'],
            'food_conclusion_4' => $terminationRequired,
            // 'food_conclusion_5' => '',
            'food_conclusion_6' => $paymentReceipt['attached'],
            'food_conclusion_6_amount' => $paymentReceipt['total_amount'],
            'tobacco_conclusion_1' =>  $followUpInspection['exists'],
            'tobacco_conclusion_1_date' => $followUpInspection['inspection_at'],
            // 'tobacco_conclusion_2' => '',
            'tobacco_conclusion_3' => $paymentReceipt['attached'],
            'tobacco_conclusion_3_amount' => $paymentReceipt['total_amount'],
            'phi_head_conclusion_1' => $this->isFoodPermitGiven($inspection),
            // 'phi_head_conclusion_2' => '',
            'phi_head_conclusion_3' => $followUpInspection['exists'],
            'phi_head_conclusion_3_date' => $followUpInspection['inspection_at'],
            'phi_head_conclusion_4' => $terminationRequired,
            // 'phi_head_name' => '',
            // 'phi_head_sign' => '',
            // 'phi_head_date' => '',
            'tpcs_head_conclusion_1' => $this->isTobaccoPermitGiven($inspection),
            // 'tpcs_head_conclusion_2' => '',
            'tpcs_head_conclusion_3' => $followUpInspection['exists'],
            'tpcs_head_conclusion_3_date' => $followUpInspection['inspection_at'],
            'tpcs_head_conclusion_4' => $terminationRequired,
            // 'tpcs_head_name' => '',
            // 'tpcs_head_sign' => '',
            // 'tpcs_head_date' => '',
            // 'from_business_name' => '',
            // 'from_business_position' => '',
            // 'from_business_sign' => '',
            // 'from_business_date' => '',
            // 'from_hpa_name' => '',
            // 'from_hpa_position' => '',
            // 'from_hpa_sign' => '',
            // 'from_hpa_date' => '',
            'grading' => $this->getGrading($inspection),
        ]);

        if ($report) {
            $this->buildReportNormalFormPoints($inspection, $report);
        }

        return $report;
    }

    protected function getGrading($inspection)
    {
        if ($inspection->is_graded && $normalForm = $inspection->normalForm) {
            return \App\Helpers\GradingCalculator::calculate($normalForm);
        }

        return [];
    }

    protected function getInspectionCount($inspection)
    {
        return $inspection->business->inspections()->count();
    }

    protected function isFoodPermitGiven($inspection)
    {
        if ($application = $inspection->application) {
            if ($application->application_type_slug == 'tobacco') {
                return false;
            }

            if ($license = $application->license) {
                return ($license->tobacco_or_food == 'Food');
            }
        }

        return false;
    }

    protected function isTobaccoPermitGiven($inspection)
    {
        if ($application = $inspection->application) {
            if ($application->application_type_slug != 'tobacco') {
                return false;
            }

            if ($license = $application->license) {
                return ($license->tobacco_or_food == 'Tobacco');
            }
        }

        return false;
    }

    protected function isTerminationRequired($inspection)
    {
        return ($inspection->termination()->count()) ? true : false;
    }

    protected function getPaymentReceipts($inspection)
    {
        $data = [
            'attached' => false,
            'total_amount' => null
        ];

        $total = 0;

        if ($inspection->application_id && $application = $inspection->application) {
            if ($application->license && $application->license->is_paid) {
                $total += (float) $application->license->amount;
            }
        }

        $total += $inspection->fines->reduce(function($total, $fine) {
            if ($fine->is_paid) {
                return $total += $fine->amount;
            }
        });

        if ($total) {
            $data['total_amount'] = $total;
            $data['attached'] = true;
        }


        return $data;
    }

    protected function getFollowupInspection($inspection)
    {
        $data = [
            'exists' => false,
            'inspection_at' => null
        ];

        if ($inspection->follow_up_id) {
            $data['exists'] = true;
            $data['inspection_at'] = $inspection->followUpInspection->inspection_at->format('Y-m-d H:i:s');
        }

        return $data;
    }

    protected function getFineSlipNumbers($inspection)
    {
        $business = $inspection->business;
        $str = '';
        $str = $business->fines->reduce(function($str, $fine) {
            return $str .= $fine->fine_slip_no . ',';
        });

        return rtrim($str, ',');
    }


    protected function buildReportNormalFormPoints(Inspection $inspection, DhivehiReport $report)
    {
        $normalForm = $inspection->normalForm;
        $normalFormPoints = $normalForm->normalFormPoints()
            ->where('not_applicable', 0)
            ->where('value', false)->get();

        $array = array();

        $normalFormPoints->each(function($normalFormPoint) use (&$array) {
            $array[$normalFormPoint->id] = [
                'point_no' => $normalFormPoint->no,
                'code' => $normalFormPoint->code,
                'violation' => $normalFormPoint->text,
                'recommendation' => $normalFormPoint->remarks,
            ];
        });


        if ($dhivehiReportNormalFormPoints = $report->normalFormPoints()->sync($array)) {
            activity()
               ->performedOn($report)
               ->causedBy(request()->user())
               ->withProperties(array_merge(
                ['inspection_id' => $inspection->id, 'dhivehi_report_id' => $report->id],
                $dhivehiReportNormalFormPoints
                )
                )->log('built inspection dhivehi report normal form points');

            return $dhivehiReportNormalFormPoints;
        }
    }

    protected function getPurpose($inspection)
    {
        // <option value="1">ރަޖިސްޓްރީ ކުރުމަށް</option>
        // <option value="2">ރޫޓީން އިންސްޕެކްޝަން</option>
        // <option value="3">ހުއްދަ އާކުރުމަށް</option>
        // <option value="4">ސޮފްޓް ޗެކް</option>
        // <option value="5">ތަނުގެ އެޑްރެސް / މެނޭޖްމެން ބަދަލުވެގެން</option>
        // <option value="6">ޝަކުވާއާއި ގުޅިގެން</option>

        if ($application = $inspection->application) {
            //new registration
            if ($application->_1applicationType == '1') {
                //due to fresh start
                if($application->_1registerPlace == '1') {
                    return '1';
                } else {
                    //due to change of management,name or address
                    return '5';
                }

            }

            //renew license
            if ($application->_1applicationType == '2') {
                return '3';
            }
        }

        return '';
    }

    protected function  getPlaceNameAddress(Inspection $inspection)
    {
        //first check whether it's created from application
        //if so get place name and address from application
        if ($application = $inspection->application) {
            return $application->_4placeName . '، ' . $application->_4placeAddress;
        }

        return $inspection->business->name_dv;
    }

    protected function getInformationProvider(Inspection $inspection)
    {
        if ($normalForm = $inspection->normalForm) {
            return $normalForm->info_provider_name_no;
        }

        return null;

    }

    protected function getPhone(Inspection $inspection)
    {
        if ($normalForm = $inspection->normalForm) {
            return $normalForm->phone;
        }

        return null;

    }

    protected function getPlaceOwnerNameAddress(Inspection $inspection)
    {
        if ($normalForm = $inspection->normalForm) {
            return $normalForm->place_owner_name_address;
        }

        return null;
    }


    protected function isEditable(DhivehiReport $dhivehiReport)
    {
        return ($dhivehiReport->status == 'draft') ? true : false;
    }
}

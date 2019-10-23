<?php

namespace App\Http\Controllers;

use App\DhivehiReport;
use App\EnglishReport;
use App\Inspection;
use App\NormalForm;
use Illuminate\Http\Request;

class NormalFormReportController extends Controller
{
    public function __construct(NormalForm $normalForm)
    {
        $this->normalForm = $normalForm;
    }

    public function generateReports(Request $request, NormalForm $normalForm)
    {
        $inspection = Inspection::findOrFail($normalForm->normal_inspection_id);
        $this->generateDhivehiReport($inspection);
        $this->generateEnglishReport($inspection);
        return $normalForm->load('normalInspection');
    }

    protected function generateDhivehiReport(Inspection $inspection)
    {
        $this->report = new DhivehiReport;

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

        // $reportId = ($reportId) ? $reportId : $inspection->fresh()->dhivehi_report_id;

        // $report = $this->report->with(['inspection', 'inspection.business', 'points'])->findOrFail($reportId);

        // return $report;
    }

    protected function buildReport(Inspection $inspection)
    {
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
            // 'fine_slip_numbers' => '',
            'purpose' => $this->getPurpose($inspection),
            'place_name_address' => $this->getPlaceNameAddress($inspection),
            'place_owner_name_address' => $this->getPlaceOwnerNameAddress($inspection),
            'phone' => $this->getPhone($inspection),
            'information_provider' => $this->getInformationProvider($inspection),
            // 'number_of_inspections' => '',
            // 'time_of_inspection' => '',
            // 'food_conclusion_1' => '',
            // 'food_conclusion_2' => '',
            // 'food_conclusion_3' => '',
            // 'food_conclusion_3_date' => '',
            // 'food_conclusion_4' => '',
            // 'food_conclusion_5' => '',
            // 'food_conclusion_6' => '',
            // 'food_conclusion_6_amount' => '',
            // 'tobacco_conclusion_1' => '',
            // 'tobacco_conclusion_1_date' => '',
            // 'tobacco_conclusion_2' => '',
            // 'tobacco_conclusion_3' => '',
            // 'tobacco_conclusion_3_amount' => '',
            // 'phi_head_conclusion_1' => '',
            // 'phi_head_conclusion_2' => '',
            // 'phi_head_conclusion_3' => '',
            // 'phi_head_conclusion_3_date' => '',
            // 'phi_head_conclusion_4' => '',
            // 'phi_head_name' => '',
            // 'phi_head_sign' => '',
            // 'phi_head_date' => '',
            // 'tpcs_head_conclusion_1' => '',
            // 'tpcs_head_conclusion_2' => '',
            // 'tpcs_head_conclusion_3' => '',
            // 'tpcs_head_conclusion_3_date' => '',
            // 'tpcs_head_conclusion_4' => '',
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
        ]);

        if ($report) {
            $this->buildReportNormalFormPoints($inspection, $report);
        }

        return $report;
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

    public function generateEnglishReport(Inspection $inspection)
    {
        $this->report = new EnglishReport;

        \DB::beginTransaction();

        try {
            if (!$reportId = $inspection->english_report_id) {
                if ($report = $this->report->create([
                    'inspection_id' => $inspection->id
                ])) {
                    $inspection->english_report_id = $report->id;
                    if ($inspection->save()) {
                        activity()
                           ->performedOn($report)
                           ->causedBy(request()->user())
                           ->withProperties(array_merge(
                            ['inspection_id' => $inspection->id, 'inspection_english_report_id' => $report->id],
                            $report->toArray()
                            )
                            )->log('inspection english report created and attached report to inspection and inspection to report');
                    }
                } else {
                    throw new \Exception("Error Processing Request");
                }
            } else {
                $reportId = $inspection->english_report_id;
            }

            \DB::commit();
            
        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }
        // return $report = $this->report->with(['inspection', 'inspection.business'])->findOrFail($reportId);
        
    }
}

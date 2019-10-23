<?php

namespace App\Http\Controllers;

use App\EnglishReport;
use App\Inspection;
use Illuminate\Http\Request;

class InspectionEnglishReportController extends Controller
{
    public function __construct(Inspection $inspection, EnglishReport $report)
    {
        $this->inspection = $inspection;
        $this->report = $report;
    }
    
    // public function show(Inspection $inspection)
    // {
    //     // $inspection = $this->inspection->findOrFail($inspection);
    //     // $inspection = Inspection::findOrFail($inspection);

    //     if (!$reportId = $inspection->english_report_id) {
    //         if ($report = $this->report->create()) {
    //             $inspection->english_report_id = $report->id;
    //             $inspection->save();
    //         } else {
    //             throw new \Exception("Error Processing Request");
    //         }
    //     }

    //     $reportId = ($reportId) ? $reportId : $inspection->fresh()->english_report_id;

    //     $report = $this->report->with(['inspection', 'inspection.business'])->findOrFail($reportId);

    //     return view('pages.english-reports-show', compact('report'));
    // }

    public function showApi(Request $request, Inspection $inspection)
    {
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
                           ->causedBy($request->user())
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

        $reportId = ($reportId) ? $reportId : $inspection->fresh()->english_report_id;

        $report = $this->report->with(['inspection', 'inspection.business'])->findOrFail($reportId);

        return $report;
    }

    public function edit(Request $request, Inspection $inspection)
    {
        if (!$reportId = $inspection->english_report_id) {
            if ($report = $this->report->create()) {
                $inspection->english_report_id = $report->id;
                if ($inspection->save()) {
                    activity()
                       ->performedOn($report)
                       ->causedBy($request->user())
                       ->withProperties(array_merge(
                        ['inspection_id' => $inspection->id, 'inspection_english_report_id' => $report->id],
                        $report->toArray()
                        )
                        )->log('inspection english report created and attached report to inspection');
                }
            } else {
                throw new \Exception("Error Processing Request");
            }
        }

        $reportId = ($reportId) ? $reportId : $inspection->fresh()->english_report_id;

        $report = $this->report->with(['inspection', 'inspection.business'])->findOrFail($reportId);

        if (!$this->isEditable($report)) {
            return redirect()->route('english-reports.show', $reportId);
        }

        return view('pages.english-reports-edit', compact('report'));
    }

    protected function isEditable(EnglishReport $englishReport)
    {
        return ($englishReport->status == 'draft') ? true : false;
    }

    // protected function notEditableResponse()
    // {
    //     return response()->json([
    //         'message' => 'form should be in draft state.'
    //     ], 422);
    // }
}

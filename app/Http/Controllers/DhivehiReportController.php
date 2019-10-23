<?php

namespace App\Http\Controllers;

use App\DhivehiReport;
use App\DhivehiReportNormalFormPoint;
use App\NormalForm;
use App\NormalFormPoint;
use Carbon\Carbon;
use Exception;
use File;
use Illuminate\Http\Request;
use Response;
use DB;

class DhivehiReportController extends Controller
{
    public function __construct(DhivehiReport $report)
    {
        $this->report = $report;
    }


    /**
    * for level 2 users
    */
    public function sendForProcessing(Request $request, DhivehiReport $dhivehiReport)
    {
        check_is_inspector($dhivehiReport->inspection);
        
        $previousStatus = $dhivehiReport->status;
        if($dhivehiReport->status == 'draft') {
            $dhivehiReport->status = 'pending';
            if ($dhivehiReport->save()) {
                $dhivehiReport = $dhivehiReport->fresh();
                activity()
                    ->performedOn($dhivehiReport)
                    ->causedBy($request->user())
                    ->withProperties(['previous_status' => $previousStatus, 'status' => $dhivehiReport->status])
                    ->log('dhivehi report sent for processing');
            }
        } else {
            return $this->notEditableResponse();
        }
        

        return $dhivehiReport;
    }

    protected function notEditableResponse()
    {
        return response()->json([
            'message' => 'report should be in draft state.'
        ], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DhivehiReport  $dhivehiReport
     * @return \Illuminate\Http\Response
     */
    public function showApi(DhivehiReport $dhivehiReport)
    {
        return $dhivehiReport->load('points');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DhivehiReport  $dhivehiReport
     * @return \Illuminate\Http\Response
     */
    // public function show($reportId)
    // {
    //     $report = $this->report->with(['inspection', 'inspection.business', 'points'])->findOrFail($reportId);
    //     return view('pages.dhivehi-reports-show', compact('report'));
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\DhivehiReport  $dhivehiReport
    //  * @return \Illuminate\Http\Response
    //  */
    // public function handover($reportId)
    // {
    //     $report = $this->report->with(['inspection', 'inspection.business', 'points'])->findOrFail($reportId);
    //     return view('pages.dhivehi-reports-handover', compact('report'));
    // }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DhivehiReport  $dhivehiReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DhivehiReport $dhivehiReport)
    {
        check_is_inspector($dhivehiReport->inspection);

        if (!$this->isEditable($dhivehiReport)) {
            return $this->notEditableResponse();
        }
        // return $request->all();
        $data = $request->validate([
            // 'inspection_id' => '|string',
            'purpose' => '',

            'place_name_address' => '',
            'place_owner_name_address' => '',
            'phone' => '',
            'information_provider' => '',
            'time_of_inspection' => '',
            'number_of_inspections' => '',

            'critical' => '',
            'major' => '',
            'minor' => '',
            'tobacco' => '',
            
            'fine_slip_numbers' => '',

            'critical_totals' => '',
            'major_totals' => '',
            'minor_totals' => '',
            'tobacco_totals' => '',

            'food_conclusion_1' => '',
            'food_conclusion_2' => '',
            'food_conclusion_2_days' => '',
            'food_conclusion_3' => '',
            'food_conclusion_3_date' => '',
            'food_conclusion_4' => '',
            'food_conclusion_5' => '',
            'food_conclusion_6' => '',
            'food_conclusion_6_amount' => '',
            'tobacco_conclusion_1' => '',
            'tobacco_conclusion_1_date' => '',
            'tobacco_conclusion_2' => '',
            'tobacco_conclusion_3' => '',
            'tobacco_conclusion_3_amount' => '',
            'phi_head_conclusion_1' => '',
            'phi_head_conclusion_2' => '',
            'phi_head_conclusion_3' => '',
            'phi_head_conclusion_3_date' => '',
            'phi_head_conclusion_4' => '',
            'phi_head_name' => '',
            'phi_head_sign' => '',
            'phi_head_date' => '',
            'tpcs_head_conclusion_1' => '',
            'tpcs_head_conclusion_2' => '',
            'tpcs_head_conclusion_3' => '',
            'tpcs_head_conclusion_3_date' => '',
            'tpcs_head_conclusion_4' => '',
            'tpcs_head_name' => '',
            'tpcs_head_sign' => '',
            'tpcs_head_date' => '',
            'from_business_name' => '',
            'from_business_position' => '',
            'from_business_sign' => '',
            'from_business_date' => '',
            'from_hpa_name' => '',
            'from_hpa_position' => '',
            'from_hpa_sign' => '',
            'from_hpa_date' => '',

            // 'areas' => '',
            // 'comments' => '',
            // 'verified_by' => '',
            // 'inspectionMember1Name' => '',
            // 'inspectionMember1Designation' => '',
            // 'inspectionMember1Date' => '',
            // 'inspectionMember2Name' => '',
            // 'inspectionMember2Designation' => '',
            // 'inspectionMember2Date' => '',
            // 'verifiedByName' => '',
            // 'verifiedByDesignation' => '',
            // 'verifiedByDate' => '',
        ]);

        $dhivehiReport->fill($data);

        if ($dhivehiReport->isDirty()) {
            if ($dhivehiReport->save()) {
                $dhivehiReport = $dhivehiReport->fresh();
                activity()
                   ->performedOn($dhivehiReport)
                   ->causedBy($request->user())
                   ->withProperties($dhivehiReport->toArray())
                   ->log('updated dhivehi report');
            }
        }

        return $dhivehiReport->load('points');
        
    }

    /**
     * not for level 1 users
     */
    public function sendBackToEditing(Request $request, DhivehiReport $dhivehiReport)
    {
        $previousStatus = $dhivehiReport->status;
        if($dhivehiReport->status == 'pending') {
            $dhivehiReport->status = 'draft';
            if ($dhivehiReport->save()) {
                $dhivehiReport = $dhivehiReport->fresh();
                activity()
                    ->performedOn($dhivehiReport)
                    ->causedBy($request->user())
                    ->withProperties(['previous_status' => $previousStatus, 'status' => $dhivehiReport->status])
                    ->log('dhivehi report sent back to editing');
            }
        } else {
            return $this->notProcessibleResponse();
        }
        
        return $dhivehiReport;
    }

    // /**
    //  * Show the report for processing
    //  */
    // public function process($id)
    // {
    //     $report = $this->report
    //     ->findOrFail($id);
        
    //     if ($this->isProcessable($report)) {
    //         return view('pages.dhivehi-reports-process', compact('report'));
    //     }

    //     return redirect()->route('dhivehi-reports.show', $id);
    // }

        //after processing change the status to processed
    protected function changedStatusToProcessed(Request $request, DhivehiReport $dhivehiReport)
    {
        $previousStatus = $dhivehiReport->status;
        if ($dhivehiReport->status == 'pending') {
            $dhivehiReport->status = 'processed';
            DB::beginTransaction();
            try {
                if ($dhivehiReport->save() && $this->changeChecklistToProcessed($dhivehiReport)) {
                    $dhivehiReport = $dhivehiReport->fresh();
                    activity()
                        ->performedOn($dhivehiReport)
                        ->causedBy($request->user())
                        ->withProperties(['previous_status' => $previousStatus, 'status' => $dhivehiReport->status])
                        ->log('dhivehi report processed');
                }
            } catch (Exception $e) {
                DB::rollBack();
            }
            DB::commit();
        } else {
            return $this->notProcessibleResponse();
        }
    }

    protected function changeChecklistToProcessed($dhivehiReport)
    {
        $checklist = NormalForm::where('normal_inspection_id', $dhivehiReport->inspection_id)->first();
        $checklist->status = 'processed';
        return $checklist->save();
    }

    protected function notProcessibleResponse()
    {
        return response()->json([
            'message' => 'report should be in pending state.'
        ], 422);
    }



    protected function isProcessable($dhivehiReport)
    {
        return ($dhivehiReport->status == 'pending') ? true : false;
    }

    protected function isEditable(DhivehiReport $dhivehiReport)
    {
        return ($dhivehiReport->status == 'draft') ? true : false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DhivehiReport  $dhivehiReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(DhivehiReport $dhivehiReport)
    {
        //
    }

    public function issueReport(Request $request, DhivehiReport $dhivehiReport)
    {
        if ($dhivehiReport->status == 'issued') {
            return response()->json([
                'message' => 'report already issued.'
            ], 422);
        }
        // return $request->all();
        $data = $request->validate([
            // 'issued_by' => 
            // 'issued_on' => 'required',
            'received_by' => 'required',
            'hard_copy_path' => 'required',
        ]);
        $data['issued_by'] = $request->user()->id;
        $data['issued_on'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['status'] = 'issued';

        $dhivehiReport->fill($data);

        if ($dhivehiReport->isDirty()) {
            if ($dhivehiReport->save()) {
                $dhivehiReport = $dhivehiReport->fresh();
                activity()
                    ->performedOn($dhivehiReport)
                    ->causedBy($request->user())
                    ->withProperties($dhivehiReport->toArray())
                    ->log('issued dhivehi report');
            }
        }

        return $dhivehiReport;
    }

    public function uploadHardCopy(Request $request, DhivehiReport $dhivehiReport)
    {
        if ($dhivehiReport->status == 'issued') {
            return response()->json([
                'message' => 'report already issued.'
            ], 422);
        }

        if ($path = $request->file('image')->store('hardcopies/dhivehireports')) {
            $dhivehiReport->hard_copy_path = $path;
            if ($dhivehiReport->save()) {
                $dhivehiReport = $dhivehiReport->fresh();
                activity()
                    ->performedOn($dhivehiReport)
                    ->causedBy($request->user())
                    ->withProperties(['hard_copy_path' => $dhivehiReport->hard_copy_path])
                    ->log('uploaded hardcopy to dhivehi report');
            }
            
            return $dhivehiReport;
        }

        return response()->json([
            'message' => 'unable to upload the file'
        ], 400);

    }

    public function viewHardCopy(Request $request, DhivehiReport $dhivehiReport)
    {
        $filePath = storage_path('/app//'. $dhivehiReport->hard_copy_path);
        return $this->getImage($filePath);
    }

    
    public function getImage($filePath)
    {
        try {
            $file = File::get($filePath);

            $type = File::mimeType($filePath);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        } catch (Exception $e) {
            throw $e;
        }
    }
}

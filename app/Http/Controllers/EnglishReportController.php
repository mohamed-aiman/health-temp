<?php

namespace App\Http\Controllers;

use App\EnglishReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Psy\Test\Util\comments;
use File;
use Response;
use Exception;

class EnglishReportController extends Controller
{
    public function __construct(EnglishReport $englishReport)
    {
        $this->report = $englishReport;
    }


    // public function show($englishReport)
    // {
    //     $report = $this->report->with(['inspection', 'inspection.business'])->findOrFail($englishReport);

    //     return view('pages.english-reports-show', compact('report'));
    // }

    // public function handover($englishReport)
    // {
    //     $report = $this->report->with(['inspection', 'inspection.business'])->findOrFail($englishReport);

    //     return view('pages.english-reports-handover', compact('report'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('pages.english-reports-create');
    // }

    public function updateCritical(Request $request, EnglishReport $englishReport)
    {
        if (!$this->isEditable($englishReport)) {
            return $this->notEditableResponse();
        }
        // return $request->all();
        $englishReport->critical = json_encode($request->data);
        if ($englishReport->isDirty()) {
            if ($englishReport->save()) {
                $englishReport = $englishReport->fresh();
                activity()
                   ->performedOn($englishReport)
                   ->causedBy($request->user())
                   ->withProperties(['english_report_critical' =>  $englishReport->critical])
                   ->log('updated english report critical points');
            }
        }
        return $englishReport->critical;
    }

    public function updateMajor(Request $request, EnglishReport $englishReport)
    {
        if (!$this->isEditable($englishReport)) {
            return $this->notEditableResponse();
        }

        $englishReport->major = json_encode($request->data);
        if ($englishReport->isDirty()) {
            if ($englishReport->save()) {
                $englishReport = $englishReport->fresh();
                activity()
                   ->performedOn($englishReport)
                   ->causedBy($request->user())
                   ->withProperties(['english_report_major' =>  $englishReport->major])
                   ->log('updated english report major points');
            }
        }
        return $englishReport->major;
    }

    public function updateOther(Request $request, EnglishReport $englishReport)
    {

        if (!$this->isEditable($englishReport)) {
            return $this->notEditableResponse();
        }
        // return $request->all();
        $englishReport->observations = json_encode($request->data);
        if ($englishReport->isDirty()) {
            if ($englishReport->save()) {
                $englishReport = $englishReport->fresh();
                activity()
                   ->performedOn($englishReport)
                   ->causedBy($request->user())
                   ->withProperties(['english_report_observations' =>  $englishReport->observations])
                   ->log('updated english report observations points');
            }
        }
        return $englishReport->observations;
    }

    public function showApi($id)
    {
        return $report = $this->report->with(['inspection', 'inspection.business', 'inspection.fine'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EnglishReport  $englishReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EnglishReport $englishReport)
    {
        if (!$this->isEditable($englishReport)) {
            return $this->notEditableResponse();
        }

        $data = [
            'scope' => $request->scope,
            'areas' => $request->areas,
            'comments' => $request->comments,
            'inspectionMember1Name' => $request->inspectionMember1Name,
            'inspectionMember1Designation' => $request->inspectionMember1Designation,
            'inspectionMember1Date' => $request->inspectionMember1Date,
            'inspectionMember2Name' => $request->inspectionMember2Name,
            'inspectionMember2Designation' => $request->inspectionMember2Designation,
            'inspectionMember2Date' => $request->inspectionMember2Date,
            'verifiedByName' => $request->verifiedByName,
            'verifiedByDesignation' => $request->verifiedByDesignation,
            'verifiedByDate' => $request->verifiedByDate
        ];

        $englishReport->fill($data);

        if ($englishReport->isDirty()) {
            if ($englishReport->save()) {
                $englishReport = $englishReport->fresh();
                activity()
                   ->performedOn($englishReport)
                   ->causedBy($request->user())
                   ->withProperties($englishReport->toArray())
                   ->log('updated english report');
            }
        }

        return $report = $this->report->with(['inspection', 'inspection.business'])->findOrFail($englishReport->id);
    }


    /**
     * for level 2 users
     */
    public function sendForProcessing(Request $request, EnglishReport $englishReport)
    {
        $previousStatus = $englishReport->status;
        if($englishReport->status == 'draft') {
            $englishReport->status = 'pending';
            if ($englishReport->save()) {
                $englishReport = $englishReport->fresh();
                activity()
                    ->performedOn($englishReport)
                    ->causedBy($request->user())
                    ->withProperties(['previous_status' => $previousStatus, 'status' => $englishReport->status])
                    ->log('english report sent for processing');
            }
        } else {
            return $this->notEditableResponse();
        }
        

        return $englishReport;
    }

    // /**
    //  * Show the form for processing
    //  */
    // public function process($id)
    // {
    //     $report = $this->report
    //     ->findOrFail($id);
        
    //     if ($this->isProcessable($report)) {
    //         return view('pages.english-reports-process', compact('report'));
    //     }

    //     return redirect()->route('english-reports.show', $id);
    // }

       /**
     * not for level 1 users
     */
    public function sendBackToEditing(Request $request, EnglishReport $englishReport)
    {
        $previousStatus = $englishReport->status;
        if($englishReport->status == 'pending') {
            $englishReport->status = 'draft';
            if ($englishReport->save()) {
                $englishReport = $englishReport->fresh();
                activity()
                    ->performedOn($englishReport)
                    ->causedBy($request->user())
                    ->withProperties(['previous_status' => $previousStatus, 'status' => $englishReport->status])
                    ->log('english report sent back to editing');
            }
        } else {
            return $this->notProcessibleResponse();
        }
        
        return $englishReport;
    }

        //after processing change the status to processed
    protected function changedStatusToProcessed(Request $request, EnglishReport $englishReport)
    {
        $previousStatus = $englishReport->status;
        if ($englishReport->status == 'pending') {
            $englishReport->status = 'processed';
            if ($englishReport->save()) {
                $englishReport = $englishReport->fresh();
                activity()
                    ->performedOn($englishReport)
                    ->causedBy($request->user())
                    ->withProperties(['previous_status' => $previousStatus, 'status' => $englishReport->status])
                    ->log('english report sent back to editing');
            }
        } else {
            return $this->notProcessibleResponse();
        }

        return $englishReport;
    }

    protected function notProcessibleResponse()
    {
        return response()->json([
            'message' => 'report should be in pending state.'
        ], 422);
    }


    protected function isProcessable($englishReport)
    {
        return ($englishReport->status == 'pending') ? true : false;
    }


    protected function isEditable(EnglishReport $englishReport)
    {
        return ($englishReport->status == 'draft') ? true : false;
    }

    protected function notEditableResponse()
    {
        return response()->json([
            'message' => 'report should be in draft state.'
        ], 422);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EnglishReport  $englishReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(EnglishReport $englishReport)
    {
        //
    }

    public function issueReport(Request $request, EnglishReport $englishReport)
    {
        if ($englishReport->status == 'issued') {
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

        $englishReport->fill($data);


        if ($englishReport->isDirty()) {
            if ($englishReport->save()) {
                $englishReport = $englishReport->fresh();
                activity()
                    ->performedOn($englishReport)
                    ->causedBy($request->user())
                    ->withProperties($englishReport->toArray())
                    ->log('issued english report');
            }
        }
        return $englishReport;
    }

    public function uploadHardCopy(Request $request, EnglishReport $englishReport)
    {
        if ($englishReport->status == 'issued') {
            return response()->json([
                'message' => 'report already issued.'
            ], 422);
        }

        if ($path = $request->file('image')->store('hardcopies/englishreports')) {
            $englishReport->hard_copy_path = $path;
            if ($englishReport->save()) {
                $englishReport = $englishReport->fresh();
                activity()
                    ->performedOn($englishReport)
                    ->causedBy($request->user())
                    ->withProperties(['hard_copy_path' => $englishReport->hard_copy_path])
                    ->log('uploaded hardcopy to english report');
            }
             
            return $englishReport;
        }

        return response()->json([
            'message' => 'unable to upload the file'
        ], 400);

    }

    public function viewHardCopy(Request $request, EnglishReport $englishReport)
    {
        $filePath = storage_path('/app//'. $englishReport->hard_copy_path);
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

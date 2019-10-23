<?php

namespace App\Http\Controllers;

use App\Fine;
use App\GradingInspection;
use Illuminate\Http\Request;

class GradingInspectionFineController extends Controller
{
    public function __construct(GradingInspection $inspection, Fine $fine)
    {
        $this->inspection = $inspection;
        $this->fine = $fine;
    }

    public function index($inspectionId)
    {
        return $this->fine->where('grading_inspection_id', '=', $inspectionId)->orderBy('created_at', 'desc')->get();
    }
    
    public function store(Request $request, GradingInspection $inspection)
    {
        // if($fine = $this->fine->where('grading_inspection_id', $inspection->id)->first()) {
        //     $fine->fill([
        //         'business_id' => $inspection->business_id,
        //         'grading_inspection_id' => $inspection->id,
        //         'amount' => $request->amount,
        //         'paid_on' => $request->paid_on,
        //         'is_paid' => ($request->paid_on) ? true : false,
        //         'receipt_no' => $request->receipt_no,
        //         'fined_on' => $request->fined_on,
        //     ]);
        //     $fine->save();
        // } else {
            if ($fine = $this->fine->create([
                'business_id' => $inspection->business_id,
                'grading_inspection_id' => $inspection->id,
                'amount' => $request->amount,
                'remarks' => $request->remarks,
                // 'paid_on' => $request->paid_on,
                // 'is_paid' => ($request->paid_on) ? true : false,
                // 'receipt_no' => $request->receipt_no,
                'fined_on' => $request->fined_on,
            ])) {
                activity()
                   ->performedOn($fine)
                   ->causedBy($request->user())
                   ->withProperties(array_merge(
                    ['grading_inspection_id' => $inspection->id],
                    $fine->toArray()
                    )
                    )->log('fine created for the grading inspection');
            }
        // }

        return $fine;
    }

    // public function update(Request $request, GradingInspection $inspection, Fine $fine)
    // {
    //     $fine = $this->fine->where("grading_inspection_id", "=", $inspection->id)->firstOrFail($fine->id);
    //     $fine->fill([
    //         'business_id' => $inspection->business_id,
    //         // 'grading_inspection_id' => $inspection->id,
    //         'amount' => $request->amount,
    //         'paid_on' => $request->paid_on,
    //         'is_paid' => ($request->paid_on) ? true : false,
    //         'receipt_no' => $request->receipt_no,
    //         'fined_on' => $request->fined_on,
    //     ]);
    //     if ($fine->isDirty()) {
    //         $fine->save();
    //     }

    //     return $fine;
    // }

    // public function destroy(GradingInspection $inspection)
    // {
    //     $fine = $this->fine->where('grading_inspection_id', $inspection->id)->firstOrFail();
    //     if ($fine->delete()) {
    //         $inspection->is_fined = false;
    //         $inspection->save();
    //     } 
    // }

    public function destroy(GradingInspection $inspection)
    {
        $fines = $this->fine->where('grading_inspection_id', $inspection->id)->get();

        \DB::transaction(function() use ($fines) {
            $fines->each(function($fine) {
                $this->delete($fine);
            });

            $inspection->is_fined = false;
            if ($inspection->save()) {
                activity()
                    ->performedOn($inspection)
                    ->causedBy(request()->user())
                    ->log('inspection fine removed is fined');
            }
        });
    }

    protected function delete(Fine $fine)
    {
        if ($this->isEditable($fine)) {
            if ($fine->delete()) {
                activity()
                    ->performedOn($fine)
                    ->causedBy(request()->user())
                    ->log('inspection fine deleted');
            }
        }
    }

    protected function isEditable($fine)
    {
        if ($fine->is_paid == null) 
            return true;
        
        return ($fine->is_paid == true) ? false : false ;
    }

    protected function notEditableErrorResponse()
    {
        return response()->json([
            'message' => 'unable to delete. fine has already been paid.'
        ], 422);
    }
}

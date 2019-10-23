<?php

namespace App\Http\Controllers;

use App\Fine;
use App\FineType;
use App\Inspection;
use Illuminate\Http\Request;

class InspectionFineController extends Controller
{
    public function __construct(Inspection $inspection, Fine $fine)
    {
        $this->inspection = $inspection;
        $this->fine = $fine;
    }

    public function index($inspectionId)
    {
        return $this->fine->where('inspection_id', '=', $inspectionId)->orderBy('created_at', 'desc')->get();
    }
    
    public function store(Request $request, Inspection $inspection)
    {
        $fineType = FineType::findOrFail($request->fine_type_id);
        $fineSlipNumber = $this->getFineSlipNo($request, $inspection);

        if ($fine = $this->fine->create([
            'business_id' => $inspection->business_id,
            'inspection_id' => $inspection->id,
            'amount' => ($request->amount) ? $request->amount : $fineType->amount,
            'fined_on' => $request->fined_on,
            'fine_slip_no' => $fineSlipNumber,
            'fine_slip_path' => $this->saveFineSlip($request),
            // 'paid_on' => $request->paid_on,
            // 'is_paid' => ($request->paid_on) ? true : false,
            // 'receipt_no' => $request->receipt_no,
            'remarks' => $request->remarks,
            'fine_type_id' => $fineType->id,
        ])) {
            activity()
               ->performedOn($fine)
               ->causedBy($request->user())
               ->withProperties(array_merge(
                ['inspection_id' => $inspection->id],
                $fine->toArray()
                )
                )->log('fine created for the inspection');
        }

        return $fine;
    }

    public function saveFineSlip(Request $request)
    {
        if ($path = $request->file('image')->store('/hardcopies/fineslips')) {
            return $path;
        }

        return response()->json([
            'message' => 'unable to upload or save'
        ], 400);
    }


    protected function getFineSlipNo($request, $inspection)
    {
        if ($request->fine_slip_no) {
            if ($this->fine->where('fine_slip_no', $request->fine_slip_no)->count()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'fine_slip_no' => ['fine slip number exists.'],
                ]);
            }

            return $request->fine_slip_no;
        }

        return $this->generatedFineSlipNo($inspection);
    }

    protected function generatedFineSlipNo($inspection)
    {
        if ($lastFine = $this->fine->where('business_id', $inspection->business_id)->orderBy('id', 'desc')->first()) {
            return 'FINES-' . $lastFine->id . $inspection->business_id;
        }

        return 'FINES-0' . $inspection->business_id;
    }

    // public function update(Request $request, Inspection $inspection, Fine $fine)
    // {
    //     $fine = $this->fine->where("inspection_id", "=", $inspection->id)->firstOrFail($fine->id);
    //     $fine->fill([
    //         'business_id' => $inspection->business_id,
    //         // 'inspection_id' => $inspection->id,
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

    // public function destroy(Inspection $inspection)
    // {
    //     $fine = $this->fine->where('inspection_id', $inspection->id)->firstOrFail();
    //     if ($fine->delete()) {
    //         $inspection->is_fined = false;
    //         $inspection->save();
    //     } 
    // }

    public function destroy(Inspection $inspection)
    {
        $fines = $this->fine->where('inspection_id', $inspection->id)->get();

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

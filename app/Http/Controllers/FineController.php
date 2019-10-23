<?php

namespace App\Http\Controllers;

use App\Fine;
use App\Inspection;
use Illuminate\Http\Request;
use Response;
use File;


class FineController extends Controller
{
    public function __construct(Fine $fine)
    {
        $this->fine = $fine;
    }

    public function indexApi(Request $request)
    {
        $fines = $this->fine;

        if ($request->registrationNo || $request->placeNameDv) {
            $fines = $this->fine->whereHas('business', function($business) use ($request) {
                if ($request->registrationNo) {
                    $business = $business->where('registration_no', 'LIKE', "%$request->registrationNo%");
                }

                if ($request->placeNameDv) {
                    $business = $business->where('name_dv', 'LIKE', "%$request->placeNameDv%");
                }

                return $business;
            });
        }
        
        $fines = $fines->with('business');


        $fines = $this->basicFilters($fines, $request);

        return $fines->orderBy('updated_at', 'desc')->paginate();
    }

    // public function index()
    // {
    //     return view('pages.fines-index');
    // }

    protected function basicFilters($fines, $request)
    {
        if ($request->fineId && $request->fineId != "") {
            $fines  = $fines->where('id', '=', $request->fineId);
        }

        if ($request->inspectionId && $request->inspectionId != "") {
            $fines  = $fines->where('inspection_id', '=', $request->inspectionId);
        }


        return $fines;
    }


    // public function store(Request $request)
    // {
    //     $fine = $this->fine->create([
    //         'business_id' => $inspection->business_id,
    //         'inspection_id' => $inspection->id,
    //         'amount' => $request->amount,
    //         'paid_on' => $request->paid_on,
    //         'is_paid' => ($request->paid_on) ? true : false,
    //         'receipt_no' => $request->receipt_no,
    //         'fined_on' => $request->fined_on,
    //     ]);
    //     return $fine;
    // }
    
    public function pay(Request $request, Fine $fine)
    {
        if (!$fine->receipt_path) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => ['please upload the receipt'],
            ]);
        }

        if ($fine->is_paid) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => ['already marked as paid'],
            ]);
        }

        $data = $request->validate([
            'paid_on' => 'required',
            'receipt_no' => 'required',
        ]);

        $fine->fill(array_merge($data, ['is_paid' =>true]));

        if ($fine->isDirty() && $fine->save()) {
            $fine = $fine->fresh();
            activity()
                ->performedOn($fine)
                ->causedBy($request->user())
                ->withProperties([
                    'paid_on' => $fine->paid_on,
                    'receipt_no' => $fine->receipt_no,
                    'is_paid' => true
                ])
                ->log('marked fine as paid');
        }
        
        return $fine;
    }

    public function uploadReceipt(Request $request, Fine $fine)
    {
        //validate
        if ($path = $request->file('image')->store('/receipts/fines')) {
            $fine->receipt_path = $path;
            if ($fine->save()) {
                $fine = $fine->fresh();
                activity()
                    ->performedOn($fine)
                    ->causedBy($request->user())
                    ->withProperties(['receipt_path' => $fine->receipt_path])
                    ->log('uploaded fine paid receipt');
            }
            
            return $fine;
        }

        return response()->json([
            'message' => 'unable to upload the file'
        ], 400);
    }

    public function viewReceipt(Fine $fine)
    {
        $filePath = storage_path('/app//'. $fine->receipt_path);
        return $this->getImage($filePath);
    }

    public function viewSlip(Fine $fine)
    {
        $filePath = storage_path('/app//'. $fine->fine_slip_path);
        return $this->getImage($filePath);
    }

    public function update(Request $request, Fine $fine)
    {
        if ($fine->is_paid) {
            return response()->json([
                'message' => 'payment already made.'
            ], 422);
        }

        $fine->fill([
            // 'business_id' => $inspection->business_id,
            // 'inspection_id' => $inspection->id,
            'amount' => $request->amount,
            'paid_on' => $request->paid_on,
            'is_paid' => ($request->paid_on) ? true : false,
            'receipt_no' => $request->receipt_no,
            'fined_on' => $request->fined_on,
            'remarks' => $request->remarks,
        ]);

        if ($fine->save()) {
            $fine = $fine->fresh();
            activity()
                ->performedOn($fine)
                ->causedBy($request->user())
                ->withProperties($fine->toArray())
                ->log('updated fine');
        }

        return $fine;
    }

    public function destroy(Request $request, Fine $fine)
    {
        $logModel = $fine;
        if ($this->isEditable($fine)) {
            if ($fine->delete()) {
                activity()
                    ->performedOn($logModel)
                    ->causedBy($request->user())
                    ->log('deleted fine');
            }
        } else { 
            return $this->notEditableErrorResponse();
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

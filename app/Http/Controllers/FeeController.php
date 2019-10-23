<?php

namespace App\Http\Controllers;

use App\Fee;
use App\Inspection;
use Illuminate\Http\Request;
use Response;
use File;


class FeeController extends Controller
{
    public function __construct(Fee $fee)
    {
        $this->fee = $fee;
    }

    public function indexApi(Request $request)
    {
        $fees = $this->fee;

        if ($request->registrationNo || $request->placeNameDv) {
            $fees = $this->fee->whereHas('business', function($business) use ($request) {
                if ($request->registrationNo) {
                    $business = $business->where('registration_no', 'LIKE', "%$request->registrationNo%");
                }

                if ($request->placeNameDv) {
                    $business = $business->where('name_dv', 'LIKE', "%$request->placeNameDv%");
                }

                return $business;
            });
        }
        
        $fees = $fees->with('business');


        $fees = $this->basicFilters($fees, $request);

        return $fees->orderBy('updated_at', 'desc')->paginate();
    }

    // public function index()
    // {
    //     return view('pages.fees-index');
    // }

    protected function basicFilters($fees, $request)
    {
        if ($request->feeId && $request->feeId != "") {
            $fees  = $fees->where('id', '=', $request->feeId);
        }

        if ($request->inspectionId && $request->inspectionId != "") {
            $fees  = $fees->where('inspection_id', '=', $request->inspectionId);
        }


        return $fees;
    }


    // public function store(Request $request)
    // {
    //     $fee = $this->fee->create([
    //         'business_id' => $inspection->business_id,
    //         'inspection_id' => $inspection->id,
    //         'amount' => $request->amount,
    //         'paid_on' => $request->paid_on,
    //         'is_paid' => ($request->paid_on) ? true : false,
    //         'receipt_no' => $request->receipt_no,
    //         'feed_on' => $request->feed_on,
    //     ]);
    //     return $fee;
    // }
    
    public function pay(Request $request, Fee $fee)
    {
        if (!$fee->receipt_path) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => ['please upload the receipt'],
            ]);
        }

        if ($fee->is_paid) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => ['already marked as paid'],
            ]);
        }

        $data = $request->validate([
            'paid_on' => 'required',
            'receipt_no' => 'required',
        ]);

        $fee->fill(array_merge($data, ['is_paid' =>true]));

        if ($fee->isDirty() && $fee->save()) {
            $fee = $fee->fresh();
            activity()
                ->performedOn($fee)
                ->causedBy($request->user())
                ->withProperties([
                    'paid_on' => $fee->paid_on,
                    'receipt_no' => $fee->receipt_no,
                    'is_paid' => true
                ])
                ->log('marked fee as paid');
        }
        
        return $fee;
    }

    public function uploadReceipt(Request $request, Fee $fee)
    {
        //validate
        if ($path = $request->file('image')->store('/receipts/fees')) {
            $fee->receipt_path = $path;
            if ($fee->save()) {
                $fee = $fee->fresh();
                activity()
                    ->performedOn($fee)
                    ->causedBy($request->user())
                    ->withProperties(['receipt_path' => $fee->receipt_path])
                    ->log('uploaded fee paid receipt');
            }
            
            return $fee;
        }

        return response()->json([
            'message' => 'unable to upload the file'
        ], 400);
    }

    public function viewReceipt(Fee $fee)
    {
        $filePath = storage_path('/app//'. $fee->receipt_path);
        return $this->getImage($filePath);
    }

    public function viewSlip(Fee $fee)
    {
        $filePath = storage_path('/app//'. $fee->fee_slip_path);
        return $this->getImage($filePath);
    }

    public function update(Request $request, Fee $fee)
    {
        if ($fee->is_paid) {
            return response()->json([
                'message' => 'payment already made.'
            ], 422);
        }

        $fee->fill([
            // 'business_id' => $inspection->business_id,
            // 'inspection_id' => $inspection->id,
            'amount' => $request->amount,
            'paid_on' => $request->paid_on,
            'is_paid' => ($request->paid_on) ? true : false,
            'receipt_no' => $request->receipt_no,
            'feed_on' => $request->feed_on,
            'remarks' => $request->remarks,
        ]);

        if ($fee->save()) {
            $fee = $fee->fresh();
            activity()
                ->performedOn($fee)
                ->causedBy($request->user())
                ->withProperties($fee->toArray())
                ->log('updated fee');
        }

        return $fee;
    }

    public function destroy(Request $request, Fee $fee)
    {
        $logModel = $fee;
        if ($this->isEditable($fee)) {
            if ($fee->delete()) {
                activity()
                    ->performedOn($logModel)
                    ->causedBy($request->user())
                    ->log('deleted fee');
            }
        } else { 
            return $this->notEditableErrorResponse();
        }
    }

    protected function isEditable($fee)
    {
        if ($fee->is_paid == null) 
            return true;
        
        return ($fee->is_paid == true) ? false : false ;
    }

    protected function notEditableErrorResponse()
    {
        return response()->json([
            'message' => 'unable to delete. fee has already been paid.'
        ], 422);
    }
}

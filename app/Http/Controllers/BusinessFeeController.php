<?php

namespace App\Http\Controllers;

use App\Business;
use App\Fee;
use App\FeeType;
use Illuminate\Http\Request;

class BusinessFeeController extends Controller
{
	public function __construct(Business $business, Fee $fee)
    {
    	$this->business = $business;
    	$this->fee = $fee;
    }

    public function store(Request $request, Business $business)
    {
    	$request->validate([
			'amount' => 'required',
			// 'fee_slip_no' => 'required',
			// 'fee_slip_path' => 'required',
			'applied_on' => 'required',
			// 'is_paid' => 'required',
			// 'receipt_no' => 'required',
			// 'paid_on' => 'required',
			// 'receipt_path' => 'required',
			// 'remarks' => 'required',
			'fee_type_id' => 'required|exists:fee_types,id',
    	]);

        $feeSlipNumber = $this->getFeeSlipNo($request, $business);

    	if ($fee = $business->fees()->create([
            'amount' => $request->amount,
            'fee_slip_no' => $feeSlipNumber,
            'fee_slip_path' => $this->saveFeeSlip($request),
            'applied_on' => $request->applied_on,
            // 'is_paid' => $request->is_paid,
            // 'receipt_no' => $request->receipt_no,
            // 'paid_on' => $request->paid_on,
            // 'receipt_path' => $request->receipt_path,
            'remarks' => $request->remarks,
            'fee_type_id' => $request->fee_type_id
    	])) {
            activity()
               ->performedOn($fee)
               ->causedBy($request->user())
               ->log('fee applied to the business');
    	}

    	return $fee;
    }

    public function saveFeeSlip(Request $request)
    {
        if ($path = $request->file('image')->store('/hardcopies/feeslips')) {
            return $path;
        }

        return response()->json([
            'message' => 'unable to upload or save'
        ], 400);
    }

    protected function getFeeSlipNo($request, $business)
    {
        if ($request->fee_slip_no) {
            if ($this->fee->where('fee_slip_no', $request->fee_slip_no)->count()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'fee_slip_no' => ['fee slip number exists.'],
                ]);
            }

            return $request->fee_slip_no;
        }

        return $this->generatedFeeSlipNo($business);
    }

    protected function generatedFeeSlipNo($business)
    {
        if ($lastFee = $this->fee->where('business_id', $business->id)->orderBy('id', 'desc')->first()) {
            return 'FEES-' . $lastFee->id . $business->id;
        }

        return 'FEES-0' . $business->id;
    }
}

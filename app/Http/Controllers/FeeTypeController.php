<?php

namespace App\Http\Controllers;

use App\Business;
use App\FeeType;
use App\Helpers\LicenseDetails;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    public function __construct(FeeType $feeType)
    {
        $this->feeType = $feeType;
    }

    public function indexApi(Request $request)
    {
        $feeTypes = $this->feeType->orderBy('updated_at', 'desc')->get();


        if ($request->business_id && $licenseDetails = $this->getLicenseDetails($request->business_id)) {
            return $feeTypes->map(function($feeType) use ($licenseDetails) {
                if ($feeType->calculation_strategy == 'half_of_registration_fee') {
                    $feeType->amount = $licenseDetails['amount']/2;
                }

                return $feeType;
            });
        }

        return $feeTypes;
    }

    protected function getLicenseDetails($businessId)
    {
        $business = Business::findOrFail($businessId);

        if ($business->active_application_id) {
            return (new LicenseDetails())->usingBusiness($business)->handle();
        }

        return false;
    }

    public function store(Request $request)
    {
        return $this->feeType->create($request->all());
    }
}

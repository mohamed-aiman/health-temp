<?php

namespace App\Http\Controllers;

use App\Application;
use App\Events\NewBusinessRegistered;
use App\Helpers\AutofillLicense;
use App\License;
use Illuminate\Http\Request;

class ApplicationLicenseController extends Controller
{
    public function __construct(Application $application, License $license)
    {
        $this->application = $application;
    	$this->license = $license;
    }

    
    public function store(Request $request, Application $application)
    {
        $request->validate([
            'registration_no' => 'required',
            'license_type' => 'required',
            'license_no' => 'required',
            'issued_date' => 'required',
            'expiry_date' => 'required',
            'amount' => 'required',
            'inspection_id' => 'required',
        ]);

        if ($business = $application->business) {
            $generatedDetails = (new AutofillLicense($business))->handle($application);

            if (!$license = $this->license->where('application_id', $application->id)->first()) {
                $license = $this->createNewLicense($application, $request, $generatedDetails);
            } else {
                $license = $this->updateLicense($license, $application, $request, $generatedDetails);
            }

            $this->setBusinessLicenseId($business, $license, $application);
    
            if ($license->registrationLicense()) {

                $this->setHPARegistrationNumber($business, $generatedDetails, $request);

                if ($this->isGradableEstablishment($application)) {
                    event(new NewBusinessRegistered($license));
                }
            }

            return $license;
        }

        return response()->json([
            'message' => 'application does not have a business attached to it.'
        ], 422);


        // return $this->application->with(['business', 'inspections', 'license'])->findOrFail($application->id);
    }

    protected function createNewLicense($application, $request, $generatedDetails)
    {
        if ($license = $this->license->create([
            'business_id' => $application->business_id,
            'application_id' => $application->id,
            'type' => $application->_1applicationType,
            'license_type' => $generatedDetails['license_type'],
            'service_type' => $application->_1tobaccoOrFood,
            'license_no' => ($request->license_no) ? $request->license_no : $generatedDetails['license_no'],
            'issued_at' => $request->issued_date,
            'expire_at' => $request->expiry_date,
            'amount' => ($request->amount) ? $request->amount : $generatedDetails['amount']
        ])) {
            activity()
                ->performedOn($license)
                ->causedBy($request->user())
                ->withProperties(array_merge(
                ['application_id' => $application->id],
                $license->toArray()
                ))->log('license created for the application');    
        }

        return $license;
    }

    protected function updateLicense($license, $application, $request, $generatedDetails)
    {
        $license->fill([
            'business_id' => $application->business_id,
            'application_id' => $application->id,
            'type' => $application->_1applicationType,
            'license_type' => $generatedDetails['license_type'],
            'service_type' => $application->_1tobaccoOrFood,
            'license_no' => ($request->license_no) ? $request->license_no : $generatedDetails['license_no'],
            'issued_at' => $request->issued_date,
            'expire_at' => $request->expiry_date,
            'amount' => ($request->amount) ? $request->amount : $generatedDetails['amount']
        ]);
        if ($license->save()) {
            $license = $license->fresh();
            activity()
                ->performedOn($license)
                ->causedBy($request->user())
                ->withProperties(array_merge(
                ['application_id' => $application->id],
                $license->toArray()
                ))->log('application license updated');    
        }

        return $license;
    }

    protected function setBusinessLicenseId($business, $license, $application)
    {
        if (in_array($application->application_type_slug, ['food_new_registration', 'food_renewal'])) {
            $business->license_id = $license->id;
            $business->active_application_id = $application->id;
            $business->expire_at = $license->expire_at;
            if ($business->save()) {
                activity()
                    ->performedOn($business)
                    ->causedBy(request()->user())
                    ->withProperties(array_merge(
                    ['application_id' => $application->id],
                    $business->toArray()
                    ))->log('application business license info updated');    
            }
        }
    }

    protected function setHPARegistrationNumber($business, $generatedDetails, $request)
    {
        if ($generatedDetails['license_type'] == 'food_new_registration') {

            if ($request->registration_no) {
                $business->identification_code = $request->registration_no;
            } else {
                if (!$business->identification_code) {
                    $business->identification_code = $generatedDetails['registration_no'];
                }
            }

            if ($business->save()) {
                activity()
                    ->performedOn($business)
                    ->causedBy(request()->user())
                    ->withProperties(array_merge(
                    [
                        'request_registration_no' => $request->registration_no,
                        'generated_registration_no' => $generatedDetails['registration_no'],
                    ],
                    $business->toArray()
                    ))->log('business hpa registration_no set');    
            }
        }
    }

    protected function isGradableEstablishment($application)
    {
        $gradableCategories = [
            $application->_5cat11,
            $application->_5cat12,
            $application->_5cat13,
            $application->_5cat14,
            $application->_5cat15,
            $application->_5cat21,
            $application->_5cat31,
            $application->_5cat32,
            $application->_5cat33,
        ];

        foreach ($gradableCategories as $value) {
            if ($value ==  true) {
                return $value;
            }
        }

        return false;
    }
}

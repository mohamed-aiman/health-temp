<?php

namespace App\Http\Requests;

use App\Business;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isTobaccoRegistration($this) && !$this->haveFoodLicense($this)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
               '_1tobaccoOrFood' => ['The business(registration_no) should have food license before applying for a tobacco license.'],
            ]);
        }

        if ($this->isTobaccoRegistration($this) && $this->isRenewLicenseApplication($this)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
               '_1toRenewLicense' => ['tobacco permit cannot be renewed.'],
            ]);
        }

        return [
            '_1applicationType' => 'required',
            '_1date' => 'required',
            '_1registerPlace' => 'required',
            '_1registrationNumber' => 'required',
            '_1renewLicense' => '',
            '_1toRegisterPlace' => 'required',
            '_1toRenewLicense' => 'required',
            '_1tobaccoOrFood' => 'required',
            '_1wantLicenseIndhivehi' => 'required',
            '_1wantLicenseInenglish' => 'required',
            '_2address' => 'required',
            '_2idNo' => 'required',
            '_2name' => 'required',
            '_2phone' => 'required',
            '_3address' => 'required',
            '_3idNo' => 'required',
            '_3name' => 'required',
            '_3phone' => 'required',
            '_4blockNumber' => 'required',
            '_4numberOfChairs' => 'required',
            '_4numberOfServingAreas' => 'required',
            '_4placeAddress' => 'required',
            '_4placeName' => 'required',
            '_4road' => 'required',
            '_5cat101' => 'required',
            '_5cat101text' => 'required_if:_5cat101,===,true',
            '_5cat11' => 'required',
            '_5cat12' => 'required',
            '_5cat13' => 'required',
            '_5cat14' => 'required',
            '_5cat15' => 'required',
            '_5cat21' => 'required',
            '_5cat31' => 'required',
            '_5cat32' => 'required',
            '_5cat33' => 'required',
            '_5cat41' => 'required',
            '_5cat42' => 'required',
            '_5cat43' => 'required',
            '_5cat51' => 'required',
            '_5cat61' => 'required',
            '_5cat62' => 'required',
            '_5cat71' => 'required',
            '_5cat81' => 'required',
            '_5cat91' => 'required',
        ];
    }

    protected function isTobaccoRegistration($request)
    {
        return ($request->_1tobaccoOrFood == '1') ? true : false;
    }

    protected function haveFoodLicense($request, $businessId = null)
    {
        $businessId = ($businessId) ? $businessId : $request->business_id;
        
        if ($businessId && $request->_1registrationNumber) {
            $business = Business::where('registration_no', $request->_1registrationNumber)->findOrFail($businessId);
            return $business->license_id;
        }

        return false;
    }

    protected function isRenewLicenseApplication($request)
    {
        return ($request->_1toRenewLicense) ? true : false;
    }
}

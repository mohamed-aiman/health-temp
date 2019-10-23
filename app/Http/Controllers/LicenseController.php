<?php

namespace App\Http\Controllers;

use App\Business;
use App\Helpers\AutofillLicense;
use App\Http\Controllers\Controller;
use App\Inspection;
use App\License;
use App\licenses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LicenseController extends Controller
{
    public function __construct(License $license)
    {
        $this->license = $license;
    }

    public function indexApi(Request $request)
    {
        $licenses = $this->license;

        if ($request->registrationNo || $request->placeNameDv) {
            $licenses = $this->license->whereHas('business', function($business) use ($request) {
                if ($request->registrationNo) {
                    $business = $business->where('registration_no', 'LIKE', "%$request->registrationNo%");
                }

                if ($request->placeNameDv) {
                    $business = $business->where('name_dv', 'LIKE', "%$request->placeNameDv%");
                }

                return $business;
            });
        }
        
        $licenses = $licenses->with('business');;


        $licenses = $this->basicFilters($licenses, $request);

        return $licenses->orderBy('updated_at', 'desc')->paginate();
    }

    public function index()
    {
        return view('pages.licenses-index');
    }

    protected function basicFilters($licenses, $request)
    {
        if ($request->licenseId && $request->licenseId != "") {
            $licenses  = $licenses->where('id', '=', $request->licenseId);
        }

        if ($request->applicationId && $request->applicationId != "") {
            $licenses  = $licenses->where('application_id', '=', $request->applicationId);
        }

        if ($request->licenseNo && $request->licenseNo != "") {
            $licenses  = $licenses->where('license_no', 'LIKE', "%$request->licenseNo%");
        }


        return $licenses;
    }

    public function autofill(Request $request, Business $business)
    {
        $inspection = $business->inspections()->findOrFail($request->inspection_id);

        return (new AutofillLicense($business))->handle($inspection->application);
    }


    public function pay(Request $request, License $license)
    {
        if (!$license->receipt_path) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => ['please upload the receipt'],
            ]);
        }

        if ($license->is_paid) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => ['already marked as paid'],
            ]);
        }

        $data = $request->validate([
            'paid_on' => 'required',
            'receipt_no' => 'required',
        ]);

        $license->fill(array_merge($data, ['is_paid' =>true]));

        if ($license->isDirty() && $license->save()) {
            $license = $license->fresh();
            activity()
                ->performedOn($license)
                ->causedBy($request->user())
                ->withProperties([
                    'paid_on' => $license->paid_on,
                    'receipt_no' => $license->receipt_no,
                    'is_paid' => true
                ])
                ->log('marked license as paid');
        }
        
        return $license;
    }

    public function uploadReceipt(Request $request, License $license)
    {
        //validate
        if ($path = $request->file('image')->store('receipts/licenses')) {
            $license->receipt_path = $path;
            if ($license->save()) {
                $license = $license->fresh();
                activity()
                    ->performedOn($license)
                    ->causedBy($request->user())
                    ->withProperties(['receipt_path' => $license->receipt_path])
                    ->log('uploaded license paid receipt');
            }
            
            return $license;
        }

        return response()->json([
            'message' => 'unable to upload the file'
        ], 400);
    }

    public function viewReceipt(License $license)
    {
        $filePath = storage_path('/app//'. $license->receipt_path);
        return $this->getImage($filePath);
    }

    public function uploadHardCopy(Request $request, License $license)
    {
        if ($path = $request->file('image')->store('hardcopies/licenses')) {
            $license->hard_copy_path = $path;
            if ($license->save()) {
                $license = $license->fresh();
                activity()
                    ->performedOn($license)
                    ->causedBy($request->user())
                    ->withProperties(['hard_copy_path' => $license->hard_copy_path])
                    ->log('uploaded license hardcopy');
            }
            
            return $license;
        }

        return response()->json([
            'message' => 'unable to upload the file'
        ], 400);
    }

    public function viewHardCopy(License $license)
    {
        $filePath = storage_path('/app//'. $license->hard_copy_path);
        return $this->getImage($filePath);
    }

    public function destroy(License $license)
    {
        try {
            $logModel = $license;
            if ($license->delete()) {
                activity()
                    ->performedOn($license)
                    ->causedBy(request()->user())
                    ->log('deleted a license');
                
                return response()->json(['message' => 'deleted successfully.'], Response::HTTP_NO_CONTENT);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}

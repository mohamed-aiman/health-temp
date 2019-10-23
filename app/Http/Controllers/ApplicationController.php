<?php

namespace App\Http\Controllers;

use App\Application;
use App\Business;
use App\Http\Requests\ApplicationRequest;
use App\StateManagers\Inspection\InspectionContext;
use DB;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function __construct(Application $application)
    {
        $this->application = $application;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexApi(Request $request)
    {
        $applications = $this->application;

        if ($request->status && $request->status != "all") {
            $applications  = $applications->where('status', '=', $request->status);
        }

        $applications = $this->basicFilters($applications, $request);

        return $applications->orderBy('updated_at', 'desc')->paginate();
    }

    // public function index()
    // {
    //     return view('pages.applications-index');
    // }

    /**
     * Level 2
     */
    public function pendingApi(Request $request)
    {
        $applications = $this->application;

        $applications  = $applications->where('status', '=', 'pending');

        $applications = $this->basicFilters($applications, $request);

        return $applications->orderBy('updated_at', 'desc')->paginate();
    }

    /**
     * Level 2
     */
    // public function pending()
    // {
    //     return view('pages.applications-pending');
    // }
    /**
     * Level 1
     */
    public function draftApi(Request $request)
    {
        $applications = $this->application;


        $applications  = $applications->where('status', '=', 'draft');

        $applications = $this->basicFilters($applications, $request);

        return $applications->orderBy('updated_at', 'desc')->paginate();
    }

    /**
     * Level 1
     */
    // public function draft()
    // {
    //     return view('pages.applications-draft');
    // }

    protected function basicFilters($applications, $request)
    {
        if ($request->tobaccoOrFood && $request->tobaccoOrFood != "all") {

            $applications  = $applications->where('_1tobaccoOrFood', '=', $request->tobaccoOrFood);
        }

        if ($request->registerOrRenew && $request->registerOrRenew != "all") {
            $applications  = $applications->where('_1applicationType', '=', $request->registerOrRenew);
        }

        if ($request->applicationId && $request->applicationId != "") {
            $applications  = $applications->where('id', '=', $request->applicationId);
        }

        if ($request->registrationNo && $request->registrationNo != "") {

            $applications  = $applications->where('_1registrationNumber', 'LIKE', "%$request->registrationNo%");
        }

        if ($request->placeNameDv && $request->placeNameDv != "") {

            $applications  = $applications->where('_4placeName', 'LIKE', "%$request->placeNameDv%");
        }

        return $applications;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('pages.applications-create');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request)
    {
        $this->sanitizeByType($request);


        if ($application = $this->application->create([
            'business_id' => ($request->business_id) ? $request->business_id : null,
            '_1applicationType' => $request->_1applicationType,
            '_1date' => $request->_1date,
            '_1registerPlace' => $request->_1registerPlace,
            '_1registrationNumber' => $request->_1registrationNumber,
            '_1renewLicense' => $request->_1renewLicense,
            '_1toRegisterPlace' => $request->_1toRegisterPlace,
            '_1toRenewLicense' => $request->_1toRenewLicense,
            '_1tobaccoOrFood' => $request->_1tobaccoOrFood,
            '_1wantLicenseIndhivehi' => $request->_1wantLicenseIndhivehi,
            '_1wantLicenseInenglish' => $request->_1wantLicenseInenglish,
            '_2address' => $request->_2address,
            '_2idNo' => $request->_2idNo,
            '_2name' => $request->_2name,
            '_2phone' => $request->_2phone,
            '_3address' => $request->_3address,
            '_3idNo' => $request->_3idNo,
            '_3name' => $request->_3name,
            '_3phone' => $request->_3phone,
            '_4blockNumber' => $request->_4blockNumber,
            '_4numberOfChairs' => $request->_4numberOfChairs,
            '_4numberOfServingAreas' => $request->_4numberOfServingAreas,
            '_4placeAddress' => $request->_4placeAddress,
            '_4placeName' => $request->_4placeName,
            '_4road' => $request->_4road,
            '_5cat101' => $request->_5cat101,
            '_5cat101text' => $request->_5cat101text,
            '_5cat11' => $request->_5cat11,
            '_5cat12' => $request->_5cat12,
            '_5cat13' => $request->_5cat13,
            '_5cat14' => $request->_5cat14,
            '_5cat15' => $request->_5cat15,
            '_5cat21' => $request->_5cat21,
            '_5cat31' => $request->_5cat31,
            '_5cat32' => $request->_5cat32,
            '_5cat33' => $request->_5cat33,
            '_5cat41' => $request->_5cat41,
            '_5cat42' => $request->_5cat42,
            '_5cat43' => $request->_5cat43,
            '_5cat51' => $request->_5cat51,
            '_5cat61' => $request->_5cat61,
            '_5cat62' => $request->_5cat62,
            '_5cat71' => $request->_5cat71,
            '_5cat81' => $request->_5cat81,
            '_5cat91' => $request->_5cat91,
        ])) {
            activity()
               ->performedOn($application)
               ->causedBy($request->user())
               ->withProperties($application->toArray())
               ->log('created an application');
        }

        return $application;
    }

    protected function sanitizeByType($request)
    {
        //_1tobaccoOrFood = 2
        if ($this->isFoodPermitApplication($request)) {
            // $this->sanitizeFood($request);
            //_1applicationType = 1
            if ($this->isNewFoodPermitRegistration($request)) {
                $this->sanitizeRegisterFood($request);
            }

            //_1applicationType = 2
            if ($this->isRenewFoodPermitRegistration($request)) {
                $this->sanitizeRenewFood($request);
            }
        } 
        //_1tobaccoOrFood = 1
        else {
            $this->sanitizeTobacco($request);
        }
    }

    protected function sanitizeRegisterFood($request)
    {
        if (!in_array($request->_1registerPlace, ['1', '2', '3', '4'])) {
            throw new \Exception("Logged: sanitizeRegisterFood called. thats not from web cleint! - user id: " . $request->user()->id);        
        }

        $request->merge([
            '_1tobaccoOrFood' => '2',
            '_1applicationType' => '1',
            '_1toRegisterPlace' => true,
            '_1toRenewLicense' => false,
            // '_1registerPlace' => 1,2,3,4
            '_1renewLicense' => null
        ]);
    }

    protected function sanitizeRenewFood($request)
    {
        if (!in_array($request->_1renewLicense, ['1', '2', '3'])) {
            throw new \Exception("Logged: sanitizeRenewFood called. thats not from web cleint! - user id: " . $request->user()->id);        
        }

        $request->merge([
            '_1tobaccoOrFood' => '2',
            '_1applicationType' => '2',
            '_1toRegisterPlace' => false,
            '_1toRenewLicense' => true,
            '_1registerPlace' => null
            // '_1renewLicense' => 1,2,3
        ]);

    }

    protected function sanitizeTobacco($request)
    {
        $request->merge([
            '_1tobaccoOrFood' => '1',
            '_1applicationType' => null,
            '_1toRegisterPlace' => true,
            '_1toRenewLicense' => false,
            '_1registerPlace' => null,
            '_1renewLicense' => null
        ]);
    }

    protected function isFoodPermitApplication($request)
    {
        if ($request->_1tobaccoOrFood == '2') {
            return true;
        }

        if ($request->_1tobaccoOrFood == '1') {
            return false;
        }

        throw new \Exception("Logged: thats not from web cleint! - user id: " . $request->user()->id);        
    }

    protected function isNewFoodPermitRegistration($request)
    {
        return ($request->_1toRegisterPlace) ? true : false;
    }

    protected function isRenewFoodPermitRegistration($request)
    {
        return ($request->_1toRenewLicense) ? true : false;
    }
    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Application  $application
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $application = $this->application->with(['business', 'license'])->findOrFail($id);

    //     return view('pages.applications-show', compact('application'));
    // }

    public function showApi($id)
    {
        return $this->application->with([
            'business',
            'inspections',
            'inspections.inspector',
            'license',
            'documents',
        ])->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    // public function process($id)
    // {
    //     $application = $this->application->with(['business', 'license'])->findOrFail($id);
        
    //     if ($this->isProcessable($application)) {
    //         return view('pages.applications-process', compact('application'));
    //     }

    //     return redirect()->route('applications.show', $id);
    // }

    protected function processed(Request $request, Application $application)
    {
        if (!$application->inspections->count()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
               'message' => ['no inspection has been set. there should be an inspection scheduled to be able to mark application as being processed.'],
            ]);
        }


        $previousStatus = $application->status;
        if ($application->status == 'pending') {
            DB::beginTransaction();
            try {
                $application->status = 'processed';
                if ($application->save()) {
                    $inspection = $application->inspections()->findOrFail($request->inspection_id);
                    with(new InspectionContext($inspection))->scheduled();
                    $application = $application->fresh();
                    activity()
                       ->performedOn($application)
                       ->causedBy($request->user())
                       ->withProperties([
                        'previous_status' => $previousStatus, 
                        'status' => $application->status
                    ])
                    ->log('processed application, inspection state changed to scheduled');
                }
            } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
            }
            DB::commit();
        } else {
            return $this->notProcessibleResponse();
        }

        return $application;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $application = $this->application->with(['business', 'license'])->findOrFail($id);
    //     if ($this->isEditable($application)) {
    //         return view('pages.applications-edit', compact('application'));
    //     }

    //     return redirect()->route('applications.show', $id);
    // }

    protected function isEditable($application)
    {
        return ($application->status == 'draft') ? true : false;
    }

    protected function notEditableResponse()
    {
        return response()->json([
            'message' => 'application should be in draft state.'
        ], 422);
    }

    protected function isProcessable($application)
    {
        return ($application->status == 'pending') ? true : false;
    }

    protected function notProcessibleResponse()
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
           'message' => ['application should be in pending state.'],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationRequest $request, Application $application)
    {
        if (!$this->isEditable($application)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
               'status' => ['Application should be in draft status if you want to edit it!'],
            ]);
        }

        $this->sanitizeByType($request);


        $data = [
            'business_id' => ($request->business_id) ? $request->business_id : $application->business_id,
            '_1applicationType' => $request->_1applicationType,
            '_1date' => $request->_1date,
            '_1registerPlace' => $request->_1registerPlace,
            '_1registrationNumber' => $request->_1registrationNumber,
            '_1renewLicense' => $request->_1renewLicense,
            '_1toRegisterPlace' => $request->_1toRegisterPlace,
            '_1toRenewLicense' => $request->_1toRenewLicense,
            '_1tobaccoOrFood' => $request->_1tobaccoOrFood,
            '_1wantLicenseIndhivehi' => $request->_1wantLicenseIndhivehi,
            '_1wantLicenseInenglish' => $request->_1wantLicenseInenglish,
            '_2address' => $request->_2address,
            '_2idNo' => $request->_2idNo,
            '_2name' => $request->_2name,
            '_2phone' => $request->_2phone,
            '_3address' => $request->_3address,
            '_3idNo' => $request->_3idNo,
            '_3name' => $request->_3name,
            '_3phone' => $request->_3phone,
            '_4blockNumber' => $request->_4blockNumber,
            '_4numberOfChairs' => $request->_4numberOfChairs,
            '_4numberOfServingAreas' => $request->_4numberOfServingAreas,
            '_4placeAddress' => $request->_4placeAddress,
            '_4placeName' => $request->_4placeName,
            '_4road' => $request->_4road,
            '_5cat101' => $request->_5cat101,
            '_5cat101text' => $request->_5cat101text,
            '_5cat11' => $request->_5cat11,
            '_5cat12' => $request->_5cat12,
            '_5cat13' => $request->_5cat13,
            '_5cat14' => $request->_5cat14,
            '_5cat15' => $request->_5cat15,
            '_5cat21' => $request->_5cat21,
            '_5cat31' => $request->_5cat31,
            '_5cat32' => $request->_5cat32,
            '_5cat33' => $request->_5cat33,
            '_5cat41' => $request->_5cat41,
            '_5cat42' => $request->_5cat42,
            '_5cat43' => $request->_5cat43,
            '_5cat51' => $request->_5cat51,
            '_5cat61' => $request->_5cat61,
            '_5cat62' => $request->_5cat62,
            '_5cat71' => $request->_5cat71,
            '_5cat81' => $request->_5cat81,
            '_5cat91' => $request->_5cat91,
        ];

        $application->fill($data);

        if ($application->isDirty()) {
            if ($application->save()) {
                $application = $application->fresh();
                activity()
                   ->performedOn($application)
                   ->causedBy($request->user())
                   ->withProperties($application->toArray())
                   ->log('updated application');
            }
        }

        return $application;
    }

    public function updateStatus(Request $request, Application $application)
    {
        $previousStatus = $application->status;
        $application->status = $request->status;
        if ($application->save()) {
            $application = $application->fresh();
            activity()
               ->performedOn($application)
               ->causedBy($request->user())
               ->withProperties(['previous_status' => 'previousStatus', 'status' => $application->status])
               ->log('application status updated');
        }
        return $application;
    }

    /**
     * for level 1 users
     */
    public function sendForProcessing(Request $request, Application $application)
    {
        if ($application->business_id == null) {
            return response()->json([
                'message' => 'please attach a business before sending to processing.'
            ], 422);
        }

        $previousStatus = $application->status;
        if($application->status == 'draft') {
            $application->status = 'pending';
            if ($application->save()) {
                $application = $application->fresh();
                activity()
                   ->performedOn($application)
                   ->causedBy($request->user())
                   ->withProperties(['previous_status' => $previousStatus, 'status' => $application->status])
                   ->log('application sent for processing');
            }
        } else {
            return $this->notEditableResponse();
        }
        

        return $application;
    }

    /**
     * not for level 1 users
     */
    public function sendBackToEditing(Request $request, Application $application)
    {

        $previousStatus = $application->status;
        if($application->status == 'pending') {
            $application->status = 'draft';
            if ($application->save()) {
                $application = $application->fresh();
                activity()
                   ->performedOn($application)
                   ->causedBy($request->user())
                   ->withProperties(['previous_status' => $previousStatus, 'status' => $application->status])
                   ->log('application sent back for editing');
            }
        } else {
            return $this->notProcessibleResponse();
        }
        
        return $application;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Application $application)
    {
        if ($application->status != 'draft') {
            return response()->json([
                'message' => 'only draft applications can be deleted.'
            ], 422);
        }

        if ($application->delete()) {
            activity()
                   ->performedOn($application)
                   ->causedBy($request->user())
                   ->log('application deleted');
            return  response()->json([
                'message' => 'deleted successfully.'
            ], 204);
        }
    }
}

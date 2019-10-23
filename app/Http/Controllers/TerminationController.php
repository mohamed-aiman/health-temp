<?php

namespace App\Http\Controllers;

use App\Termination;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TerminationController extends Controller
{
    public function __construct(Termination $termination)
    {
        $this->termination = $termination;
    }

    public function indexApi(Request $request)
    {
        $terminations = $this->termination;

        if ($request->registrationNo || $request->placeNameDv) {
            $terminations = $this->termination->whereHas('business', function($business) use ($request) {
                if ($request->registrationNo) {
                    $business = $business->where('registration_no', 'LIKE', "%$request->registrationNo%");
                }

                if ($request->placeNameDv) {
                    $business = $business->where('name_dv', 'LIKE', "%$request->placeNameDv%");
                }

                return $business;
            });
        }
        
        $terminations = $terminations->with('business');


        $terminations = $this->basicFilters($terminations, $request);

        return $terminations->orderBy('updated_at', 'desc')->paginate();
    }

    public function index()
    {
        return view('pages.terminations-index');
    }

    protected function basicFilters($terminations, $request)
    {
        if ($request->terminationId && $request->terminationId != "") {
            $terminations  = $terminations->where('id', '=', $request->terminationId);
        }

        // if ($request->inspectionId && $request->inspectionId != "") {
        //     $terminations  = $terminations->where('inspection_id', '=', $request->inspectionId);
        // }


        return $terminations;
    }

    public function destroy(Termination $termination)
    {
        try {
            $logModel = $termination;
            if ($termination->delete()) {
                activity()
                    ->performedOn($termination)
                    ->causedBy(request()->user())
                    ->log('deleted a termination');
                
                return response()->json(['message' => 'deleted successfully.'], Response::HTTP_NO_CONTENT);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\GradingInspection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GradingInspectionController extends Controller
{
    public function __construct(GradingInspection $inspection)
    {
        $this->inspection = $inspection;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GradingInspection $inspection)
    {
        $inspection->fill([
            'inspection_at' => $request->inspection_at,
            'status' => $request->status,
        ]);

        if ($inspection->isDirty()) {
            if ($inspection->save()) {
                $inspection = $inspection->fresh();
                activity()
                   ->performedOn($inspection)
                   ->causedBy($request->user())
                   ->withProperties($inspection->toArray())
                   ->log('updated grading inspection');
            }
        }

        return $inspection;

        // return $this->inspection->with('business')->findOrFail($inspection->id);
    }

    public function close(Request $request, GradingInspection $inspection)
    {
        $previousStatus = $inspection->status;
        $inspection->status = 'finished';
        if ($inspection->save()) {
            activity()
               ->performedOn($inspection)
               ->causedBy($request->user())
                ->withProperties(['previous_status' => $previousStatus, 'status' => 'finished'])
               ->log('grading inspection closed');
        }
    }

    public function showApi($inspection)
    {
        return $this->inspection->with([
            // 'englishReport',
            // 'dhivehiReport',
            'business',
            'fines',
            'application',
            'application.license',
            'followUpInspection',
            // 'normalForm'
            // 'followUpInspectionOf',
        ])->findOrFail($inspection);
    }
    

    public function upcomingApi(Request $request)
    {
        $query = $this->inspection->with('business')->where('inspection_at', '>=', Carbon::now());

        if ($request->month) {
            $query = $query->where('inspection_at', '<=', Carbon::now()->addMonths($request->month));  
        }

        return $query->orderBy('inspection_at', 'desc')->paginate();
        // return $this->business->orderBy('expire_at', 'desc')->paginate();
    }

    public function edit(GradingInspection $inspection)
    {
        return 'TODO check this method and pages.edit-grading-inspection';
        return view('pages.edit-grading-inspection', compact('inspection'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\GradingInspection  $inspection
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, GradingInspection $inspection)
    // {
        
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\GradingInspection  $inspection
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroyApi(GradingInspection $inspection)
    // {
    //     if ($inspection->delete()) {
    //         return response()->json([
    //             'message' => 'deleted successfully'
    //         ], 204);
    //     }

    //     return response()->json([
    //         'message' => 'unable to delete'
    //     ], 409);
    // }
}

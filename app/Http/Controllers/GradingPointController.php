<?php

namespace App\Http\Controllers;

use App\GradingPoint;
use Illuminate\Http\Request;

class GradingPointController extends Controller
{
    public function __construct(GradingPoint $gradingPoint)
    {
        $this->gradingPoint = $gradingPoint;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manageGradingPoints()
    {
        // $gradingPoints = $this->gradingPoint->all();

        // return view('pages.grading-point.index', compact('gradingPoint'));
        return view('pages.manage-grading-points');
    }

    public function indexApi()
    {
        return $this->gradingPoint->with('gradingCategory')->orderBy('updated_at', 'desc')->get();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeApi(Request $request)
    {
        if ($gradingPoint = $this->gradingPoint->create($request->all())) {
            activity()
                   ->performedOn($gradingPoint)
                   ->causedBy($request->user())
                   ->withProperties($gradingPoint->toArray())
                   ->log('created a grading point');

            return $gradingPoint;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GradingPoint  $gradingPoint
     * @return \Illuminate\Http\Response
     */
    public function updateApi(Request $request, GradingPoint $gradingPoint)
    {
        $gradingPoint->fill($request->all());

        if ($gradingPoint->isDirty()) {
            if ($gradingPoint->save()) {
                $gradingPoint = $gradingPoint->fresh();
                activity()
                   ->performedOn($gradingPoint)
                   ->causedBy($request->user())
                   ->withProperties($gradingPoint->toArray())
                   ->log('updated grading point');
            }
        }
 
        return $gradingPoint;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GradingPoint  $gradingPoint
     * @return \Illuminate\Http\Response
     */
    public function showApi(GradingPoint $gradingPoint)
    {
        return $gradingPoint;//->load('gradingCategory');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GradingPoint  $gradingPoint
     * @return \Illuminate\Http\Response
     */
    public function edit($gradingPointId)
    {
        return view('pages.edit-grading-point', compact('gradingPointId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GradingPoint  $gradingPoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GradingPoint $gradingPoint)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GradingPoint  $gradingPoint
     * @return \Illuminate\Http\Response
     */
    public function destroyApi(Request $request, GradingPoint $gradingPoint)
    {
        $logModel = $gradingPoint;

        if ($gradingPoint->delete()) {
            activity()
                ->performedOn($logModel)
                ->causedBy($request->user())
                ->log('deleted grading point');
            return response()->json([
                'message' => 'deleted successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'unable to delete'
        ], 409);
    }
}

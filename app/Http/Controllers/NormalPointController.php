<?php

namespace App\Http\Controllers;

use App\NormalPoint;
use Illuminate\Http\Request;

class NormalPointController extends Controller
{
    public function __construct(NormalPoint $normalPoint)
    {
        $this->normalPoint = $normalPoint;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manageNormalPoints()
    {
        // $normalPoints = $this->normalPoint->all();

        // return view('pages.normal-point.index', compact('normalPoint'));
        return view('pages.manage-normal-points');
    }

    public function indexApi()
    {
        return $this->normalPoint->with('normalCategory')->orderBy('updated_at', 'desc')->get();
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
        if ($normalPoint = $this->normalPoint->create($request->all())) {
            activity()
                ->performedOn($normalPoint)
                ->causedBy($request->user())
                ->withProperties($normalPoint->toArray())
                ->log('created a normal point');
            return $normalPoint;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NormalPoint  $normalPoint
     * @return \Illuminate\Http\Response
     */
    public function updateApi(Request $request, NormalPoint $normalPoint)
    {
        $normalPoint->fill($request->all());

        if ($normalPoint->isDirty()) {
            if ($normalPoint->save()) {
                activity()
                    ->performedOn($normalPoint)
                    ->causedBy($request->user())
                    ->withProperties($normalPoint->toArray())
                    ->log('updated normal point');
            }
        }
 
        return $normalPoint;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NormalPoint  $normalPoint
     * @return \Illuminate\Http\Response
     */
    public function showApi(NormalPoint $normalPoint)
    {
        return $normalPoint;//->load('normalCategory');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NormalPoint  $normalPoint
     * @return \Illuminate\Http\Response
     */
    public function edit($normalPointId)
    {
        return view('pages.edit-normal-point', compact('normalPointId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NormalPoint  $normalPoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NormalPoint $normalPoint)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NormalPoint  $normalPoint
     * @return \Illuminate\Http\Response
     */
    public function destroyApi(NormalPoint $normalPoint)
    {
        $logModel = $normalPoint;
        if ($normalPoint->delete()) {
            activity()
                ->performedOn($logModel)
                ->causedBy(request()->user())
                ->log('deleted normal point');
            return response()->json([
                'message' => 'deleted successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'unable to delete'
        ], 409);
    }
}

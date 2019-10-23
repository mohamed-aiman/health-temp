<?php

namespace App\Http\Controllers;

use App\NormalInspection;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NormalInspectionController extends Controller
{
    public function __construct(NormalInspection $inspection)
    {
        $this->inspection = $inspection;
    }
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function manageNormalInspections()
    // {
    //     // $inspections = $this->inspection->all();

    //     // return view('pages.normal-point.index', compact('inspection'));
    //     return view('pages.manage-normal-points');
    // }

    // public function indexApi()
    // {
    //     return $this->inspection->orderBy('updated_at', 'desc')->get();
    // }
    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function storeApi(Request $request)
    // {
    //     return $this->inspection->create($request->all());
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Inspection $inspection)
    // {
    //     $inspection->fill([
    //         'inspection_at' => $request->inspection_at,
    //         'status' => $request->status,
    //     ]);

    //     $inspection->save();

    //     return $inspection;

    //     // return $this->inspection->with('business')->findOrFail($inspection->id);
    // }

    // *
    //  * Display the specified resource.
    //  *
    //  * @param  \App\NormalInspection  $inspection
    //  * @return \Illuminate\Http\Response
     
    // public function showApi(NormalInspection $inspection)
    // {
    //     return $inspection;
    // }
    

    public function upcoming()
    {
        return view('pages.upcomming-normal-inspections');
    }

    public function upcomingApi()
    {
        $inspections = $this->inspection
        ->with(['business'])
        ->where('inspection_at', '>=' , Carbon::now())
        ->orderBy('inspection_at', 'asc')->get();
        return $inspections;
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\NormalInspection  $inspection
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit(NormalInspection $inspection)
    {
        return 'TODO check this method and pages.edit-normal-inspection';
        return view('pages.edit-normal-inspection', compact('inspection'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\NormalInspection  $inspection
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, NormalInspection $inspection)
    // {
        
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\NormalInspection  $inspection
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroyApi(NormalInspection $inspection)
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

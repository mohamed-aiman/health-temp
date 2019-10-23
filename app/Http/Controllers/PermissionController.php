<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function index()
    {
        return $this->permission->get();
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
    public function store(Request $request)
    {
        if ($permission = $this->permission->create($request->all())) {
            activity()
                ->performedOn($permission)
                ->causedBy($request->user())
                ->withProperties($permission->toArray())
                ->log('created a permission');
            return $permission;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $permission->fill($request->all());

        if ($permission->isDirty()) {
            if ($permission->save()) {
                activity()
                    ->performedOn($permission)
                    ->causedBy($request->user())
                    ->withProperties($permission->toArray())
                    ->log('updated a permission');
            }
        }
 
        return $permission;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return $permission;//->load('gradingCategory');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($permissionId)
    {
        return view('pages.edit-permission', compact('permissionId'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $logModel = $permission;
        if ($permission->delete()) {
            activity()
                ->performedOn($permission)
                ->causedBy($request->user())
                ->log('deleted a permission');

            return response()->json([
                'message' => 'deleted successfully'
            ], 204);
        }

        return response()->json([
            'message' => 'unable to delete'
        ], 409);
    }
}

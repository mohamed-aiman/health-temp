<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function index()
    {
        return $this->role->get();
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
        $validated = $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        $data = array_merge($validated, ['slug' => $this->makeSlug($request->name)]);

        if ($role = $this->role->create($data)) {
            activity()
                ->performedOn($role)
                ->causedBy($request->user())
                ->withProperties($role->toArray())
                ->log('created a role');

            return $role;
        }
    }

    protected function makeSlug($name)
    {
        return Str::slug($name, '_');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        $data = array_merge($validated, ['slug' => $this->makeSlug($request->name)]);

        $role->fill($data);

        if ($role->isDirty()) {
            if ($role->save()) {
                activity()
                    ->performedOn($role)
                    ->causedBy($request->user())
                    ->withProperties($role->toArray())
                    ->log('updated a role');
            }
        }
 
        return $role;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $role;//->load('gradingCategory');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($roleId)
    {
        return view('pages.edit-role', compact('roleId'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try {
            $logModel = $role;
            if ($role->delete()) {
                activity()
                    ->performedOn($role)
                    ->causedBy(request()->user())
                    ->log('deleted a role');
                
                return response()->json(['message' => 'deleted successfully.'], Response::HTTP_NO_CONTENT);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return $this->user->get();
    }

    public function show(User $user)
    {
        return $user;
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
            'name' => 'required',
            'email' => 'required|unique:users,email',
        ]);

        $data = array_merge($validated, ['password' => $this->makePassword()]);

        if ($user = $this->user->create($data)) {
            activity()
                ->performedOn($user)
                ->causedBy($request->user())
                ->withProperties($user->toArray())
                ->log('created a user');
            return $user;
        }
    }

    public function edit($userId)
    {
        return view('pages.edit-user', compact('userId'));
    }

    protected function makePassword()
    {
        return Str::random(8);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => '',
            // 'email' => 'unique:users,email',
        ]);

        $data = array_merge($validated, ['password' => $this->makePassword()]);

        $user->fill($data);

        if ($user->isDirty()) {
            if ($user->save()) {
                $user = $user->fresh();
                activity()
                    ->performedOn($user)
                    ->causedBy($request->user())
                    ->withProperties($user->toArray())
                    ->log('updated a user');
            }
        }

        return $user;
    }

    public function permissions(Request $request)
    {
        if ($user = $request->user()) {
            return $request->user()->permissions->pluck('slug');
        }

        throw new \Illuminate\Auth\AuthenticationException();
    }

    public function destroy(User $user)
    {
        try {
            $logModel = $user;
            if ($user->delete()) {
                activity()
                    ->performedOn($user)
                    ->causedBy(request()->user())
                    ->log('deleted a user');
                return response()->json(['message' => 'deleted successfully.'], Response::HTTP_NO_CONTENT);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    public function inspectorsList()
    {
        return User::whereHas('roles', function($query) {
            $query->where('slug', 'inspector');
        })->get();
    }
}

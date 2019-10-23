<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next, $slug = null)
    {
        if(!$this->check($request)) {
            return response()->json(['errors' => [
                [
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'details' => 'You are not authorized to access this resource.'
                ]
            ]], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }

    public function check(Request $request)
    {
        if (\Config::get('acl.disabled')) {
            return true;
        }

        $user = $request->user();

        if (!$user) {
            return false;
        }

        return $user->hasPermission($request->route()->getName());
    }
}


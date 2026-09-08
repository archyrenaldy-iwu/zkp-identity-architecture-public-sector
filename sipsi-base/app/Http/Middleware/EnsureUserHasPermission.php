<?php

namespace App\Http\Middleware;

use Closure;
use Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = Route::currentRouteName();
        $activeRole = getActiveRole();

        if (! Auth::user()) {
            return response()->json([
                'message' => 'Harap login.',
                'http_code' => Constant::HTTP_CODE_UNAUTHORISED,
            ]);
        }

        // Retrieve user and active role
        $user = Auth::user();
        $role = $user->roles()->where('name', $activeRole)->first();

        if (! $role) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        // Check if the active role has the permission to access the route
        if (! $role->hasPermissionTo($routeName)) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        return $next($request);
    }
}

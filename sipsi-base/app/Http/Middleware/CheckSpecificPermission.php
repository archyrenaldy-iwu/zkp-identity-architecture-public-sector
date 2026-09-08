<?php

namespace App\Http\Middleware;

use Closure;
use Constant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSpecificPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if (! checkSpecificPermission($permission)) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        return $next($request);
    }
}

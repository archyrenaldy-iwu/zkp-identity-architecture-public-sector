<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class XSS
{
    public function handle($request, Closure $next)
    {
        try {
            $userInput = $request->all();
            array_walk_recursive($userInput, function (&$input) {
                if (is_string($input)) {
                    $input = strip_tags($input);
                }
            });
            $request->merge($userInput);
        } catch (\Exception $e) {
            Log::error('XSS Middleware error: '.$e->getMessage());

            return response('Server Error', 500);
        }

        return $next($request);
    }
}

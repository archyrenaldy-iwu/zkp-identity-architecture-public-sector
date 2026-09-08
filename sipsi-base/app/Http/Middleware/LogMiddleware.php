<?php

namespace App\Http\Middleware;

use ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $method = $request->getMethod();
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\Response || $response instanceof \Illuminate\Http\RedirectResponse || $response instanceof \Illuminate\Http\JsonResponse) {
            ActivityLog::urlAccess($request, $response->status());

            $methodToWriteActivity = ['POST', 'PUT', 'DELETE'];
            if (in_array($method, $methodToWriteActivity)) {
                $action = $request->route()->getAction();
                $controller = class_basename($action['controller']);
                $content = $response->getContent();
                $responseData = json_decode($content, true);

                if (isset($responseData['success']) && $responseData['success'] == true) {
                    ActivityLog::activity(
                        request: $request,
                        status_code: $response->status(),
                        activity: $controller,
                        requestData: $request->all(),
                        message: $responseData['message']
                    );
                }
            }

        } elseif ($response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse) {
            ActivityLog::urlAccess($request, $response->getStatusCode());
        } else {
            ActivityLog::urlAccess($request, '-');
        }

        return $response;
    }
}

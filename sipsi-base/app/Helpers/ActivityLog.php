<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityLog
{
    public static function activity(Request $request, $status_code, $activity = null, $requestData = null, $message = null)
    {
        $id_user = Auth::check() ? Auth::user()->id : null;
        $username = Auth::check() ? Auth::user()->username : null;
        $role = getActiveRole() ?? null;

        $data = [
            'activity' => $activity,
            'timestamp' => date('Y-m-d H:i:s'),
            'url' => $request->url(),
            'http_code' => $status_code,
            'method' => $request->getMethod(),
            'id_user' => $id_user,
            'username' => $username,
            'role' => $role,
            'message' => $message,
            'data_request' => $requestData,
            'ip_address' => self::getIp(),
        ];

        Log::channel('activity_log')->info('', $data);
    }

    public static function urlAccess(Request $request, $status_code)
    {
        $id_user = Auth::check() ? Auth::user()->id : null;
        $username = Auth::check() ? Auth::user()->username : null;
        $role = getActiveRole() ?? null;

        $data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'http_method' => $request->getMethod(),
            'url' => $request->url(),
            'status_code' => $status_code,
            'id_user' => $id_user,
            'username' => $username,
            'role' => $role,
            'ip_address' => self::getIp(),
        ];

        Log::channel('log_url_access')->info('', $data);
    }

    public static function file($method, $pathFile)
    {
        $id_user = Auth::check() ? Auth::user()->id : null;
        $username = Auth::check() ? Auth::user()->username : null;
        $role = getActiveRole() ?? null;

        $data = [
            'timestamp' => date('Y-m-d H:i:s'),
            'method' => $method,
            'path_file' => $pathFile,
            'id_user' => $id_user,
            'username' => $username,
            'role' => $role,
        ];

        Log::channel('log_file')->info('', $data);
    }

    public static function getIp()
    {
        foreach (['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'] as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }

        return request()->ip(); // it will return server ip when no client ip found
    }
}

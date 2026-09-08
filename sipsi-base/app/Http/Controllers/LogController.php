<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class LogController extends Controller
{
    public function downloadLog($filename = null)
    {
        // Default directory for logs
        $logDirectory = storage_path('logs');

        if ($filename) {
            // If a filename is provided, use it
            $filePath = $logDirectory.'/'.$filename;
        } else {
            // Get the latest log file starting with "laravel_" if no filename is provided
            $files = File::files($logDirectory);
            $latestFile = collect($files)->filter(function ($file) {
                return strpos($file->getFilename(), 'laravel-') === 0;
            })->sortByDesc(function ($file) {
                return $file->getMTime();
            })->first();

            $filePath = $latestFile ? $latestFile->getPathname() : null;
        }

        if ($filePath && File::exists($filePath)) {
            return Response::download($filePath);
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\ZkpService;
use Illuminate\Http\Request;

class ZkpController extends Controller
{
    protected $zkpService;

    public function __construct(ZkpService $zkpService)
    {
        $this->zkpService = $zkpService;
    }

    public function isApproved($nomorIdentitas)
    {
        try {
            $approved = $this->zkpService->isApproved($nomorIdentitas);
            return response()->json(['approved' => $approved]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} 
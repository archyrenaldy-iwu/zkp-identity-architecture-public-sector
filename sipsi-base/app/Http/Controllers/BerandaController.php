<?php

namespace App\Http\Controllers;

use App\Services\BerandaService;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    const ROUTE_PAGE = 'beranda';

    private BerandaService $service;

    public function __construct(BerandaService $service)
    {
        $this->service = $service;
    }

    public function summary(Request $request)
    {
        if ($request->ajax()) {
            return responseJson($this->service->summary($request));
        }
    }

    public function download(Request $request)
    {
        if ($request->ajax()) {
            return $this->service->download($request);
        }
    }
}

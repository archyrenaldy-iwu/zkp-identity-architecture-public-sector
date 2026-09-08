<?php

namespace App\Http\Controllers;

use App\Http\Requests\PutusanCreateRequest;
use App\Services\PutusanService;
use Illuminate\Http\Request;

class PutusanController extends Controller
{
    const ROUTE_PAGE = 'putusan';

    private PutusanService $service;

    public function __construct(PutusanService $service)
    {
        $this->service = $service;
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->service->list($request->all());

            return datatables()->of($data)->make(true);
        }
    }

    public function create(PutusanCreateRequest $request)
    {
        if ($request->ajax()) {
            return responseJson($this->service->create($request->all()));
        }
    }

    public function delete(Request $request, $id)
    {
        return responseJson($this->service->delete($id));
    }
}

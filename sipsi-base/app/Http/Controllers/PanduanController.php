<?php

namespace App\Http\Controllers;

use App\Http\Requests\PanduanCreateRequest;
use App\Services\PanduanService;
use Illuminate\Http\Request;

class PanduanController extends Controller
{
    private PanduanService $service;

    public function __construct(PanduanService $service)
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

    public function create(PanduanCreateRequest $request)
    {
        if ($request->ajax()) {
            return responseJson($this->service->create($request->all()));
        }
    }

    public function destroy($id)
    {
        return responseJson($this->service->destroy($id));
    }
}

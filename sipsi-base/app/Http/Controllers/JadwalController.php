<?php

namespace App\Http\Controllers;

use App\Http\Requests\JadwalCreateRequest;
use App\Services\JadwalService;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    const ROUTE_PAGE = 'jadwal-sidang';

    private JadwalService $service;

    public function __construct(JadwalService $service)
    {
        $this->service = $service;
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            return $this->service->list($request->all());
        }
    }

    public function listSengketa(Request $request)
    {
        if ($request->ajax()) {
            return $this->service->listSengketa($request->all());
        }
    }

    public function historySidangSengketa($id_sengketa)
    {
        $data = $this->service->historySidangSengketa($id_sengketa);

        return datatables()->of($data)->make(true);
    }

    public function create(JadwalCreateRequest $request)
    {
        if ($request->ajax()) {
            return responseJson($this->service->create($request->all()));
        }
    }

    public function delete(Request $request, $id)
    {
        return responseJson($this->service->delete($request->all(), $id));
    }

    public function reelasCreate($id)
    {
        return responseJson($this->service->reelasCreate($id));
    }

    public function reelasSend($id)
    {
        return responseJson($this->service->reelasSend($id));
    }
}

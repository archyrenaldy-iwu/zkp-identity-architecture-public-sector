<?php

namespace App\Http\Controllers;

use App\Http\Requests\KiCreateRequest;
use App\Http\Requests\KiUpdateRequest;
use App\Services\KiService;

class KiController extends Controller
{
    private KiService $service;

    public function __construct(KiService $service)
    {
        $this->service = $service;
    }

    public function create(KiCreateRequest $request)
    {
        if ($request->ajax()) {
            return responseJson($this->service->create($request->all()));
        }
    }

    public function show($id)
    {
        return responseJson($this->service->show($id));
    }

    public function update(KiUpdateRequest $request, $id)
    {
        if ($request->ajax()) {
            return responseJson($this->service->update($request->all(), $id));
        }

    }

    public function destroy($id)
    {
        return responseJson($this->service->destroy($id));
    }

    public function list()
    {
        return $this->service->list();
    }
}

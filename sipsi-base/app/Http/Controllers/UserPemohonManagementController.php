<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPemohonCreateRequest;
use App\Http\Requests\UserPemohonUpdateRequest;
use App\Services\UserPemohonService;
use Illuminate\Http\Request;

class UserPemohonManagementController extends Controller
{
    private UserPemohonService $service;

    public function __construct(UserPemohonService $service)
    {
        $this->service = $service;
    }

    public function create(UserPemohonCreateRequest $request)
    {
        if ($request->ajax()) {
            return responseJson($this->service->create($request->all()));
        }

    }

    public function show($id)
    {
        return responseJson($this->service->show($id));
    }

    public function update(UserPemohonUpdateRequest $request, $id)
    {
        if ($request->ajax()) {
            return responseJson($this->service->update($request->all(), $id));
        }

    }

    public function destroy($id)
    {
        return responseJson($this->service->destroy($id));

    }

    public function list(Request $request)
    {
        return $this->service->list($request->all());
    }
}

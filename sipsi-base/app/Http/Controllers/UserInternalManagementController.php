<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserInternalCreateRequest;
use App\Http\Requests\UserInternalUpdateRequest;
use App\Services\UserInternalService;

class UserInternalManagementController extends Controller
{
    private UserInternalService $service;

    public function __construct(UserInternalService $service)
    {
        $this->service = $service;
    }

    public function create(UserInternalCreateRequest $request)
    {
        if ($request->ajax()) {
            return responseJson($this->service->create($request->all()));
        }
    }

    public function show($id)
    {
        return responseJson($this->service->show($id));
    }

    public function update(UserInternalUpdateRequest $request, $id)
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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SengketaBatalRequest;
use App\Http\Requests\SengketaCabutRequest;
use App\Http\Requests\SengketaCreateRequest;
use App\Http\Requests\SengketaSavePerangkatRequest;
use App\Http\Requests\SengketaUpdateRequest;
use App\Services\DocGeneratorService;
use App\Services\SengketaService;
use Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Permissions;
use Roles;

class SengketaController extends Controller
{
    const ROUTE_PAGE = 'sengketa';

    private SengketaService $service;

    private DocGeneratorService $docGeneratorService;

    public function __construct(SengketaService $service, DocGeneratorService $docGeneratorService)
    {
        $this->service = $service;
        $this->docGeneratorService = $docGeneratorService;
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->service->list($request->all());

            return datatables()->of($data)->make(true);
        }
    }

    public function show($id)
    {
        return responseJson($this->service->show($id));
    }

    //NOT GUARDED
    public function lacak($id)
    {
        return responseJson($this->service->lacak($id));
    }

    public function create(SengketaCreateRequest $request)
    {
        if ($request->ajax()) {
            return responseJson($this->service->create($request->all()));
        }
    }

    public function terima(Request $request, $id)
    {
        if ($request->ajax()) {
            return responseJson($this->service->terima($request->all(), $id));
        }
    }


    public function tolak(Request $request, $id)
    {
        if ($request->ajax()) {
            return responseJson($this->service->tolak($request->all(), $id));
        }
    }

    public function update(SengketaUpdateRequest $request, $id)
    {
        if ($request->ajax()) {
            return responseJson($this->service->update($request->all(), $id));
        }
    }

    public function batal(SengketaBatalRequest $request, $id)
    {
        if ($request->ajax()) {
            if ($request->type == 'pengajuan') {
                return responseJson($this->service->batalPengajuan($request->all(), $id));
            } elseif ($request->type == 'konfirmasi' && Auth::user()->can(Permissions::FITUR_SENGKETA_BATAL_KONFIRMASI)) {
                return responseJson($this->service->batalKonfirmasi($request->all(), $id));
            }
        }
    }

    public function cabut(SengketaCabutRequest $request, $id)
    {
        if ($request->ajax()) {
            if ($request->type == 'pengajuan') {
                return responseJson($this->service->cabutPengajuan($request->all(), $id));
            } elseif ($request->type == 'konfirmasi' && Auth::user()->can(Permissions::FITUR_SENGKETA_CABUT_KONFIRMASI)) {
                return responseJson($this->service->cabutKonfirmasi($request->all(), $id));
            }
        }
    }

    public function delete(Request $request, $id)
    {
        return responseJson($this->service->delete($request->all(), $id));
    }

    public function listPemohon(Request $request)
    {
        if (getActiveRole() != Roles::ROLE_PEMOHON && $request->ajax()) {
            return responseJson($this->service->listPemohon($request->all()));
        }

        abort(Constant::HTTP_CODE_UNAUTHORISED);
    }

    public function listUserKi(Request $request)
    {
        if (getActiveRole() != Roles::ROLE_PEMOHON && $request->ajax()) {
            return responseJson($this->service->listUserKi($request->all()));
        }

        abort(Constant::HTTP_CODE_UNAUTHORISED);
    }

    public function savePerangkat(SengketaSavePerangkatRequest $request, $id)
    {
        if ($request->ajax()) {
            return responseJson($this->service->savePerangkat($request->all(), $id));
        }
    }
}

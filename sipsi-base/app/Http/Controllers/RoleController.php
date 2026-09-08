<?php

namespace App\Http\Controllers;

use Constant;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function getPermission($roleId)
    {
        $permissions = DB::table('permissions as p')
            ->leftJoin('role_has_permissions as rhp', function ($join) use ($roleId) {
                $join->on('p.id', '=', 'rhp.permission_id')
                    ->where('rhp.role_id', '=', $roleId);
            })
            ->select(
                'p.id',
                'p.description',
                'p.parent_id',
                DB::raw('CASE WHEN rhp.role_id IS NOT NULL THEN TRUE ELSE FALSE END AS has_access')
            )
            //sort by id
            ->orderBy('p.id')
            ->get();

        //if role id != 1, remove permission name panduan.create and panduan.destroy
        if ($roleId != 1) {
            //remove permission name panduan.create and panduan.destroy
            $permissions = $permissions->filter(function ($permission) {
                return $permission->id != 54 && $permission->id != 55;
            });
        }

        // Convert the result to an array
        $permissions = $permissions->toArray();

        // Group permissions by parent_id
        $groupedPermissions = [];
        foreach ($permissions as $permission) {
            if (is_null($permission->parent_id)) {
                $groupedPermissions[$permission->id] = (array) $permission;
                $groupedPermissions[$permission->id]['children'] = [];
            } else {
                if (isset($groupedPermissions[$permission->parent_id])) {
                    $groupedPermissions[$permission->parent_id]['children'][] = (array) $permission;
                }
            }
        }
        // Reset the keys to get the desired format
        $result = array_values($groupedPermissions);

        return responseJson([
            'success' => true,
            'message' => 'Data ditemukan',
            'data' => $result,
            'http_code' => Constant::HTTP_CODE_SUCCESS,
        ]);
    }

    public function updatePermission($roleId)
    {
        if ($roleId == 1) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }
        $permissions = request()->input('permissions');

        DB::beginTransaction();
        try {
            DB::table('role_has_permissions')->where('role_id', $roleId)->delete();

            foreach ($permissions as $permission) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $roleId,
                    'permission_id' => $permission,
                ]);
            }

            DB::commit();

            Artisan::call('permission:cache-reset');

            return responseJson([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'http_code' => Constant::HTTP_CODE_SUCCESS_ENTRY,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return responseJson([
                'success' => false,
                'message' => Constant::HTTP_CODE_ERROR_SERVER_MESSAGE.' Gagal menyimpan data',
                'http_code' => Constant::HTTP_CODE_ERROR_SERVER,
            ]);
        }
    }
}

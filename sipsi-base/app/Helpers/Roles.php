<?php

use App\Models\Permission;
use App\Models\RoleHasPermissions;
use Illuminate\Support\Facades\Log;

class Roles
{
    const ID_ROLE_SUPERADMIN = 1;

    const ROLE_SUPERADMIN = 'super-admin';

    const DESC_ROLE_SUPERADMIN = 'Super Admin';

    const ID_ROLE_PEMOHON = 2;

    const ROLE_PEMOHON = 'pemohon';

    const DESC_ROLE_PEMOHON = 'Pemohon';

    const ID_ROLE_ADMIN_BERKAS = 3;

    const ROLE_ADMIN_BERKAS = 'admin-berkas';

    const DESC_ROLE_ADMIN_BERKAS = 'Admin Berkas';

    const ID_ROLE_SEKERTARIS = 4;

    const ROLE_SEKERTARIS = 'sekertaris';

    const DESC_ROLE_SEKERTARIS = 'Sekertaris';

    const ID_ROLE_PANITERA = 5;

    const ROLE_PANITERA = 'panitera';

    const DESC_ROLE_PANITERA = 'Panitera';

    const ID_ROLE_MK = 6;

    const ROLE_MK = 'majelis-komisioner';

    const DESC_ROLE_MK = 'Majelis Komisioner';

    const ID_ROLE_ADMIN_KI = 7;

    const ROLE_ADMIN_KI = 'admin-ki';

    const DESC_ADMIN_KI = 'Admin KI';

    const ID_ROLE_PANITERA_PENGGANTI = 7;

    const ROLE_PANITERA_PENGGANTI = 'panitera-pengganti';

    const DESC_PANITERA_PENGGANTI = 'Panitera Pengganti';

    public static function writePermissionRoleHasPermission($menu)
    {
        $permissionName = $menu->permission;
        $description = $menu->description;
        $roleSuperAdmin = $menu->super_admin;
        $rolePemohon = $menu->pemohon;

        $permission = Permission::create(['guard_name' => 'web', 'name' => $permissionName, 'description' => $description, 'parent_id' => (isset($menu->parent_id) ? $menu->parent_id : null)]);

        if ($roleSuperAdmin) {
            RoleHasPermissions::create([
                'permission_id' => $permission->id,
                'role_id' => self::ID_ROLE_SUPERADMIN,
            ]);
        }

        if ($rolePemohon) {
            RoleHasPermissions::create([
                'permission_id' => $permission->id,
                'role_id' => self::ID_ROLE_PEMOHON,
            ]);
        }
    }

    public static function updatePermissionRole()
    {
        DB::beginTransaction();

        try {
            RoleHasPermissions::truncate();
            Permission::truncate();

            $listMenu = DB::table('hak_akses_menu')->get();

            foreach ($listMenu as $menu) {

                if ($menu->permission) {
                    self::writePermissionRoleHasPermission($menu);
                }
            }

            $listFitur = DB::table('hak_akses_fitur')->get();
            foreach ($listFitur as $fitur) {

                if ($fitur->permission) {
                    self::writePermissionRoleHasPermission($fitur);
                }
            }

            DB::commit();

            echo "\e[0;32mPermission Role Updated.\e[0m\n";

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            echo "\e[0;31mUpdate Permssion Role Failed !\e[0m\n";
        }

    }
}

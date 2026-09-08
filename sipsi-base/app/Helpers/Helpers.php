<?php

use App\Models\JenisSidangPutusan;
use App\Models\KiConfig;
use App\Models\Penomoran;
use App\Models\Sengketa;
use App\Models\SengketaHistory;
use App\Models\User;
use Spatie\Permission\Models\Role;

//fungsi ini digunakan untuk return response json
if (! function_exists('responseJson')) {
    function responseJson($response)
    {
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'] ?? null,
            'errors' => $response['errors'] ?? null,
            'data' => $response['data'] ?? null,
            'hash' => $response['hash'] ?? null,
        ], $response['http_code']);
    }
}

//fungsi ini digunakan untuk mmebuat nomor surat berdasarkan template
if (! function_exists('generateNomor')) {
    function generateNomor($id_ki, $jenis, $no_registrasi_online = null)
    {
        $currentYear = now()->year;

        $ki_config = KiConfig::firstWhere('id', $id_ki);
        if (! $ki_config) {
            abort(Constant::HTTP_CODE_ERROR_NOT_FOUND);
        }

        $nomor = 0;

        if ($jenis == Constant::TEMPLATE_KODE_AKTA_REGISTRASI || $jenis == Constant::TEMPLATE_KODE_NOMOR_SENGKETA) {
            $nomor = intval($no_registrasi_online);

        } else {
            $lastNomor = Penomoran::where('id_ki', $id_ki)
                ->where('tahun', $currentYear)
                ->where('jenis', $jenis)
                ->orderBy('id', 'desc')
                ->first();
            $nomor = $lastNomor ? intval($lastNomor->nomor) + 1 : 1;
        }

        $formattedNomor = sprintf('%03d', $nomor);
        $template_nomor = '';
        if ($jenis == Constant::TEMPLATE_KODE_REGISTRASI_ONLINE) {
            $template_nomor = $formattedNomor;
        } else {
            $template_nomor = $ki_config->{$jenis};
            $template_nomor = str_replace('{nomor}', $formattedNomor, $template_nomor);
            $template_nomor = str_replace('{bulan}', getCurrentMonthInRoman(), $template_nomor);
            $template_nomor = str_replace('{tahun}', $currentYear, $template_nomor);
        }

        Penomoran::create([
            'jenis' => $jenis,
            'id_ki' => $id_ki,
            'tahun' => $currentYear,
            'nomor' => $nomor,
            'hasil' => $template_nomor,
        ]);

        return $template_nomor;
    }
}

//fungsi ini digunakan untuk mengambil uuid
if (! function_exists('getUUID')) {
    function getUUID()
    {
        return Str::uuid()->toString();
    }
}

//fungsi untuk mengubah bulan saat ini menjadi romawi
if (! function_exists('getCurrentMonthInRoman')) {
    function getCurrentMonthInRoman()
    {
        $month = now()->month;  // Get the current month number

        $romans = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        return $romans[$month] ?? null;
    }
}

//fungsi untuk menegcek apakah role user yang sedang login
if (! function_exists('getActiveRole')) {
    function getActiveRole($role = null)
    {
        if ($role) {
            if (session(Constant::SESSION_ACTIVE_ROLE) == $role) {
                return true;
            }

            return false;
        }

        return session(Constant::SESSION_ACTIVE_ROLE);
    }
}

//fungsi untuk mengambil data KiConfig
if (! function_exists('getListKiConfig')) {
    function getListKiConfig()
    {
        if (Auth::check()) {
            if (getActiveRole(Roles::ROLE_SUPERADMIN) || getActiveRole(Roles::ROLE_PEMOHON)) {
                return KiConfig::select('id', 'nama')->get();
            } else {
                return KiConfig::select('id', 'nama')
                    ->where('id', idKiAuth())
                    ->get();
            }
        } else {
            return KiConfig::select('id', 'nama')
                ->where('id', idKiAuth())
                ->get();
        }
    }
}

//fungsi untuk mengambil data role tanpa pemohon
if (! function_exists('getRoles')) {
    function getRoles()
    {
        //role pemohon dan super admin tidak diambil
        return Role::select('id', 'name', 'description')
            ->where('name', '!=', Roles::ROLE_PEMOHON)
            ->where('name', '!=', Roles::ROLE_SUPERADMIN)
            ->get();
    }
}

//fungsi untuk mengambil data role tanpa super admin
if (! function_exists('getRolesWithoutSuperAdmin')) {
    function getRolesWithoutSuperAdmin()
    {
        //role super admin tidak diambil
        return Role::select('id', 'name', 'description')
            ->where('name', '!=', Roles::ROLE_SUPERADMIN)
            ->get();
    }
}

//fungsi untuk mengambil semua data role
if (! function_exists('getRolesAll')) {
    function getRolesAll()
    {
        return Role::select('id', 'name', 'description')->get();
    }
}

//fungsi untuk custom hak akses
if (! function_exists('checkSpecificPermission')) {
    function checkSpecificPermission($permission)
    {
        $activeRole = getActiveRole();

        if (! Auth::user()) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        // Retrieve user and active role
        $user = Auth::user();
        $role = $user->roles()->where('name', $activeRole)->first();

        if (! $role) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        // Check if the active role has the permission to access the route
        if (! $role->hasPermissionTo($permission)) {
            abort(Constant::HTTP_CODE_UNAUTHORISED);
        }

        return true;
    }
}

if (! function_exists('getPermissionsForActiveRole')) {
    function getPermissionsForActiveRole()
    {
        $activeRole = getActiveRole();
        $user = Auth::user();
        $role = $user->roles()->where('name', $activeRole)->first();

        if (! $role) {
            return [];
        }

        return $role->permissions->pluck('name')->toArray();
    }
}

//fungsi untuk mengambil list jenis sidang
if (! function_exists('getJenisSidang')) {
    function getJenisSidang()
    {
        return JenisSidangPutusan::where('jenis', 'sidang')->get();
    }
}

//fungsi untuk mengambil list jenis putusan
if (! function_exists('getJenisPutusan')) {
    function getJenisPutusan()
    {
        return JenisSidangPutusan::where('jenis', 'putusan')->get();
    }
}

//fungsi untuk mengambil list status
if (! function_exists('getListStatusSengketa')) {
    function getListStatusSengketa()
    {
        $list = [
            (object) ['id' => Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI, 'nama' => Constant::STATUS_SENGKETA_MENUNGGU_VERFIKASI_TEXT],
            (object) ['id' => Constant::STATUS_SENGKETA_PENGAJUAN_ULANG, 'nama' => Constant::STATUS_SENGKETA_PENGAJUAN_ULANG_TEXT],
            (object) ['id' => Constant::STATUS_SENGKETA_TERVERIFIKASI, 'nama' => Constant::STATUS_SENGKETA_TERVERIFIKASI_TEXT],
            (object) ['id' => Constant::STATUS_SENGKETA_DITOLAK, 'nama' => Constant::STATUS_SENGKETA_DITOLAK_TEXT],
            (object) ['id' => Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN, 'nama' => Constant::STATUS_SENGKETA_MENUNGGU_PEMBATALAN_TEXT],
            (object) ['id' => Constant::STATUS_SENGKETA_DIBATALKAN, 'nama' => Constant::STATUS_SENGKETA_DIBATALKAN_TEXT],
            (object) ['id' => Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN, 'nama' => Constant::STATUS_SENGKETA_MENUNGGU_PENCABUTAN_TEXT],
            (object) ['id' => Constant::STATUS_SENGKETA_DICABUT, 'nama' => Constant::STATUS_SENGKETA_DICABUT_TEXT],
            (object) ['id' => Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG, 'nama' => Constant::STATUS_SENGKETA_DALAM_PROSES_SIDANG_TEXT],
            (object) ['id' => Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN, 'nama' => Constant::STATUS_SENGKETA_DALAM_PROSES_PUTUSAN_TEXT],
            (object) ['id' => Constant::STATUS_SENGKETA_SELESAI, 'nama' => Constant::STATUS_SENGKETA_SELESAI_TEXT],
        ];

        if (getActiveRole(Roles::ROLE_SUPERADMIN)) {
            $list[] = (object) ['id' => Constant::STATUS_SENGKETA_DIHAPUS, 'nama' => Constant::STATUS_SENGKETA_DIHAPUS_TEXT];
        }

        return $list;
    }
}

//fungsi untuk update semua is_current history sengketa
if (! function_exists('updateHistoryIsCurrent')) {
    function updateHistoryIsCurrent($id_sengketa)
    {
        if (app()->runningInConsole()) {
            return true;
        }

        checkSpecificPermission(Permissions::FITUR_SENGKETA_LIST);

        try {
            SengketaHistory::where('id_sengketa', $id_sengketa)->update(['is_current' => false]);
            Log::info('Set is current false sengketa history. ID Sengketa: '.$id_sengketa);

            return true;
        } catch (Exception $e) {
            Log::error('Exception caught in '.__CLASS__.'::'.__FUNCTION__.': '.$e->getMessage(), [
                'class' => get_class($e),
                'code' => $e->getCode(),
                // 'trace' => $e->getTrace(),
                'request' => $id_sengketa,
            ]);

            return false;
        }
    }
}

//fungsi untuk ambil no registrasi sengketa berdasarkan id history atau id sengketa
if (! function_exists('getNoRegistrasi')) {
    function getNoRegistrasi($id, $table = 'sengketa')
    {
        if ($table == 'sengketa') {
            $sengketa = Sengketa::findOrFail($id);
            $result = new stdClass();
            $result->no_registrasi = $sengketa->no_registrasi;
            $result->no_sengketa = $sengketa->no_sengketa;
            $result->enable_tambah_jadwal = $sengketa->is_lengkap_perangkat && ! $sengketa->is_selesai;

            return $result;
        } elseif ($table == 'history') {
            $sengketa = Sengketa::leftJoin('sengketa_history as sh', 'sh.id_sengketa', '=', 'sengketa.id')->where('sh.id', $id)->firstOrFail();
            $result = new stdClass();
            $result->no_registrasi = $sengketa->no_registrasi;
            $result->no_sengketa = $sengketa->no_sengketa;
            $result->id = $sengketa->id_sengketa;

            return $result;
        }
    }
}

//salt password
if (! function_exists('saltPassword')) {
    function saltPassword($password)
    {
        return $password.config('app.salt');
    }
}

//check if logged in user is user internal but not super admin
if (! function_exists('isUserInternal')) {
    function isUserInternal()
    {
        return getActiveRole() != Roles::ROLE_SUPERADMIN && getActiveRole() != Roles::ROLE_PEMOHON;
    }
}

//check if logged in user is user internal but not super admin
if (! function_exists('idKiAuth')) {
    function idKiAuth()
    {
        if (Auth::check() && isUserInternal()) {
            return session(Constant::SESSION_ACTIVE_ID_KI);
        }

        return null;
    }
}

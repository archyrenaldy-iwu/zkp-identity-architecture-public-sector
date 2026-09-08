<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ZkpController;
use App\Models\KiConfig;
use App\Models\User;
use App\Notifications\EmailVerifiedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/download-log/{filename?}', [LogController::class, 'downloadLog'])->name('download-log');

Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = User::find($request->route('id'));

    if (!$user) {
        Log::error('User not found', ['user_id' => $request->route('id')]);

        return redirect('/login')->withErrors('User not found or session expired. Please log in and try again.');
    }

    if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
        Log::error('Invalid hash for user verification', ['user_id' => $user->id]);

        return redirect('/login')->withErrors('Invalid verification link. Please request a new one.');
    }

    if ($user->hasVerifiedEmail()) {
        return redirect('/login')->with('message', 'Your email is already verified.');
    }

    if ($user->markEmailAsVerified()) {
        event(new \Illuminate\Auth\Events\Verified($user));
        Log::info('User email verified', ['user_id' => $user->id]);
        $user->notify(new EmailVerifiedNotification());
    }

    return redirect('/login')->with('verified', true);
})->middleware('signed')->name('verification.verify');

Route::get('/', function () {
    return view('landing.beranda.index');
})->name('landing.beranda');

Route::get('/direktori_putusan', function () {
    return view('landing.direktori_putusan.index');
})->name('direktori_putusan');

Route::prefix('/landing/jadwal_sidang')->group(function () {
    Route::get('/', function () {
        if (request()->ajax()) {
            $users = User::select('*');

            return datatables()->of($users)
                ->editColumn('detail', function ($user) {
                    return '<a href="' . route('detail_jadwal_sidang', $user->id) . '" class="bg-themecolor-primary text-white rounded-lg p-2 text-sm">Detail</a>';
                })
                ->rawColumns(['detail'])
                ->make(true);
        }
        $kiList = KiConfig::select('id', 'nama')->get(); // temporary

        return view('landing.jadwal_sidang.index', compact('kiList'));
    })->name('landing.jadwal_sidang');

    Route::get('/filter', function () {
        return view('landing.jadwal_sidang.filter');
    })->name('schedule.filter');

    Route::get('/{id}', function ($id) {
        return view('landing.jadwal_sidang.show', compact('id'));
    })->name('detail_jadwal_sidang');
});

Route::get('/login', function () {
    // if (Auth::check()) {
    //     return redirect(route('admin.beranda'));
    // }

    return view('auth.login.index');
})->name('login');

Route::get('/register', function () {
    // if (Auth::check()) {
    //     return redirect(route('admin.beranda'));
    // }

    return view('auth.register.index');
})->name('register');

Route::get('/cari_akun', function () {
    return view('auth.lupa_password.cari_akun');
})->name('cari_akun');

Route::get('/verifikasi_email', function () {
    return view('auth.lupa_password.verifikasi_email');
})->name('verifikasi_email');

Route::get('/ganti_sandi/{email}', function () {
    return view('auth.lupa_password.ganti_sandi');
})->name('ganti_sandi');

Route::get('/daftar_sukses', function () {
    return view('auth.register.daftar_sukses');
})->name('daftar_sukses');

Route::get('/informasi-akun', function () {
    return view('admin.pages.informasi_akun.index');
})->name('informasi-akun')->middleware(['auth:sanctum']);

Route::get('/validasi-informasi', function () {
    return view('admin.pages.validasi_informasi.index');
})->name('validasi-informasi')->middleware(['auth:sanctum']);

Route::get('/verifikasi-putusan', function () {
    return view('admin.pages.verifikasi_putusan.index');
})->name('verifikasi-putusan')->middleware(['auth:sanctum']);

Route::get('/rekomendasi-informasi', function () {
    return view('admin.pages.rekomendasi_informasi.index');
})->name('rekomendasi-informasi')->middleware(['auth:sanctum']);

// Admin Routes
Route::name('admin.')->prefix('admin')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', function () {
        return view('admin.pages.beranda.index');
    })->name('beranda');

    Route::get('/akun/{id}', function () {
        return view('admin.settings.akun.index');
    })->name('akun');

    Route::get('/sengketa/create', function () {
        return view('admin.pages.sengketa.create');
    })->name('sengketa.create')->middleware('custom.permission:' . Permissions::FITUR_SENGKETA_CREATE);

    Route::get('/sengketa/{id}', function ($id) {
        return view('admin.pages.sengketa.show', compact('id'));
    })->name('sengketa.show')->middleware('custom.permission:' . Permissions::FITUR_SENGKETA_SHOW);

    Route::get('/sengketa/edit/{id}', function ($id) {
        return view('admin.pages.sengketa.edit', compact('id'));
    })->name('sengketa.edit')->middleware('custom.permission:' . Permissions::FITUR_SENGKETA_UPDATE);

    Route::get('/sengketa/lacak/{id}', function ($id) {
        return view('admin.pages.sengketa.lacak', compact('id'));
    })->name('sengketa.lacak')->middleware('custom.permission:' . Permissions::FITUR_SENGKETA_LACAK);

    // dokumen sengketa
    Route::get('/sengketa/document/{id}/{path}', function ($id, $path) {
        return view('admin.pages.sengketa.document', compact('id', 'path'));
    })->name('lacak.dokumen');

    Route::get('/jadwal_sidang/show/{id_sengketa}', function ($id_sengketa) {
        return view('admin.pages.jadwal_sidang.show', ['sengketa' => getNoRegistrasi($id_sengketa)]);
    })->name('jadwal_sidang.show');

    Route::get('/jadwal_sidang/reelas/{id_history}', function ($id_history) {
        return view('admin.pages.jadwal_sidang.reelas', ['sengketa' => getNoRegistrasi($id_history, 'history')]);
    })->name('jadwal_sidang.reelas');

    // putusan
    Route::get('/putusan/create/{id}', function ($id) {
        return view('admin.pages.putusan.create', compact('id'));
    })->name('putusan.create');

    // panduan show
    Route::get('/show_panduan', function () {
        return view('admin.pages.panduan.show');
    })->name(Permissions::MENU_PANDUAN . '.show');
});

Route::middleware(['auth:sanctum', 'permission'])->group(function () {
    Route::view('/beranda', 'admin.pages.beranda.index')->name(Permissions::MENU_BERANDA);

    // Sengketa
    Route::view('/sengketa', 'admin.pages.sengketa.index')->name(Permissions::MENU_SENGKETA);
    // Route::view('/admin/sengketa/show/{id}', 'admin.pages.sengketa.index')->name('sengketa.show');
    // Route::view('/admin/sengketa/create', 'admin.pages.sengketa.create')->name('sengketa.createe');

    // jadwal sidang
    Route::get('/jadwal_sidang', function () {
        return view('admin.pages.jadwal_sidang.index');
    })->name(Permissions::MENU_JADWAL);

    // putusan
    Route::get('/putusan', function () {
        return view('admin.pages.putusan.index');
    })->name(Permissions::MENU_PUTUSAN);

    // panduan
    Route::get('/panduan', function () {
        $isSuperAdmin = getActiveRole(Roles::ROLE_SUPERADMIN);

        return view('admin.pages.panduan.index', compact('isSuperAdmin'));
    })->name(Permissions::MENU_PANDUAN);

    // data ki
    Route::get('/data_ki', function () {
        return view('admin.pages.data_ki.index');
    })->name(Permissions::MENU_DATA_KI);

    // kontrol akses
    Route::get('/akun_admin', function () {
        return view('admin.pages.kontrol_akses.akun_admin.index');
    })->name(Permissions::MENU_USER_INTERNAL);

    Route::get('/akun_pemohon', function () {
        return view('admin.pages.kontrol_akses.akun_pemohon.index');
    })->name(Permissions::MENU_USER_PEMOHON);

    Route::get('/role', function () {
        return view('admin.pages.kontrol_akses.role.index');
    })->name(Permissions::MENU_ROLE);
});

// Pemohon Routes
Route::name('pemohon.')->prefix('pemohon')->group(function () {
    Route::get('/', function () {
        return view('pemohon.pages.beranda.index');
    })->name('beranda');
});

// Route::get('/beranda', [BerandaController::class, 'beranda']);

Route::get('/404', function () {
    return view('errors.404');
})->name('404');
Route::get('/401', function () {
    return view('errors.401');
})->name('401');

Route::get('/get-captcha', function () {
    return response()->json(['imageUrl' => captcha_src()]);
})->name('get-captcha');

// ZKP Routes
Route::get('/api/zkp/is-approved/{nomorIdentitas}', [ZkpController::class, 'isApproved']);

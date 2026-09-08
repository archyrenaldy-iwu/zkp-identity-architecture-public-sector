<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KiController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\PutusanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SengketaController;
use App\Http\Controllers\UserInternalManagementController;
use App\Http\Controllers\UserPemohonManagementController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

//test gen doc
Route::get('/generate-doc', [SengketaController::class, 'generateDoc'])->name('generate-doc');

Route::get('/lacak-sengketa/{id}', [SengketaController::class, 'lacak'])->name('sengketa.lacak');
Route::get('/jadwal-sidang', [JadwalController::class, 'list'])->name('jadwal-sidang.list');

Route::controller(AuthController::class)->prefix('/auth')->name('auth.')->group(function () {
    Route::post('/login-without-captcha', 'loginWithoutCaptcha')->name('login-no-capctha'); //delete soon
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
    Route::post('/forgot-password', 'sendResetLinkEmail')->name('forgot-password');
    Route::post('/reset-password', 'resetPassword')->name('reset-password');
    //confirm change email
    Route::get('/confirm-change-email', 'confirmChangeEmail')->name('confirm-change-email');
});

//WILAYAH
Route::controller(WilayahController::class)->prefix('/wilayah')->name('wilayah.')->group(function () {
    Route::get('/provinsi', 'getProvinsi')->name('provinsi');
    Route::get('/kabupaten/{id}', 'getKabupaten')->name('kabupaten');
});

Route::get('download', function () {
    //get request path
    $path = request()->get('path');

    return StorageHelper::download($path);
})->name('download');

Route::get('get_pdf_view', function () {
    //get request path
    $path = request()->get('path');

    return StorageHelper::fileView($path);
})->name('get_pdf_view');

Route::group(['middleware' => ['auth:sanctum']], function () {
    //AUTH
    Route::controller(AuthController::class)->group(function () {
        //resend verif email
        Route::post('/email/resend-verification', 'resendVerif')->name('verification.resend');
        //logout
        Route::post('/auth/logout', 'logout')->name('auth.logout');
        Route::post('/auth/switch-role', 'switchRole')->name('auth.switch-role');
        //change email
        Route::post('/auth/change-email', 'changeEmail')->name('auth.change-email');

        //change password
        Route::post('/auth/change-password', 'changePassword')->name('auth.change-password');
        //get user
        Route::get('/auth/user', 'user')->name('auth.user');
        //update user
        Route::post('/auth/user-update', 'updateUser')->name('auth.update-user');
    });

    //SENGKETA
    Route::controller(SengketaController::class)->prefix('/sengketa')->name('sengketa.')->group(function () {
        Route::get('list-pemohon', 'listPemohon')->name('list-pemohon')->middleware('custom.permission:'.Permissions::FITUR_SENGKETA_CREATE);
        Route::get('list-user-ki', 'listUserKi')->name('list-user-ki')->middleware('custom.permission:'.Permissions::FITUR_SENGKETA_LIST);
    });

    //JADWAL
    Route::controller(JadwalController::class)->prefix('/jadwal-sidang')->name('jadwal-sidang.')->group(function () {
        Route::get('/list-sengketa', 'listSengketa')->name('list-sengketa')->middleware('custom.permission:'.Permissions::FITUR_JADWAL_SIDANG_CREATE);
        Route::get('/history-sidang/{id}', 'historySidangSengketa')->name('history-sidang')->middleware('custom.permission:'.Permissions::FITUR_JADWAL_SIDANG_CREATE);
    });

    //MANAGEMENT USER PEMOHON
    Route::controller(UserPemohonManagementController::class)->prefix('/user-pemohon')->name('user-pemohon.')->group(function () {
        Route::post('/', 'create')->name('create')->middleware('custom.permission:'.Permissions::FITUR_USER_PEMOHON_CREATE);
        Route::get('/{id}', 'show')->name('show')->middleware('custom.permission:'.Permissions::FITUR_USER_PEMOHON_UPDATE);
        Route::post('/{id}', 'update')->name('update')->middleware('custom.permission:'.Permissions::FITUR_USER_PEMOHON_UPDATE);
        Route::get('/', 'list')->name('list')->middleware('custom.permission:'.Permissions::FITUR_USER_PEMOHON_LIST);
        Route::delete('/{id}', 'destroy')->name('delete')->middleware('custom.permission:'.Permissions::FITUR_USER_PEMOHON_DELETE);
    });

    //KI
    Route::controller(KiController::class)->prefix('/ki')->name('ki.')->group(function () {
        Route::get('/', 'list')->name('list')->middleware('custom.permission:'.Permissions::FITUR_KI_LIST);
        Route::post('/', 'create')->name('create')->middleware('custom.permission:'.Permissions::FITUR_KI_CREATE);
        Route::get('/{id}', 'show')->name('show')->middleware('custom.permission:'.Permissions::FITUR_KI_UPDATE);
        Route::post('/{id}', 'update')->name('update')->middleware('custom.permission:'.Permissions::FITUR_KI_UPDATE);
        Route::delete('/{id}', 'destroy')->name('delete')->middleware('custom.permission:'.Permissions::FITUR_KI_DELETE);
    });

    //MANAGEMENT USER INTERNAL
    Route::controller(UserInternalManagementController::class)->prefix('/user-internal')->name('user-internal.')->group(function () {
        Route::post('/', 'create')->name('create')->middleware('custom.permission:'.Permissions::FITUR_USER_INTERNAL_CREATE);
        Route::get('/{id}', 'show')->name('show')->middleware('custom.permission:'.Permissions::FITUR_USER_INTERNAL_UPDATE);
        Route::post('/{id}', 'update')->name('update')->middleware('custom.permission:'.Permissions::FITUR_USER_INTERNAL_UPDATE);
        Route::get('/', 'list')->name('list')->middleware('custom.permission:'.Permissions::FITUR_USER_INTERNAL_LIST);
        Route::delete('/{id}', 'destroy')->name('delete')->middleware('custom.permission:'.Permissions::FITUR_USER_INTERNAL_DELETE);
    });
});

Route::group(['middleware' => ['auth:sanctum', 'permission']], function () {

    //BERANDA
    Route::controller(BerandaController::class)->prefix('/beranda')->name('beranda.')->group(function () {
        Route::get('/', 'summary')->name('summary');
        Route::get('/download', 'download')->name('download');
    });

    //SENGKETA
    Route::controller(SengketaController::class)->prefix('/sengketa')->name('sengketa.')->group(function () {
        Route::get('/', 'list')->name('list');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/create', 'create')->name('create');
        Route::post('/{id}/save-perangkat', 'savePerangkat')->name('save-perangkat');
        Route::post('/{id}/terima', 'terima')->name('terima');
        Route::post('/{id}/tolak', 'tolak')->name('tolak');
        Route::post('/{id}/batal', 'batal')->name('batal');
        Route::post('/{id}/cabut', 'cabut')->name('cabut');
        Route::post('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
    });

    //PANDUAN
    Route::controller(PanduanController::class)->prefix('/panduan')->name('panduan.')->group(function () {
        Route::get('/', 'list')->name('list');
        Route::post('/', 'create')->name('create');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    //JADWAL
    Route::controller(JadwalController::class)->prefix('/jadwal-sidang')->name('jadwal-sidang.')->group(function () {
        // Route::get('/', 'list')->name('list');
        Route::post('/', 'create')->name('create');
        Route::post('/{id}/reelas-create', 'reelasCreate')->name('reelas-create');
        Route::post('/{id}/reelas-send', 'reelasSend')->name('reelas-send');
        Route::delete('/{id}', 'delete')->name('delete');
    });

    //PUTUSAN
    Route::controller(PutusanController::class)->prefix('/putusan')->name('putusan.')->group(function () {
        Route::get('/', 'list')->name('list');
        Route::post('/', 'create')->name('create');
        Route::delete('/{id}', 'delete')->name('delete');
    });

    //ROLES/PERMISSIONS MANAGEMENT
    Route::controller(RoleController::class)->prefix('/role')->name('role.')->group(function () {
        Route::get('/{roleId}', 'getPermission')->name('show');
        Route::post('/{roleId}', 'updatePermission')->name('update');
    });
});

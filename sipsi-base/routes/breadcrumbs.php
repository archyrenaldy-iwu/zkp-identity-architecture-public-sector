<?php

// routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Models\Sengketa;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

/////// CORE MENU ///////

// Beranda
Breadcrumbs::for('beranda', function (BreadcrumbTrail $trail) {
    $trail->push('Beranda', route(Permissions::MENU_BERANDA));
});

// SENGKETA
Breadcrumbs::for('sengketa', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Sengketa', route(Permissions::MENU_SENGKETA));
});

// JADWAL SIDANG
Breadcrumbs::for('jadwal', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Jadwal Sidang', route(Permissions::MENU_JADWAL));
});

// PANDUAN
Breadcrumbs::for('panduan', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Panduan', route(Permissions::MENU_PANDUAN));
});

// PUTUSAN
Breadcrumbs::for('putusan', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Putusan', route(Permissions::MENU_PUTUSAN));
});

// DATA KI
Breadcrumbs::for('data_ki', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Data KI', route(Permissions::MENU_DATA_KI));
});

// ROLE
Breadcrumbs::for('role', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Role', route(Permissions::MENU_ROLE));
});

// AKUN PEMOHON
Breadcrumbs::for('akun_pemohon', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Akun Pemohon', route(Permissions::MENU_USER_PEMOHON));
});

// AKUN ADMIN
Breadcrumbs::for('akun_admin', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Akun Admin', route(Permissions::MENU_USER_INTERNAL));
});

// INFORMASI AKUN
Breadcrumbs::for('informasi', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Informasi Akun', route('informasi-akun'));
});

///// SENGKETA CHILDREN /////
// Beranda > Sengketa > Lihat Sengketa
Breadcrumbs::for('sengketa.show', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('sengketa');
    $trail->push('Lihat Sengketa', route(Permissions::FITUR_SENGKETA_SHOW, $id));
});

// Beranda > Sengketa > Buat Sengketa
Breadcrumbs::for('sengketa.create', function (BreadcrumbTrail $trail) {
    $trail->parent('sengketa');
    $trail->push('Buat Sengketa', route(Permissions::FITUR_SENGKETA_CREATE));
});

// Beranda > Sengketa > Edit Sengketa
Breadcrumbs::for('sengketa.edit', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('sengketa');
    $trail->push('Lengkapi Sengketa', route(Permissions::FITUR_SENGKETA_UPDATE, $id));
});

// lacak sengketa
Breadcrumbs::for('sengketa.lacak', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('sengketa');
    $trail->push('Lacak Sengketa', route(Permissions::FITUR_SENGKETA_LACAK, $id));
});

// validasi informasi
Breadcrumbs::for('validasi_informasi', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Validasi Informasi', route('validasi-informasi'));
});

// rekomendasi informasi
Breadcrumbs::for('rekomendasi_informasi', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Rekomendasi Informasi', route('rekomendasi-informasi'));
});

// verifikasi putusan
Breadcrumbs::for('verifikasi_putusan', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Verifikasi Putusan', route('verifikasi-putusan'));
});
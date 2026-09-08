<?php

class Constant
{
    public static $BLOCKCHAIN_URL;

    public static function initialize()
    {
        self::$BLOCKCHAIN_URL = env('BLOCKCHAIN_URL');
    }

    const SESSION_ACTIVE_ROLE = 'active_role';

    const SESSION_ACTIVE_ID_KI = 'id_ki';

    const HTTP_CODE_SUCCESS = 200;

    const HTTP_CODE_SUCCESS_ENTRY = 201;

    const HTTP_CODE_SUCCESS_ACCEPTED = 202;

    const HTTP_CODE_ERROR = 400;

    const HTTP_CODE_UNAUTHORISED = 401;

    const HTTP_CODE_ERROR_NOT_FOUND = 404;

    const HTTP_CODE_UNPROCESSABLE_ENTITY = 422;

    const HTTP_CODE_ERROR_NOT_ACCEPTABLE = 406;

    const HTTP_CODE_ERROR_SERVER = 500;

    const HTTP_CODE_ERROR_SERVER_MESSAGE = 'Terjadi kesalahan pada server';

    const HTTP_CODE_SUCCESS_ENTRY_MESSAGE = 'Berhasil menyimpan/merubah data';

    const TEMPLATE_KODE_REGISTRASI_ONLINE = 'template_kode_registrasi_online';

    const TEMPLATE_KODE_AKTA_REGISTRASI = 'template_kode_surat_akta_registrasi';

    const TEMPLATE_KODE_NOMOR_SENGKETA = 'template_kode_nomor_sengketa';

    const TEMPLATE_KODE_SURAT_SPKD = 'template_kode_surat_spkd';

    const TEMPALTE_KODE_SURAT_REELAS = 'template_kode_surat_reelas';

    const HTTP_CODE_SUCCESS_EMAIL_MESSAGE = 'Email Verifikasi berhasil dikirim';

    const HTTP_CODE_SUCCESS_EMAIL_RESEND_MESSAGE = 'Email Verifikasi berhasil dikirim ulang';

    const HTTP_CODE_SUCCESS_EMAIL_VERIFIED_MESSAGE = 'Email sudah terverifikasi';

    const STATUS_SENGKETA_MENUNGGU_VERFIKASI = 0;

    const STATUS_SENGKETA_MENUNGGU_VERFIKASI_TEXT = 'Menunggu Verifikasi';

    const STATUS_SENGKETA_TERVERIFIKASI = 1;

    const STATUS_SENGKETA_TERVERIFIKASI_TEXT = 'Diterima';

    const STATUS_SENGKETA_DITOLAK = 2;

    const STATUS_SENGKETA_DITOLAK_TEXT = 'Ditolak';

    const STATUS_SENGKETA_MENUNGGU_PEMBATALAN = 3;

    const STATUS_SENGKETA_MENUNGGU_PEMBATALAN_TEXT = 'Menunggu Konfirmasi Pembatalan';

    const STATUS_SENGKETA_DIBATALKAN = 4;

    const STATUS_SENGKETA_DIBATALKAN_TEXT = 'Dibatalkan';

    const STATUS_SENGKETA_MENUNGGU_PENCABUTAN = 5;

    const STATUS_SENGKETA_MENUNGGU_PENCABUTAN_TEXT = 'Menunggu Konfirmasi Pencabutan';

    const STATUS_SENGKETA_DICABUT = 6;

    const STATUS_SENGKETA_DICABUT_TEXT = 'Dicabut';

    const STATUS_SENGKETA_DALAM_PROSES_SIDANG = 7;

    const STATUS_SENGKETA_DALAM_PROSES_SIDANG_TEXT = 'Dalam Proses Sidang';

    const STATUS_SENGKETA_DALAM_PROSES_PUTUSAN = 8;

    const STATUS_SENGKETA_DALAM_PROSES_PUTUSAN_TEXT = 'Dalam Proses Putusan';

    const STATUS_SENGKETA_SELESAI = 9;

    const STATUS_SENGKETA_SELESAI_TEXT = 'Selesai';

    const STATUS_SENGKETA_PENGAJUAN_ULANG = 10;

    const STATUS_SENGKETA_PENGAJUAN_ULANG_TEXT = 'Pengajuan Ulang';

    const STATUS_SENGKETA_DIHAPUS = 99;

    const STATUS_SENGKETA_DIHAPUS_TEXT = 'Dihapus';

    // const BLOCKCHAIN_URL = 'http://127.0.0.1:3000/';
}

class TypeDocConstant
{
    const TEMPLATE_FORMULIR_MODUL = 'Template_Formulir_Modul.docx';

    const GENERATED_FORMULIR_MODUL = 'FORMULIR_MODEL_{uuid-time}.docx';

    const TEMPLATE_AKTA_REGISTRASI = 'Template_Akta_Registrasi_Modul.docx';

    const GENERATED_AKTA_REGISTRASI = 'AKTA_REGISTRASI_{uuid-time}.docx';

    const TEMPLATE_SPKD = 'Template_SPKD_Modul.docx';

    const GENERATED_SPKD = 'SPKD_{uuid-time}.docx';

    const TEMPLATE_RELAAS = 'Template_Relaas.docx';

    const GENERATED_RELAAS = 'RELAAS_{uuid-time}.docx';
}
<?php

use Illuminate\Support\Facades\Storage;

class StorageHelper
{
    public static function download($path)
    {
        // $path = Crypt::decryptString($path);

        if (! Storage::disk('sensitive')->exists($path)) {
            return null;
        }

        ActivityLog::file('DOWNLOAD', $path);

        return Storage::disk('sensitive')->download($path);
    }

    public static function fileView($path)
    {
        // Decrypt the path if necessary
        // $path = Crypt::decryptString($path);

        if (! Storage::disk('sensitive')->exists($path)) {
            return null;
        }

        ActivityLog::file('VIEW FILE', $path);

        $fileContent = Storage::disk('sensitive')->get($path);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        // Determine the content type based on the file extension
        $contentTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
        ];

        $contentType = $contentTypes[$extension] ?? 'application/octet-stream';

        return Response::make($fileContent, 200, [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'inline; filename="'.basename($path).'"',
        ]);
    }

    public static function upload($request)
    {
        //FILE SENGKETA
        if (isset($request['file_identitas']) && $request['file_identitas']) {
            $file = $request['file_identitas'];
            $filename = 'FILE_IDENTITAS_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_identitas/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_identitas'] = $folder.$filename;
        }

        //FILE SENGKETA
        if (isset($request['file_formulir_keberatan']) && $request['file_formulir_keberatan']) {
            $file = $request['file_formulir_keberatan'];
            $filename = 'FILE_FORMULIR_KEBERATAN_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_formulir_keberatan/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_formulir_keberatan'] = $folder.$filename;
        }

        //FILE SENGKETA
        if (isset($request['file_formulir_permohonan']) && $request['file_formulir_permohonan']) {
            $file = $request['file_formulir_permohonan'];
            $filename = 'FILE_FORMULIR_PERMOHONAN_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_formulir_permohonan/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_formulir_permohonan'] = $folder.$filename;
        }

        //FILE SENGKETA
        if (isset($request['file_surat_kuasa']) && $request['file_surat_kuasa']) {
            $file = $request['file_surat_kuasa'];
            $filename = 'FILE_SURAT_KUASA_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_surat_kuasa/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_surat_kuasa'] = $folder.$filename;
        }

        //FILE SENGKETA
        if (isset($request['file_pemberitahuan_tertulis']) && $request['file_pemberitahuan_tertulis']) {
            $file = $request['file_pemberitahuan_tertulis'];
            $filename = 'FILE_PEMBERITAHUAN_TERTULIS_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_pemberitahuan_tertulis/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_pemberitahuan_tertulis'] = $folder.$filename;
        }

        //FILE SENGKETA
        if (isset($request['file_jawaban_ppid']) && $request['file_jawaban_ppid']) {
            $file = $request['file_jawaban_ppid'];
            $filename = 'FILE_JAWABAN_PPID_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_jawaban_ppid/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_jawaban_ppid'] = $folder.$filename;
        }

        //FILE SENGKETA
        if (isset($request['file_tanggapan_atasan_ppid']) && $request['file_tanggapan_atasan_ppid']) {
            $file = $request['file_tanggapan_atasan_ppid'];
            $filename = 'FILE_TANGGAPAN_ATASAN_PPID_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_tanggapan_atasan_ppid/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_tanggapan_atasan_ppid'] = $folder.$filename;
        }

        //FILE SENGKETA
        if (isset($request['file_pendukung_sengketa1']) && $request['file_pendukung_sengketa1']) {
            $file = $request['file_pendukung_sengketa1'];
            $filename = 'FILE_PENDUKUNG_SENGKETA1_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_pendukung_sengketa1/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_pendukung_sengketa1'] = $folder.$filename;
        }

        //FILE SENGKETA
        if (isset($request['file_pendukung_sengketa2']) && $request['file_pendukung_sengketa2']) {
            $file = $request['file_pendukung_sengketa2'];
            $filename = 'FILE_PENDUKUNG_SENGKETA2_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_pendukung_sengketa2/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_pendukung_sengketa2'] = $folder.$filename;
        }

        //FILE SENGKETA
        if (isset($request['file_akta_pembatalan']) && $request['file_akta_pembatalan']) {
            $file = $request['file_akta_pembatalan'];
            $filename = 'FILE_AKTA_PEMBATALAN_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_akta_pembatalan/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_akta_pembatalan'] = $folder.$filename;
        }

        //FILE SENGKETA
        if (isset($request['file_akta_pencabutan']) && $request['file_akta_pencabutan']) {
            $file = $request['file_akta_pencabutan'];
            $filename = 'FILE_AKTA_PENCABUTAN_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_akta_pencabutan/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_akta_pencabutan'] = $folder.$filename;
        }

        //FILE PUTUSAN
        if (isset($request['file_putusan']) && $request['file_putusan']) {
            $file = $request['file_putusan'];
            $filename = 'FILE_PUTUSAN_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'sengketa/file_putusan/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_putusan'] = $folder.$filename;
        }

        //FILE PANDUAN
        if (isset($request['file_panduan']) && $request['file_panduan']) {
            $file = $request['file_panduan'];
            $filename = 'FILE_PANDUAN_'.Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
            $folder = 'panduan/';
            $file->storeAs($folder, $filename, 'sensitive');
            ActivityLog::file('UPLOAD', $folder.$filename);
            $request['file_panduan'] = $folder.$filename;
        }

        return $request;
    }
}

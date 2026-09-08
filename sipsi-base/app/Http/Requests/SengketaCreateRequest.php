<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Roles;

class SengketaCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rule = [
            'id_ki' => 'required|integer|exists:ki_config,id',
            'termohon_nama' => 'required|string|max:255',
            'tanggal_permohonan' => 'required|date',
            'tanggal_keberatan' => 'required|date',
            'file_identitas' => 'required|file|mimes:pdf,jpg,jpeg|max:2048',
            'file_formulir_permohonan' => 'required|file|mimes:pdf|max:2048',
            'file_formulir_keberatan' => 'required|file|mimes:pdf|max:2048',
            'form_kata_kunci_identitas' => 'required|string|min:3|max:25',
            'file_surat_kuasa' => 'file|mimes:pdf|max:2048',
            'file_pemberitahuan_tertulis' => 'file|mimes:pdf|max:2048',
            'file_jawaban_ppid' => 'file|mimes:pdf|max:2048',
            'file_tanggapan_atasan_ppid' => 'file|mimes:pdf|max:2048',
            'file_pendukung_sengketa1' => 'file|mimes:pdf|max:2048',
            'file_pendukung_sengketa2' => 'file|mimes:pdf|max:2048',
        ];

        if (! getActiveRole(Roles::ROLE_PEMOHON)) {
            $rule['id_pemohon'] = 'required|integer|exists:pemohon,id';
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'id_ki.required' => 'id_ki wajib diisi',
            'id_ki.integer' => 'id_ki harus berupa angka',
            'id_ki.exists' => 'id_ki tidak valid atau tidak ditemukan',
            'termohon_nama.required' => 'Nama termohon wajib diisi',
            'termohon_nama.string' => 'Nama termohon harus berupa teks',
            'termohon_nama.max' => 'Nama termohon tidak boleh lebih dari 255 karakter',
            'tanggal_permohonan.required' => 'Tanggal permohonan wajib diisi',
            'tanggal_permohonan.date' => 'Tanggal permohonan harus berupa tanggal yang valid',
            'tanggal_keberatan.required' => 'Tanggal keberatan wajib diisi',
            'tanggal_keberatan.date' => 'Tanggal keberatan harus berupa tanggal yang valid',
            'file_identitas.required' => 'File identitas wajib diunggah',
            'file_identitas.file' => 'File identitas harus berupa file yang valid',
            'file_identitas.mimes' => 'File identitas harus berupa file tipe PDF',
            'file_identitas.max' => 'File identitas tidak boleh lebih dari 2 MB',
            'file_formulir_permohonan.required' => 'Formulir permohonan wajib diunggah',
            'file_formulir_permohonan.file' => 'Formulir permohonan harus berupa file yang valid',
            'file_formulir_permohonan.mimes' => 'Formulir permohonan harus berupa file tipe PDF',
            'file_formulir_permohonan.max' => 'Formulir permohonan tidak boleh lebih dari 2 MB',
            'file_formulir_keberatan.required' => 'Formulir keberatan wajib diunggah',
            'file_formulir_keberatan.file' => 'Formulir keberatan harus berupa file yang valid',
            'file_formulir_keberatan.mimes' => 'Formulir keberatan harus berupa file tipe PDF',
            'file_formulir_keberatan.max' => 'Formulir keberatan tidak boleh lebih dari 2 MB',
            'form_kata_kunci_identitas.required' => 'Kata kunci identitas wajib diisi',
            'form_kata_kunci_identitas.string' => 'Kata kunci identitas harus berupa teks',
            'form_kata_kunci_identitas.min' => 'Kata kunci identitas minimal 3 karakter',
            'form_kata_kunci_identitas.max' => 'Kata kunci identitas tidak boleh lebih dari 25 karakter',
            'id_pemohon.required' => 'id_pemohon wajib diisi',
            'id_pemohon.integer' => 'id_pemohon harus berupa angka',
            'id_pemohon.exists' => 'id_pemohon tidak valid atau tidak ditemukan',
            'file_surat_kuasa.file' => 'Formulir keberatan harus berupa file yang valid',
            'file_surat_kuasa.mimes' => 'Formulir keberatan harus berupa file tipe PDF',
            'file_surat_kuasa.max' => 'Formulir keberatan tidak boleh lebih dari 2 MB',
            'file_pemberitahuan_tertulis.file' => 'Formulir keberatan harus berupa file yang valid',
            'file_pemberitahuan_tertulis.mimes' => 'Formulir keberatan harus berupa file tipe PDF',
            'file_pemberitahuan_tertulis.max' => 'Formulir keberatan tidak boleh lebih dari 2 MB',
            'file_jawaban_ppid.file' => 'Formulir keberatan harus berupa file yang valid',
            'file_jawaban_ppid.mimes' => 'Formulir keberatan harus berupa file tipe PDF',
            'file_jawaban_ppid.max' => 'Formulir keberatan tidak boleh lebih dari 2 MB',
            'file_tanggapan_atasan_ppid.file' => 'Formulir keberatan harus berupa file yang valid',
            'file_tanggapan_atasan_ppid.mimes' => 'Formulir keberatan harus berupa file tipe PDF',
            'file_tanggapan_atasan_ppid.max' => 'Formulir keberatan tidak boleh lebih dari 2 MB',
            'file_pendukung_sengketa1.file' => 'Formulir keberatan harus berupa file yang valid',
            'file_pendukung_sengketa1.mimes' => 'Formulir keberatan harus berupa file tipe PDF',
            'file_pendukung_sengketa1.max' => 'Formulir keberatan tidak boleh lebih dari 2 MB',
            'file_pendukung_sengketa2.file' => 'Formulir keberatan harus berupa file yang valid',
            'file_pendukung_sengketa2.mimes' => 'Formulir keberatan harus berupa file tipe PDF',
            'file_pendukung_sengketa2.max' => 'Formulir keberatan tidak boleh lebih dari 2 MB',
        ];
    }
}

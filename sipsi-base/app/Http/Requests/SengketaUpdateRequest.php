<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SengketaUpdateRequest extends FormRequest
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
            'termohon_nama' => 'required|string|max:255',
            'tanggal_permohonan' => 'required|date',
            'tanggal_keberatan' => 'required|date',
            'file_identitas' => 'file|mimes:pdf,jpg,jpeg|max:2048',
            'file_formulir_permohonan' => 'file|mimes:pdf|max:2048',
            'file_formulir_keberatan' => 'file|mimes:pdf|max:2048',
            'file_surat_kuasa' => 'file|mimes:pdf|max:2048',
            'file_pemberitahuan_tertulis' => 'file|mimes:pdf|max:2048',
            'file_jawaban_ppid' => 'file|mimes:pdf|max:2048',
            'file_tanggapan_atasan_ppid' => 'file|mimes:pdf|max:2048',
            'file_pendukung_sengketa1' => 'file|mimes:pdf|max:2048',
            'file_pendukung_sengketa2' => 'file|mimes:pdf|max:2048',
        ];

        return $rule;
    }

    public function messages()
    {
        return [
            'termohon_nama.required' => 'Nama termohon wajib diisi',
            'termohon_nama.string' => 'Nama termohon harus berupa teks',
            'termohon_nama.max' => 'Nama termohon tidak boleh lebih dari 255 karakter',
            'tanggal_permohonan.required' => 'Tanggal permohonan wajib diisi',
            'tanggal_permohonan.date' => 'Tanggal permohonan harus berupa tanggal yang valid',
            'tanggal_keberatan.required' => 'Tanggal keberatan wajib diisi',
            'tanggal_keberatan.date' => 'Tanggal keberatan harus berupa tanggal yang valid',
            'file_identitas.file' => 'File identitas harus berupa file yang valid',
            'file_identitas.mimes' => 'File identitas harus berupa file tipe PDF',
            'file_identitas.max' => 'File identitas tidak boleh lebih dari 2 MB',
            'file_formulir_permohonan.file' => 'Formulir permohonan harus berupa file yang valid',
            'file_formulir_permohonan.mimes' => 'Formulir permohonan harus berupa file tipe PDF',
            'file_formulir_permohonan.max' => 'Formulir permohonan tidak boleh lebih dari 2 MB',
            'file_formulir_keberatan.file' => 'Formulir keberatan harus berupa file yang valid',
            'file_formulir_keberatan.mimes' => 'Formulir keberatan harus berupa file tipe PDF',
            'file_formulir_keberatan.max' => 'Formulir keberatan tidak boleh lebih dari 2 MB',
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

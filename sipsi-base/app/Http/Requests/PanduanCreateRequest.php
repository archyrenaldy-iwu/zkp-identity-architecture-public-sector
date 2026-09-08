<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Roles;

class PanduanCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return getActiveRole(Roles::ROLE_SUPERADMIN);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul' => 'required',
            'file_panduan' => 'required|file|mimes:pdf',
            'jenis' => 'required|in:pemohon,admin,super-admin',
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => 'Judul wajib diisi',
            'file_panduan.required' => 'File panduan wajib diunggah',
            'file_panduan.file' => 'File panduan harus berupa file yang valid',
            'file_panduan.mimes' => 'File panduan harus berupa file tipe PDF',
            'jenis.required' => 'Jenis wajib diisi',
            'jenis.in' => 'Jenis hanya bisa pemohon/admin/super-admin',
        ];
    }
}

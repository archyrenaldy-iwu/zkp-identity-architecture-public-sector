<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PutusanCreateRequest extends FormRequest
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
        return [
            'id_history' => 'required|integer|exists:sengketa_history,id',
            'id_jenis_putusan' => 'required|integer|exists:jenis_sidang_putusan,id',
            'file_putusan' => 'required|file|mimes:pdf|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'id_history.required' => 'ID Riwayat wajib diisi',
            'id_history.exists' => 'Riwayat Sengketa tidak terdaftar',
            'id_jenis_putusan.required' => 'ID Jenis Putusan wajib diisi',
            'id_jenis_putusan.exists' => 'ID Jenis Putusan tidak terdaftar',
            'file_putusan.required' => 'File putusan wajib diunggah',
            'file_putusan.file' => 'File putusan harus berupa file yang valid',
            'file_putusan.mimes' => 'File putusan harus berupa file tipe PDF',
            'file_putusan.max' => 'File putusan tidak boleh lebih dari 2 MB',
        ];
    }
}

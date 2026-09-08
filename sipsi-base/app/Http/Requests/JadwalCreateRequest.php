<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JadwalCreateRequest extends FormRequest
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
            'id_sengketa' => 'required|exists:sengketa,id',
            'id_jenis_sidang' => 'required|exists:jenis_sidang_putusan,id',
            'sidang_agenda' => 'required|string|max:255',
            'sidang_waktu' => 'required|date_format:Y-m-d H:i:s',
            'sidang_alamat' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'id_sengketa.required' => 'ID Sengketa wajib diisi.',
            'id_sengketa.exists' => 'ID Sengketa tidak ditemukan.',
            'id_jenis_sidang.required' => 'ID Jenis Sidang wajib diisi.',
            'id_jenis_sidang.exists' => 'ID Jenis Sidang tidak ditemukan',
            'sidang_agenda.required' => 'Agenda Sidang wajib diisi.',
            'sidang_agenda.string' => 'Agenda Sidang harus berupa teks.',
            'sidang_agenda.max' => 'Agenda Sidang tidak boleh lebih dari 255 karakter.',
            'sidang_waktu.required' => 'Waktu Sidang wajib diisi.',
            'sidang_waktu.date_format' => 'Format Waktu Sidang harus sesuai dengan Y-m-d H:i:s.',
            'sidang_alamat.required' => 'Alamat Sidang wajib diisi.',
            'sidang_alamat.string' => 'Alamat Sidang harus berupa teks.',
            'sidang_alamat.max' => 'Alamat Sidang tidak boleh lebih dari 255 karakter.',
        ];
    }
}

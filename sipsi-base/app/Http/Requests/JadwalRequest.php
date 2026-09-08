<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JadwalRequest extends FormRequest
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
            'agenda' => 'required',
            'waktu_sidang' => 'required|date_format:Y-m-d H:i:s',
            'id_ruangan' => 'required|exists:ruangan,id',
            'id_jenis_sidang' => 'required|exists:jenis_sidang_putusan,id',
        ];
    }

    public function messages()
    {
        return [
            'id_sengketa.required' => 'id_sengketa wajib diisi',
            'id_sengketa.exists' => 'id_sengketa tidak terdaftar',
            'agenda.required' => 'Agenda wajib diisi',
            'waktu_sidang.date_format' => 'Waktu sidang harus memiliki format Y-m-d H:i:s',
            'waktu_sidang.required' => 'Waktu sidang wajib diisi',
            'id_ruangan.required' => 'Ruangan wajib diisi',
            'id_ruangan.exists' => 'Ruangan tidak terdaftar',
            'id_jenis_sidang.required' => 'Jenis sidang wajib diisi',
            'id_jenis_sidang.exists' => 'Jenis sidang tidak terdaftar',
        ];
    }
}

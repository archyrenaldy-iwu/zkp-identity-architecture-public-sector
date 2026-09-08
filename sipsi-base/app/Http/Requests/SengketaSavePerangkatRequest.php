<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SengketaSavePerangkatRequest extends FormRequest
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
            'id_ketua' => 'required|exists:user_internal,id',
            'id_anggota1' => 'required|exists:user_internal,id',
            'id_anggota2' => 'required|exists:user_internal,id',
            'id_mediator' => 'required|exists:user_internal,id',
            'id_panitera_pengganti' => 'required|exists:user_internal,id',
        ];
    }

    public function messages()
    {
        return [
            'id_ketua.required' => 'ID Ketua wajib diisi.',
            'id_ketua.exists' => 'ID Ketua tidak dikenali.',
            'id_anggota1.required' => 'ID Anggota 1 wajib diisi.',
            'id_anggota1.exists' => 'ID Anggota 1 tidak dikenali.',
            'id_anggota2.required' => 'ID Anggota 2 wajib diisi.',
            'id_anggota2.exists' => 'ID Anggota 2 tidak dikenali.',
            'id_mediator.required' => 'ID Mediator wajib diisi.',
            'id_mediator.exists' => 'ID Mediator tidak dikenali.',
            'id_panitera_pengganti.required' => 'ID Panitera Pengganti wajib diisi.',
            'id_panitera_pengganti.exists' => 'ID Panitera Pengganti tidak dikenali.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserInternalCreateRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]/', // must contain at least one special character
            ],
            'password_confirmation' => 'required|same:password',
            'no_hp' => 'required|numeric|digits_between:10,15|unique:user_internal',
            'roles' => 'required|array',
            'jenis_kelamin' => 'nullable|string|in:L,P',
            'jenis_identitas' => 'required|string|in:KTP,SIM,PASPOR',
            'nomor_identitas' => 'required|'.($this->jenis_identitas == 'KTP' || $this->jenis_identitas == 'SIM' ? 'numeric' : 'string').'|unique:user_internal',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'required|string|max:255',
            'id_ki' => 'required|integer',
        ];

        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial',
            'password_confirmation.required' => 'Konfirmasi password harus diisi',
            'password_confirmation.same' => 'Konfirmasi password tidak sama dengan password',
            'no_hp.required' => 'Nomor HP harus diisi',
            'no_hp.numeric' => 'Nomor HP harus berupa angka',
            'no_hp.digits_between' => 'Nomor HP minimal 10 dan maksimal 15 digit',
            'no_hp.unique' => 'Nomor HP sudah terdaftar',
            'roles.required' => 'Role harus diisi',
            'jenis_kelamin.string' => 'Jenis kelamin harus berupa string',
            'jenis_kelamin.in' => 'Jenis kelamin harus berupa L atau P',
            'jenis_identitas.required' => 'Jenis identitas harus diisi',
            'jenis_identitas.string' => 'Jenis identitas harus berupa string',
            'jenis_identitas.in' => 'Jenis identitas harus berupa KTP, SIM, atau PASPOR',
            'nomor_identitas.required' => 'Nomor identitas harus diisi',
            'nomor_identitas.numeric' => 'Nomor identitas harus berupa angka',
            'nomor_identitas.unique' => 'Nomor identitas sudah terdaftar',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal',
            'alamat.required' => 'Alamat harus diisi',
            'alamat.string' => 'Alamat harus berupa string',
            'alamat.max' => 'Alamat maksimal 255 karakter',
            'id_ki.required' => 'ID KI harus diisi',
            'id_ki.integer' => 'ID KI harus berupa angka',
        ];
    }
}

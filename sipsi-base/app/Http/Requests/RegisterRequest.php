<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rule = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]/', // must contain at least one special character
            ],
            //pass confirmation
            'password_confirmation' => 'required|same:password',
            'alamat' => 'required|string|max:255',
            'no_hp' => [
                'required',
                'numeric',
                'digits_between:10,15',
                Rule::unique('pemohon')->whereNull('deleted_at'),
            ],
            'jenis_identitas' => 'required|string',
            'jenis_pemohon' => 'required|string',
            'nomor_identitas' => [
                'required',
                'string',
                Rule::unique('pemohon')->whereNull('deleted_at'),
            ],
            'jenis_kelamin' => 'nullable|string|in:L,P',
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
            'password_confirmation.required' => 'Konfirmasi Password harus diisi',
            'password_confirmation.same' => 'Konfirmasi Password tidak sama dengan Password',
            'alamat.required' => 'Alamat harus diisi',
            'no_hp.required' => 'Nomor HP harus diisi',
            'no_hp.numeric' => 'Nomor HP harus berupa angka',
            'no_hp.digits_between' => 'Nomor HP harus memiliki panjang antara 10 sampai 15 karakter',
            'no_hp.unique' => 'Nomor HP sudah terdaftar',
            'jenis_identitas.required' => 'Jenis Identitas harus diisi',
            'jenis_pemohon.required' => 'Jenis Pemohon harus diisi',
            'nomor_identitas.required' => 'Nomor Identitas harus diisi',
            'nomor_identitas.numeric' => 'Nomor Identitas harus berupa angka',
            'nomor_identitas.string' => 'Nomor Identitas tidak valid',
            'jenis_kelamin.in' => 'Jenis Kelamin tidak valid',
        ];
    }
}

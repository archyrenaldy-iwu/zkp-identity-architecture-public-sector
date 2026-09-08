<?php

namespace App\Http\Requests;

use App\Models\Pemohon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserPemohonUpdateRequest extends FormRequest
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
        $id = $this->route('id');
        $user = Pemohon::where('id_user', $id)->with('user')->first();
        $rule = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => [
                'nullable',
                'string',
                'min:6',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]/', // must contain at least one special character
            ],
            'password_confirmation' => 'same:password|nullable',
            'no_hp' => 'required|digits_between:10,15|numeric|unique:pemohon,no_hp,'.$user->id,
            'jenis_kelamin' => 'nullable|string|in:L,P',
            'jenis_identitas' => 'required|string',
            'nomor_identitas' => 'required|'.($this->jenis_identitas == 'KTP' || $this->jenis_identitas == 'SIM' ? 'numeric' : 'string').'|unique:pemohon,nomor_identitas,'.$user->id,
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'required|string|max:255',
            'jenis_pemohon' => 'required|string',
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
            'no_hp.required' => 'Nomor HP harus diisi',
            'no_hp.digits_between' => 'Nomor HP harus berada diantara 10 sampai 15 digit',
            'no_hp.numeric' => 'Nomor HP harus berupa angka',
            'no_hp.unique' => 'Nomor HP sudah terdaftar',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P',
            'jenis_identitas.required' => 'Jenis identitas harus diisi',
            'nomor_identitas.required' => 'Nomor identitas harus diisi',
            'nomor_identitas.numeric' => 'Nomor identitas harus berupa angka',
            'nomor_identitas.unique' => 'Nomor identitas sudah terdaftar',
            'tanggal_lahir.date' => 'Tanggal lahir harus berupa tanggal',
            'alamat.required' => 'Alamat harus diisi',
            'alamat.string' => 'Alamat harus berupa string',
            'alamat.max' => 'Alamat maksimal 255 karakter',
            'jenis_pemohon.required' => 'Jenis pemohon harus diisi',
        ];
    }
}

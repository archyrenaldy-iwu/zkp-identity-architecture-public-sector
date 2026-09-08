<?php

namespace App\Http\Requests;

use App\Models\UserInternal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class InformasiAkunUpdateRequest extends FormRequest
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
        $user = UserInternal::where('id_user', Auth::user()->id)->firstOrFail();
        $rule = [
            'name' => 'required|string',
            'no_hp' => 'required|numeric|digits_between:10,15|unique:user_internal,no_hp,'.$user->id,
            'nomor_identitas' => 'required|'.($user->jenis_identitas == 'KTP' || $user->jenis_identitas == 'SIM' ? 'numeric' : 'string').'|unique:user_internal,nomor_identitas,'.$user->id,
            'alamat' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'nullable|string|in:L,P',
        ];

        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'no_hp.required' => 'Nomor HP harus diisi',
            'no_hp.numeric' => 'Nomor HP harus berupa angka',
            'no_hp.digits_between' => 'Nomor HP harus berjumlah 10-15 digit',
            'no_hp.unique' => 'Nomor HP sudah terdaftar',
            'nomor_identitas.required' => 'Nomor Identitas harus diisi',
            'nomor_identitas.string' => 'Nomor Identitas tidak valid',
            'nomor_identitas.unique' => 'Nomor Identitas sudah terdaftar',
            'alamat.required' => 'Alamat harus diisi',
            'alamat.string' => 'Alamat harus berupa huruf',
            'alamat.max' => 'Alamat maksimal 255 karakter',
            'tanggal_lahir.required' => 'Tanggal Lahir harus diisi',
            'tanggal_lahir.date' => 'Tanggal Lahir tidak valid',
            'jenis_kelamin.string' => 'Jenis Kelamin tidak valid',
            'jenis_kelamin.in' => 'Jenis Kelamin tidak valid',

        ];
    }
}

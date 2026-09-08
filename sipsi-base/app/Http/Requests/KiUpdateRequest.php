<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KiUpdateRequest extends FormRequest
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

        $rule = [
            'email' => 'required|email|unique:ki_config,email,'.$id,
            'no_hp' => 'nullable|digits_between:10,15|numeric|unique:ki_config,no_hp,'.$id,
            'alamat' => 'required|string|max:255',
            'template_kode_surat_akta_registrasi' => 'required|string|max:255',
            'template_kode_nomor_sengketa' => 'required|string|max:255',
            'template_kode_surat_spkd' => 'required|string|max:255',
            'template_kode_surat_reelas' => 'required|string|max:255',
            'link_instagram' => 'nullable|string|max:255',
            'link_twitter' => 'nullable|string|max:255',
            'no_telp' => 'required|digits_between:10,15|numeric|unique:ki_config,no_telp,'.$id,
            'fax' => 'nullable|numeric|unique:ki_config,fax,'.$id,
            'link_website' => 'nullable|string|max:255',
            'link_facebook' => 'nullable|string|max:255',
            'link_youtube' => 'nullable|string|max:255',
            'timezone' => 'required|in:WIB,WITA,WIT',
        ];

        return $rule;
    }

    public function messages()
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.numeric' => 'No HP harus berupa angka.',
            'no_hp.digits_between' => 'No HP minimal 10 karakter dan maksimal 15 karakter.',
            'no_hp.unique' => 'No HP sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat tidak valid.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'template_kode_surat_akta_registrasi.required' => 'Template kode surat akta registrasi wajib diisi.',
            'template_kode_surat_akta_registrasi.string' => 'Template kode surat akta registrasi tidak valid.',
            'template_kode_surat_akta_registrasi.max' => 'Template kode surat akta registrasi maksimal 255 karakter.',
            'template_kode_nomor_sengketa.required' => 'Template kode nomor sengketa wajib diisi.',
            'template_kode_nomor_sengketa.string' => 'Template kode nomor sengketa tidak valid.',
            'template_kode_nomor_sengketa.max' => 'Template kode nomor sengketa maksimal 255 karakter.',
            'template_kode_surat_spkd.required' => 'Template kode surat SPKD wajib diisi.',
            'template_kode_surat_spkd.string' => 'Template kode surat SPKD tidak valid.',
            'template_kode_surat_spkd.max' => 'Template kode surat SPKD maksimal 255 karakter.',
            'template_kode_surat_reelas.required' => 'Template kode surat REELAS wajib diisi.',
            'template_kode_surat_reelas.string' => 'Template kode surat REELAS tidak valid.',
            'template_kode_surat_reelas.max' => 'Template kode surat REELAS maksimal 255 karakter.',
            'link_instagram.string' => 'Link instagram tidak valid.',
            'link_instagram.max' => 'Link instagram maksimal 255 karakter.',
            'link_twitter.string' => 'Link twitter tidak valid.',
            'link_twitter.max' => 'Link twitter maksimal 255 karakter',
            'no_telp.required' => 'No Telp wajib diisi.',
            'no_telp.numeric' => 'No Telp harus berupa angka.',
            'no_telp.digits_between' => 'No Telp minimal 10 karakter dan maksimal 15 karakter.',
            'no_telp.unique' => 'No Telp sudah terdaftar.',
            'fax.number' => 'Fax harus berupa angka.',
            'fax.unique' => 'Fax sudah terdaftar.',
            'link_website.string' => 'Link website tidak valid.',
            'link_website.max' => 'Link website maksimal 255 karakter.',
            'link_facebook.string' => 'Link facebook tidak valid.',
            'link_facebook.max' => 'Link facebook maksimal 255 karakter.',
            'link_youtube.string' => 'Link youtube tidak valid.',
            'link_youtube.max' => 'Link youtube maksimal 255 karakter.',
            'timezone.required' => 'Zona waktu harus dipilih',
            'timezone.in' => 'Zona waktu tidak diperbolehkan',
        ];
    }
}

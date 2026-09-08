<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SengketaCabutRequest extends FormRequest
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
        $rules = [
            'type' => 'required|string|in:pengajuan,konfirmasi',
        ];

        if ($this->type == 'konfirmasi') {
            $rules['file_akta_pencabutan'] = 'required|mimes:pdf|max:2048';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'file_akta_pencabutan.required' => 'Harap upload file akta pembatalan sengketa',
            'file_akta_pencabutan.mimes' => 'File harus berformat PDF',
            'file_akta_pencabutan.max' => 'Ukuran file tidak boleh lebih dari 2MB',
        ];
    }
}

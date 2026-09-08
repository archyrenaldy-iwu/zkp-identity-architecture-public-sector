<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeEmailRequest extends FormRequest
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
            'old_email' => 'required|email',
            'new_email' => 'required|email|unique:users,email',
        ];

        return $rule;
    }

    public function messages()
    {
        return [
            'old_email.required' => 'Email lama harus diisi',
            'old_email.email' => 'Email lama tidak valid',
            'new_email.required' => 'Email baru harus diisi',
            'new_email.email' => 'Email baru tidak valid',
            'new_email.unique' => 'Email baru sudah terdaftar',
        ];
    }
}

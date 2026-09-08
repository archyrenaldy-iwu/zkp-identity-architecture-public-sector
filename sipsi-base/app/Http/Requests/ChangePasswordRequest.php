<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'new_password' => [
                'required',
                'string',
                'min:6',
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]/', // must contain at least one special character
            ],
            //pass confirmation
            'confirm_password' => 'required|same:new_password',
            'old_password' => 'required',
        ];

        return $rule;
    }

    public function messages()
    {
        return [
            'new_password.required' => 'Password harus diisi',
            'new_password.min' => 'Password minimal 6 karakter',
            'new_password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial',
            'confirm_password.required' => 'Konfirmasi Password harus diisi',
            'confirm_password.same' => 'Konfirmasi Password tidak sama dengan Password',
            'old_password.required' => 'Password lama harus diisi',
        ];
    }
}

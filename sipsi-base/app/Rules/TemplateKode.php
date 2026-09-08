<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TemplateKode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strpos($value, '{nomor}') === false ||
            strpos($value, '{bulan}') === false ||
            strpos($value, '{tahun}') === false) {
            $fail(':attribute harus memiliki {nomor}, {bulan}, dan {tahun}.');
        }
    }
}

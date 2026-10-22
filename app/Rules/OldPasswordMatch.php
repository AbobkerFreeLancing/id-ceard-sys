<?php

namespace App\Rules;

use Illuminate\Translation\PotentiallyTranslatedString;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class OldPasswordMatch implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string):PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Hash::check($value, auth()->user()->password)) {
            $fail(__('backend.password_entered_not_match_current'));
        }
    }
}

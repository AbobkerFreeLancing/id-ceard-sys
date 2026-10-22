<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EnglishSlug implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^[A-Za-z0-9\-]+$/', $value);
    }

    /**
     * Get the validation error message.
     */
    public function message()
    {
        return 'Use english letters & dashes with no spaces!';
    }
}

<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (
            !preg_match('/[A-Z]/', $value) ||
            !preg_match('/[a-z]/', $value) ||
            !preg_match('/\d/', $value) ||    // Contains number
            !preg_match('/[\W_]/', $value)
        ) { // Contains special character
            $fail('The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
        }
    }
}

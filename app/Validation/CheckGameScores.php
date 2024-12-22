<?php

namespace App\Validation;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckGameScores implements ValidationRule
{


    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // if (strtoupper($value) !== $value) {
        $fail('The :attribute must be uppercase.');
        // }
    }
}

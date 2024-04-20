<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class NumberIsNotZeroRule implements ValidationRule
{
    public function __construct(public string $test)
    {
        //
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $foundComma = Str::contains($value, ',');

        if ($foundComma) {
            $splitted = explode(',', $value);

            $integer = str_replace(search: '.', replace: '', subject: $splitted[0]);

            $decimal = $splitted[1];

            if ((int) $integer === 0 && (int) $decimal === 0) {
                $fail("O $this->test não pode ser zero");
            }
        } else {
            if ((int) $value === 0) {
                $fail("O $this->test não pode ser zero");
            }
        }
    }
}

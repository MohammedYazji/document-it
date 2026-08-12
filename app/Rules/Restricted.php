<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Restricted implements ValidationRule
{
    /**
     * @var array
     */
    protected $restrictedWords;

    /**
     * Create a new rule instance.
     */
    public function __construct(array $restrictedWords)
    {
        $this->restrictedWords = $restrictedWords;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->restrictedWords as $word) {
            if (stripos($value, $word) !== false) {
                $fail("The {$attribute} contains restricted words.");

                return;
            }
        }
    }
}

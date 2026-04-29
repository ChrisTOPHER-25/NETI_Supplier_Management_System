<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use SebastianBergmann\Type\TrueType;

class noEmoji implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        if($this->checkIsEmoji($value) == true ) {
            $fail('The :attribute must not contain special characters.');
        }

        // if ($value !== 'Hello World') {
        //     $fail('The :attribute must be Hello World');
        // }

    }

    // public function passes($attribute, $value) {
    //     return $value == "Hello World";
    // }

    // public function message() {
    //     return 'The :attribute must be Hello World';
    // }

    private function checkIsEmoji(mixed $value){
        return preg_match('/[^A-Za-z0-9 ]/u', $value);
    }
}

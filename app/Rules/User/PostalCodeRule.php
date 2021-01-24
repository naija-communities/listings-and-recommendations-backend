<?php

namespace App\Rules\User;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class PostalCodeRule implements Rule
{
    protected $errors = [];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $code = Str::upper(str_replace(" ", "", $value));

        if (strlen($code) < 6 || strlen($code) > 6) {
            $this->errors[] = "The {$attribute} must be 6 characters long.";
            return false;
        }

        $rules = ['string', 'integer', 'string', 'integer', 'string', 'integer'];
        $pass = true;

        for ($i=0; $i<6; $i++) {
            if ($rules[$i] == 'string' && (intval($code[$i]) !== 0)) {
                $this->errors[] = "The {$attribute} is invalid.";
                $pass = false;
                break;
            }

            if ($rules[$i] == 'integer' && !is_numeric($code[$i])) {
                $this->errors[] = "The {$attribute} is invalid.";
                $pass = false;
                break;
            }
        }

        return $pass;
    }

    /**
     * Get the validation error message.
     */
    public function message()
    {
        return $this->errors;
    }
}

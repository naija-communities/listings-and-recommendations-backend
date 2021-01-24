<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

abstract class AllowedRule implements Rule
{
    protected $allowed;
    protected $attribute;
    protected $value;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array($value, $this->allowed);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The {$this->attribute} must be one of the following. {$this->allowed}";
    }
}

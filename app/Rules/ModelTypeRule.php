<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ModelTypeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $message = 'Value must be  Motorcycle or Car';

    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $str = ['Motorcycle','Car'];
        if(in_array($value,$str)){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}

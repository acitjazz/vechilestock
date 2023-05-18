<?php

namespace App\Rules;

use App\Models\Car;
use App\Models\Motorcycle;
use Illuminate\Contracts\Validation\Rule;

class ModelidRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
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
        if(request('type') == 'Motorcycle'){
           $motorcycle =  Motorcycle::find($value);
           if(is_null($motorcycle)) return false;
        }
        if(request('type') == 'Car'){
           $car =  Car::find($value);
           if(is_null($car)) return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  request('type') . ' not found';
    }
}

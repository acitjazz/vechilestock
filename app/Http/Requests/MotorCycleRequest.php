<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MotorCycleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'machine' => ['required','string', 'max:255'],
            'suspension' => ['required','string', 'max:255'],
            'transmission' => ['required','string', 'max:255'],
        ];
    }
}

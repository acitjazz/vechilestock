<?php

namespace App\Http\Requests;

use App\Rules\ModelidRule;
use App\Rules\ModelTypeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VechileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'model_id' => ['required','string', 'max:255', new ModelidRule],
            'type' => ['required','string', 'max:255', new ModelTypeRule],
            'year' => ['required', 'digits:4'],
            'price' => ['required','integer'],
            'qty' => ['required','integer'],
            'color' => ['required','string', 'max:255'],
        ];
    }
}

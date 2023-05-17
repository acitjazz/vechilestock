<?php

namespace App\Http\Requests;

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
            'model_id' => ['string', 'max:255'],
            'type' => ['string', 'max:255'],
            'year' => ['number', 'digits:4'],
            'price' => ['string', 'max:255'],
            'color' => ['string', 'max:255'],
        ];
    }
}

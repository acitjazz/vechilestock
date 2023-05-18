<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;


class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'password' => ['required', 'required_with:cofirm_password','same:cofirm_password', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'cofirm_password' => ['required',Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'email' => 'required|string|email|max:255|unique:users,email',
        ];
    }
}

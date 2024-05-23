<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "full_name"=>["required","string","min:4"],
            "password"=>["required","string",Password::min(8)->mixedCase()],
            "email"=>["required","string","email",Rule::unique('users')->ignore($this->user->id??null)],
            "gender"=>["required",Rule::in(["male","female"])],
            "image"=>["required","image"]

        ];
    }
}

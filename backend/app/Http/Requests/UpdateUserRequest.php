<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
            "full_name"=>["sometimes","string","min:4"],
            "email"=>["sometimes","string","email","unique:admins",Rule::unique('users')->ignore($this->route('user'))],
            "gender"=>["sometimes",Rule::in(["male","female"])],
            "image"=>["sometimes","image"]

        ];
    }
}

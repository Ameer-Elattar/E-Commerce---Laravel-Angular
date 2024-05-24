<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'title' => 'sometimes|string|required|max:255',
            'description' => 'sometimes|string|required',
            'price' => 'sometimes|required|numeric',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,PNG|max:2048',
            'stock' => 'sometimes|required|integer|min:0', 
        ];
        
        
    }
}

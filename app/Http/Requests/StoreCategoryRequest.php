<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    
    protected $redirectRoute = 'categories.create'; 
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'numeric', 'max_digits:255','unique:categories'],
            'name' => ['required', 'max:255', 'unique:categories']
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'código',
            'name' => 'nome',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = Route::getCurrentRoute()->parameter('category');

        return [
            'code' => ['required',
                'numeric',
                'max_digits:255',
                Rule::unique('categories', 'code')->ignore($id)
            ],
            'name' => [
                'required',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id)
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => 'código',
            'name' => 'nome'
        ];        
    }
}

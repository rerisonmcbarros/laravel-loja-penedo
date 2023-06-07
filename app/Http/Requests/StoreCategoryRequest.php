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
            'code' => [
                'required',
                'numeric',
                'unique:categories'
            ],
            'name' => [
                'required',
                'min:2',
                'max:255',
                'unique:categories'
            ]
        ];
    }

    public function messages()
    {
        return [
            'code' => [
                'required' => 'O campo :attribute não pode ser vazio.',
                'numeric' => 'O campo :attribute deve ser um valor numérico.',
                'unique' => 'Já existe uma categoria com este :attribute.'
            ],
            'name' => [
                'required' => 'O campo :attribute não pode ser vazio.',
                'min' => 'O campo :attribute deve ter no mínimo 2 caracteres.',
                'max' => 'O campo :attribute deve ter no mínimo 255 caracteres.',
                'unique' => 'Já existe uma categoria com este :attribute.'
            ],
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

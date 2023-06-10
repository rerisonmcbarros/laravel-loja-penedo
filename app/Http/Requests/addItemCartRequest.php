<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addItemCartRequest extends FormRequest
{
    protected $redirectRoute = 'cart.index';
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
            'product_code' => ['required', 'numeric'],
            'quantity' => ['required', 'integer', 'gt:0'], 
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute não pode ser vazio.',
            'numeric' => 'O campo :attribute deve ser um valor numérico.',
            'integer' => 'O campo :attribute deve ser um valor numérico inteiro.',
            'quantity.gt' => 'O campo :attribute deve ser um valor maior que 0',
        ];
    }

    public function attributes()
    {
        return [
            'product_code' => 'código do produto',
            'quantity' => 'quantidade',
        ];
    }
}

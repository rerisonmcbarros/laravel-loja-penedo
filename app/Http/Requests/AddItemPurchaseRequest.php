<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddItemPurchaseRequest extends FormRequest
{
    protected $redirectRoute = 'purchases.create';
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
            'code' => ['required','numeric', 'max_digits:255'],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric', 'min:1']
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute não pode ser vazio.',
            'max_digits' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'numeric' => 'O campo :attribute deve ser um valor numérico.',
            'quantity.min' => 'O campo :attribute deve ser de no mínimo :min'
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => 'código',
            'description' => 'descrição',
            'price' => 'preço',
            'quantity' => 'quantidade'
        ];
    }
}

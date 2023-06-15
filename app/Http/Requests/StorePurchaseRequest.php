<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            'supplier' => ['required', 'max:255'],
            'invoice' => ['required', 'numeric', 'max_digits:255'],
            'purchase_description' => ['required', 'string', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute não pode ser vazio.',
            'max_digits' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'numeric' => 'O campo :attribute deve ser um valor numérico.',
            'string' => 'O campo :attribute não pode ser somente números.'
        ];
    }

    public function attributes(): array
    {
        return [
            'supplier' => 'fornecedor',
            'invoice' => 'nota fiscal',
            'purchase_description' => 'descrição'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetPurchasesByPeriodRequest extends FormRequest
{
    protected $redirectRoute = 'purchases.index';
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
            'data_inicio' => ['required', 'date'],
            'data_fim' => ['required', 'date']
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute não pode ser vazio.',
            'date' => 'O campo :attribute deve ser uma data'
        ];        
    }

    public function attributes()
    {
        return [
            'data_inicio' => 'data início',
            'data_fim' => 'data_fim'
        ];
    }
}

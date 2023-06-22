<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetSalesByPeriodSaleRequest extends FormRequest
{
    protected $redirectRoute = 'sales.index';
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

    public function attributes(): array
    {
        return [
            'data_inicio' => 'data início',
            'data_fim' => 'data fim'
        ];
    }
}

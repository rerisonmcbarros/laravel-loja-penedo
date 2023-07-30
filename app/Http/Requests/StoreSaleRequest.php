<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    protected $redirectRoute = 'sales.create'; 
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
            'client_data' => ['required', 'max:255'],
            'total_value' => ['required', 'numeric'],
            'discount' => ['required', 'integer'],
            'payment' => ['required', 'max:255']
        ];
    }

    public function attributes()
    {
        return [
            'client_data' => 'dados do cliente',
            'total_value' => 'valor total',
            'discount' => 'desconto',
            'payment' => 'pagamento'
        ];
    }
}

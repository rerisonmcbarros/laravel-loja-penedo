<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    protected $redirectRoute = 'products.create';
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
            'category_id' => ['required'],
            'code' => ['required', 'unique:products', 'numeric', 'max_digits:255'],
            'description' => ['required', 'max:255'],
            'purchase_price' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'storage' => ['required', 'integer', 'gt:0'],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'categoria',
            'code' => 'código',
            'description' => 'descrição',
            'purchase_price' => 'preço de compra',
            'sale_price' => 'preço de venda',
            'storage' => 'quantidade',
        ];
    }
}

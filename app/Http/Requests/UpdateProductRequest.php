<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $id = Route::getCurrentRoute()->parameter('product');
        return [
            'category_id' => ['required'],
            'code' => ['required', Rule::unique('products', 'code')->ignore($id), 'numeric', 'max:255'],
            'description' => ['required', 'max:255'],
            'purchase_price' => ['required', 'numeric'],
            'sale_price' => ['required', 'numeric'],
            'storage' => ['required', 'integer'],
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
            'storage' => 'estoque',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userId = Route::getCurrentRoute()->parameter('user');
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', Rule::unique('users', 'email')->ignore($userId), 'max:255'],
            'password' => ['nullable', Password::min(8)->letters()->numbers(), 'max:255'],
            'is_admin' => ['nullable', 'boolean', 'min:0', 'max:1']
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'password' => 'senha'
        ];
    }
}

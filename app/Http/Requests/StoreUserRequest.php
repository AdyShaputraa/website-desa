<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nik' => ['nullable', 'digits:16', 'unique:users,nik'],
            'phone' => ['nullable', 'string', 'max:20'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string', Rule::exists('roles', 'name')],
            'is_active' => ['boolean'],
        ];
    }
}

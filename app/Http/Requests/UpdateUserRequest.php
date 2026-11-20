<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'nik' => ['nullable', 'digits:16', Rule::unique('users', 'nik')->ignore($user?->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string', Rule::exists('roles', 'name')],
            'is_active' => ['boolean'],
        ];
    }
}

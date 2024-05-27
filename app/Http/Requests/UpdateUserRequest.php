<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:255', 'min:3', 'unique:users,name'],
            'newMail'         => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'oldPassword'     => ['nullable', 'current_password:web'],
            'newPassword'     => ['nullable', 'string', 'min:8'],
            'confirmPassword' => ['nullable', 'string', 'same:newPassword'],
            'userId'          => ['required', 'integer', 'exists:users,id'],
        ];
    }
}

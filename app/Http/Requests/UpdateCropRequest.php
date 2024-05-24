<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCropRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $crop = $this->route('crop');
        return Auth::check() && Auth::id() === $crop->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'        => ['required', 'string', 'max:255'],
            'image'       => ['required', 'string', 'min:3'],
            'description' => ['required', 'string'],
        ];

        if ($this->hasFile('imageFile')) {
            $rules['imageFile'] = 'image';
        }

        return $rules;
    }
}

<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBlogArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'title'     => 'required|string|max:255',
            'content'   => 'required|string',
            'image'     => 'required|string',
            'imageFile' => 'image',
            'tags'      => 'required|array',
            'id'        => 'required|exists:blog_articles,id',
            'user_id'   => 'required|exists:users,id'
        ];
    }
}

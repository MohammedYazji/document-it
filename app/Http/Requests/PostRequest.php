<?php

namespace App\Http\Requests;

use App\Rules\Restricted;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:3',
            'content' => ['nullable', 'string', 'max:999999', new Restricted(['spam', 'scam', 'hack'])],
            'cover_image' => 'nullable|image|mimetypes:image/*|dimensions:min_width=400,min_height=400,max_width=2000,max_height=2000',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:published,draft',
            'tags' => 'nullable|string|max:1000',
            'published_at' => 'nullable|date',
            'meta' => 'nullable|array',
            'meta.title' => 'nullable|string|max:255',
            'meta.description' => 'nullable|string|max:500',
            'meta.keywords' => 'nullable|string|max:255',
            'meta.url' => 'nullable|url',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'title.required' => 'The Post Title is a must!!',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'post title',
            'content' => 'post content',
            'cover_image' => 'cover image',
            'category_id' => 'category',
            'tags' => 'tags',
        ];
    }
}

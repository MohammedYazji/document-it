<?php

namespace App\Http\Requests;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:3',
            'content' => ['required', 'string', 'max:999999', new \App\Rules\Restricted(['spam', 'scam', 'hack'])],
            'cover_image' => 'nullable|image|mimetypes:image/*|dimensions:min_width=400,min_height=400,max_width=2000,max_height=2000',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:published,draft',
            'tags' => ['nullable', 'string', 'max:1000'],
            'published_at' => 'nullable|date',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'required'       => ':attribute is required',
            'title.required' => 'The Post Title is a must!!',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title'       => 'post title',
            'content'     => 'post content',
            'cover_image' => 'cover image',
            'category_id' => 'category',
            'tags'        => 'tags',
        ];
    }
}

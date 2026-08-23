<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'        => 'nullable|string|max:255',
            'content'      => 'nullable|string',
            'category'     => 'required|string|max:100',
            'status'       => 'required|in:draft,published',
            'thumbnail'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'pdf_file'     => 'nullable|mimes:pdf|max:10240',
            'published_at' => 'nullable|date',
        ];
    }
}

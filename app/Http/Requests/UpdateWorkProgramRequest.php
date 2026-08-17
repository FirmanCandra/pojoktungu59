<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkProgramRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'description' => 'required|string',
            'status'      => 'required|in:berjalan,selesai',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ];
    }
}

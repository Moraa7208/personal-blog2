<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'     => 'required',
            'image'     => 'nullable|image|dimensions:max_width=100,max_height=200',
            'post'      => 'required',
            'category'  => 'required|integer|exists:categories,id',
            'tags'      => 'required'
        ];
    }
}

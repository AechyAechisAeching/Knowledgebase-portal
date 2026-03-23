<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
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
            'title' => 'sometimes|required',
            'content' => 'sometimes|required',
            'summary' => 'sometimes|nullable',
            'visibility' => 'sometimes|required',
            'status' => 'sometimes|required',
            'project_id' => 'sometimes|required|exists:projects,id',
            'category_id' => 'sometimes|required|exists:categories,id'
        ];

    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
        'comment' => 'required|string|max:500',
        'helpful' => 'required|boolean',
        'article_id' => 'nullable|exists:article,id',
        ];
    }


    // Forces to accept the helpful boolean
    protected function prepareForValidation()
{
    $this->merge([
        'helpful' => filter_var($this->helpful, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
    ]);
}

    public function messages() {
        return [
        'comment.required' => 'Beoordeel ons!',
        'helpful.required' => 'Beoordeel.'
        ];
    }
}

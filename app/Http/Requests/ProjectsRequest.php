<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectsRequest extends FormRequest
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
            'projectname' => 'required|string',
            'description' => 'required|string',
            'slug' => 'unique:projects,slug',
            'category_id' => 'required|exists:categories,id',
            'workspace_id' => 'required|exists:workspaces,id'
        ];
    }


    public function messages(): array {
        return [
            'projectname.required' => 'Het invullen van een projectnaam is verplicht.',
            'description.required' => 'Een descriptie is verplicht.',
            'category_id.required' => 'Je hebt een categorie nodig!',
            'workspace_id.required' => 'Je hebt een workspace nodig!'            
            ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Workspace;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'title' => 'required|string',
            'content' => 'required|string',
            'summary' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'category_id' => 'nullable|exists:categories,id',
            'workspace_id' => 'required|exists:workspaces,id',
            'visibility' => 'required|in:public,private',
            'status' => 'required|in:draft,published,archived',
            'article_id' => 'nullable|exists:articles,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,webm|max:10240',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        if (!$this->workspace_id) {
            return true;
        }

        $workspace = Workspace::find($this->workspace_id);
        if (!$workspace) {
            return false;
        }
        return $workspace->members()->where('user_id', auth()
        ->id())->exists();
     }
     
    protected function prepareForValidation(): void
{
    if ($this->hasFile('attachments')) {
        $this->merge([
            'attachments' => $this->file('attachments'),
        ]);
    }
}

    public function messages() {

    return [
        'title.required' => 'Het invullen van een titel is verplicht.',
        'content.required' => 'Het invullen van een titel is verplicht.',
        'workspace_id.required' => 'Een workspace is verplicht om een project aan te maken.',
        'attachments.*.file' => 'Voeg een geldig bestand in.',
        'attachments.*.mimes' => 'Alleen jpg, png, pdf, doc en docx zijn toegestaan.',
        'attachments.*.max' => 'Een bestand mag niet groter zijn dan 10MB.',
    ];
    }
}



<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $userId   = $isUpdate ? $this->route('user')?->id : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', "unique:users,email,{$userId}",
            ],

            'password' => [
                $isUpdate ? 'sometimes' : 'required', 'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Dit email is al in gebruik.',
            'password.confirmed' => 'De wachtwoorden komen niet overeen.',            
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('password')) {
            $this->merge([
                'password' => bcrypt($this->password),
            ]);
        }
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:15',
            'company' => 'nullable|string',
            'address' => 'nullable|string',
            'password' => 'required|min:8',
        ];
}
        public function messages(): array
        {
            return [
                'name.required'=> 'Het invullen van je naam is verplicht.',
                'email.required'=> 'Je email invullen is verplicht',
                'password'=> 'Vul een wachtwoord in!'
                ];
        }
    
}

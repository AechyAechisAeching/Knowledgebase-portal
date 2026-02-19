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
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'phone_number' => 'nullable|string',
            'company' => 'nullable|string',
            'address' => 'nullable|string', 
        ];
}
        public function messages(): array
        {
            return [
                'name.required'=> 'Het invullen van je naam is verplicht.',
                'email.required'=> 'Je email invullen is verplicht',
                'password'=> 'Vul een wachtwoord in!',
                'phone_number.required' => 'optioneel',
                'company.required' => 'Bedrijf',
                'address.required' => 'optioneel'
                ];
        }
    
}

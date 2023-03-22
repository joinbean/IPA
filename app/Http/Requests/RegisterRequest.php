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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Ein Name ist erforderlich',
            'name.string' => 'Ein Name muss ein String sein',
            'name.max' => 'Ein Name kann maximal 255 Zeichen lang sein',
            'email.required' => 'Eine E-Mail Adresse ist erforderlich',
            'email.string' => 'Eine E-Mail Adresse muss ein String sein',
            'email.email' => 'Die E-Mail Adresse ist im falschen Format',
            'email.max' => 'Eine E-Mail Adresse kann maximal 255 Zeichen lang sein',
            'email.unique' => 'Diese E-Mail Adresse existiert bereits',
            'password.required' => 'Ein Passwort ist erforderlich',
            'password.string' => 'Ein Passwort muss ein String sein',
        ];
    }
}

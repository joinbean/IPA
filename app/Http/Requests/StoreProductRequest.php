<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'shop_id' => 'required|exists:App\Models\Shop,id',
            'name' => 'required|max:255',
            'image' => 'image'
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
            'shop_id.required' => 'Eine Shop ID ist erforderlich',
            'shop_id.exists' => 'Shop-Datensatz nicht gefunden',
            'name.required' => 'Ein Name ist erforderlich',
            'name.max' => 'Ein Name kann maximal 255 Zeichen lang sein',
            'image.image' => 'Muss eine Bilddatei sein',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'shop_id' => 'exists:App\Models\Shop,id',
            'name' => 'max:255',
            'image' => 'nullable|sometimes|image'
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
            'shop_id.exists' => 'Shopdatensatz nicht gefunden',
            'name.max' => 'Ein Name kann maximal 255 Zeichen lang sein',
            'image.image' => 'Muss eine Bilddatei sein',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'note' => 'max:2000',
            'ordered_at' => 'required|date',
            'orderProducts' => 'array',
            'orderProducts.*.product_id' => 'required|exists:App\Models\Product,id',
            'orderProducts.*.volume' => 'required|integer|min:1',
            'orderProducts.*.price' => 'required|integer|min:10'
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
            'note.max' => 'Eine Notiz kann maximal 2000 Zeichen beinhalten',
            'ordered_at.required' => 'Ein Datum ist erforderlich',
            'ordered_at.date' => 'Muss ein Datum im Format YYYY-MM-DD sein',
            'orderProducts.array' => 'Muss ein Array sein',
            'orderProducts.*.product_id.required' => 'Eine Produkt ID ist erforderlich',
            'orderProducts.*.product_id.exists' => 'Produktdatensatz nicht gefunden',
            'orderProducts.*.volume.required' => 'Ein Volumen ist erforderlich',
            'orderProducts.*.volume.integer' => 'Ein Volumen muss ein Integer sein',
            'orderProducts.*.volume.min' => 'Es ist ein Volumen von mindestens 1 erforderlich',
            'orderProducts.*.price.required' => 'Ein Preis ist erforderlich',
            'orderProducts.*.price.integer' => 'Ein Preis muss ein Integer sein',
            'orderProducts.*.price.min' => 'Es ist ein Preis von mindestens 5 Rappen erforderlich',
        ];
    }
}

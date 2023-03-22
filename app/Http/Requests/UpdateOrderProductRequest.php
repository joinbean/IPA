<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderProductRequest extends FormRequest
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
            'order_id' => 'exists:App\Models\Order,id',
            'product_id' => 'exists:App\Models\Product,id',
            'recieved_at' => 'date',
            'volume' => 'integer|min:1',
            'price' => 'integer|min:10'
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
            'order_id.exists' => 'Bestelldatensatz nicht gefunden',
            'product_id.exists' => 'Produktdatensatz nicht gefunden',
            'recieved_at.date' => 'Muss ein Datum im Format YYYY-MM-DD sein',
            'volume.integer' => 'Ein Volumen muss ein Integer sein',
            'volume.min' => 'Es ist ein Volumen von mindestens 1 erforderlich',
            'price.integer' => 'Ein Preis muss ein Integer sein',
            'price.min' => 'Es ist ein Preis von mindestens 5 Rappen erforderlich',
        ];
    }
}

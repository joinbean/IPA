<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="OrderProducts"),
 * @OA\Property(property="product", type="object", ref="#/components/schemas/ProductResource"),
 * @OA\Property(property="recieved_at", type="string", maxLength=32, example="null"),
 * @OA\Property(property="volume", type="integer", example=25),
 * @OA\Property(property="price", type="integer", example=100),
 * @OA\Property(property="price_total", type="integer", example=2500),
 * )
 *
 */

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product' => new ProductResource($this->product),
            'recieved_at' => $this->recieved_at,
            'volume' => $this->volume,
            'price' => $this->price,
            'price_total' => $this->volume * $this->price
        ];
    }
}

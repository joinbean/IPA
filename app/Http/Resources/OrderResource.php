<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Orders"),
 * @OA\Property(property="ordered_at", type="string", maxLength=32, example="1991-06-14"),
 * @OA\Property(property="user", type="string", maxLength=32, example="Hans"),
 * @OA\Property(property="completed", type="bool", example="false"),
 * @OA\Property(property="ordered_products", type="array", collectionFormat="multi",
 *      @OA\Items(ref="#/components/schemas/OrderProductResource"),
 * ),
 * @OA\Property(property="order_price", type="integer", maxLength=32, example="2500"),
 * @OA\Property(property="note", type="string", maxLength=32, example="This is a note about taking notes off things"),
 * )
 *
 */

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $ordered_products = OrderProductResource::collection($this->orderProducts);

        return [
            'ordered_at' => $this->ordered_at,
            'user' => $this->user->name,
            'completed' => $this->status(),
            'ordered_products' => $ordered_products,
            'order_price' => $ordered_products->sum(function($product){
                return $product->price * $product->volume;
            }),
            'note' => $this->note
        ];
    }
}

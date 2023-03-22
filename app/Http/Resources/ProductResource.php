<?php

namespace App\Http\Resources;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Products"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="shop", type="string", readOnly="true", example="Digitec"),
 * @OA\Property(property="name", type="string", maxLength=32, example="USB cable"),
 * @OA\Property(property="image", type="string", maxLength=32, example="977630ae369389ee38ca474af9e3d30e.png"),
 * )
 *
 */

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'shop' => Shop::find($this->shop_id)->name,
            'name' => $this->name,
            'image' => $this->image
        ];
    }
}

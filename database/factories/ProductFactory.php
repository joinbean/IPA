<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = [
            'name' => fake()->word(),
            'shop_id' => Shop::all()->random()->id
        ];

        switch (rand(1,2)) {
            case 1:
                $product['image'] = fake()->image('storage/app/image', 400, 300, null, false);
                break;
            case 2:
                $product['image'] = null;
                break;
        }

        return $product;
    }
}

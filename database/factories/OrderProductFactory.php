<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderProduct = [
            'order_id' => Order::all()->random()->id,
            'product_id' => Product::all()->random()->id,
            'volume' => rand(1, 10),
            'price' => rand(100, 10000)
        ];

        switch (rand(1,2)) {
            case 1:
                $orderProduct['recieved_at'] = fake()->date('Y-m-d', 'now');
                break;
            case 2:
                $orderProduct['recieved_at'] = null;
                break;
        }

        return $orderProduct;
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $order = [
            'user_id' => User::all()->random()->id,
            'ordered_at' => fake()->date('Y-m-d', 'now')
        ];

        switch (rand(1,2)) {
            case 1:
                $order['note'] = fake()->sentences(rand(1, 5), true);
                break;
            case 2:
                $order['note'] = null;
                break;
        }

        return $order;
    }
}

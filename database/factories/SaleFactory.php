<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Region;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pick a random existing product
        $product = Product::inRandomOrder()->first();

        // Pick a random existing region
        $region = Region::inRandomOrder()->first();

        // Random quantity
        $quantity = $this->faker->numberBetween(1, 20);

        return [
            'product_id' => $product->id,
            'region_id' => $region->id,
            'quantity' => $quantity,
            'revenue' => $product->price * $quantity, // REAL revenue based on product price
            'sale_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

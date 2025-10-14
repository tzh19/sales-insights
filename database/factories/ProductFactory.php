<?php

namespace Database\Factories;

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
        $names = [
            'Laptop', 'Smartphone', 'Headphones', 'Keyboard', 'Monitor', 
            'Chair', 'Table', 'Backpack', 'Camera', 'Smartwatch'
        ];

        $categories = ['Electronics', 'Furniture', 'Clothing', 'Books', 'Toys'];

        return [
            'name' => $this->faker->randomElement($names),       // pick a name
            'category' => $this->faker->randomElement($categories),
            'price' => $this->faker->randomFloat(2, 10, 500),   // $10-$500
        ];
    }
}

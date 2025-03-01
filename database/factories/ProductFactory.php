<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
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
        $product_name = $this->faker->sentence;
        return [
            'uuid' => Str::uuid(),
            'name' => $product_name,
            'slug' => Str::slug($product_name),
            'price' => rand(1, 100),
            'image' => $this->faker->imageUrl(),
            'description' => $this->faker->paragraph,
        ];
    }
}

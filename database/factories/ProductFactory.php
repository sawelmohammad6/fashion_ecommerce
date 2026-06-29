<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'fabric' => fake()->randomElement(['Cotton', 'Polyester', 'Silk', 'Linen', 'Denim']),
            'color' => fake()->randomElement(['Red', 'Blue', 'Black', 'White', 'Green']),
            'print' => fake()->randomElement(['Solid', 'Striped', 'Floral', 'Graphic', 'Plain']),
            'size' => 'S, M, L, XL',
            'price' => fake()->randomFloat(2, 10, 200),
            'discount_price' => null,
            'stock' => fake()->numberBetween(0, 100),
            'status' => true,
            'featured' => false,
        ];
    }
}

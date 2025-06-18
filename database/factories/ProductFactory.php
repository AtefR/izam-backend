<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->numberBetween(100, 1000),
            'stock' => $this->faker->numberBetween(10, 300),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'category_id' => Category::factory(),
        ];
    }

    public function configure(): ProductFactory
    {
        return $this->afterCreating(function (Product $product) {
            $tempImage = tmpfile();
            $metaData = stream_get_meta_data($tempImage);
            $tempPath = $metaData['uri'];

            file_put_contents($tempPath, file_get_contents('https://placehold.co/600x400.png'));

            $product
                ->addMedia($tempPath)
                ->preservingOriginal()
                ->toMediaCollection('preview');
        });
    }
}

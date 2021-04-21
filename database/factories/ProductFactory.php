<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productsuffix = ['Sweater', 'Pants', 'Shirt', 'Hat', 'Socks'];
        $name = $this->faker->company . ' ' . Arr::random($productsuffix);

        $nameArr = explode(' ', $name);
        $name = trim($nameArr[0]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->realText(320),
            'price' => $this->faker->numberBetween(10, 1000)
        ];
    }
}

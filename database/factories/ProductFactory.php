<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'ships_from' => $this->faker->country,
            'price' => $this->faker->numberBetween(1000, 20000),
            'user_id' => function() {
                return User::all()->random();
            },
            'company_id' => function() {
                return Company::all()->random();
            },
        ];
    }
}

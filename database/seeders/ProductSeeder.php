<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Product::factory()->count(30)->create()->each(function ($product) {
            $product->reviews()->createMany(\App\Models\Review::factory()->count(5)->make()->toArray());
        });
    }
}

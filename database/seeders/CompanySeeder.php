<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Company::factory()->count(30)->create()->each(function ($company) {
            $company->products()->createMany(\App\Models\Product::factory()->count(5)->make()->toArray());
        });
    }
}

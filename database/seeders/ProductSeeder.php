<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Generate 50 products
        for ($i = 0; $i < 50; $i++) {
            Product::create([
                'name' => $faker->word, // Generates a random single word for the product name
                'description' => $faker->sentence, // Generates a random sentence for the description
                'price'=>0
            ]);
        }
    }
}

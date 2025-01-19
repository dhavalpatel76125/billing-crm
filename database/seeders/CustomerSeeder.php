<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Generate 50 customers
        for ($i = 0; $i < 50; $i++) {
            Customer::create([
                'name' => $faker->name,
                'phone' => $faker->numerify('##########'), // Generates a 10-digit phone number
            ]);
        }
    }
}

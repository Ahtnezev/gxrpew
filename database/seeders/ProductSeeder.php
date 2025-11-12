<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

use function Symfony\Component\Clock\now;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_MX');

        for ($i=1; $i <= 20; $i++) {
            DB::table('products')->insert([
                'name'=> ucfirst(implode(' ', $faker->words(3))),
                'description'=> $faker->sentence(10),
                'price'=> $faker->randomFloat(2, 50, 2000),
                'stock'=> $faker->numberBetween(0, 500),
                'meli_item_id' => 'MLM' . $faker->numberBetween(1000000000, 9999999999),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}

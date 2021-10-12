<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('ar_SA');

        foreach (range(1,50) as $index) {
            $name = $faker->word.$index;

            Product::create([
                'name'           => $name,
                'slug'           => make_slug($name),
                'description'    => $faker->realText(10),
                'price'          => $faker->numberBetween(1,1000),
                'store_id'       => 1,
            ]);
        }
    }
}

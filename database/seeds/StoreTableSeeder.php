<?php

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::create([
            'name'           => 'twig test',
            'slug'           => 'twig-test',
            'user_id'        => 1,
        ]);
    }
}

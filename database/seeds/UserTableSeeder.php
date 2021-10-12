<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'           => 'merchant',
            'email'          => 'merchant@store.com',
            'password'       => bcrypt('merchant_123'),
            'remember_token' => Str::random(60),
            'user_type'      => 'Merchant',
        ]);

        User::create([
            'name'           => 'user',
            'email'          => 'user@store.com',
            'password'       => bcrypt('user_123'),
            'remember_token' => Str::random(60),
            'user_type'      => 'User',
        ]);
    }
}

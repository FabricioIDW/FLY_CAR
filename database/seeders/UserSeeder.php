<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            // 'id' => 10003213123123133,
            'email' => 'fabri@gmail.com',
            'password' => bcrypt('laravel12'),
        ])->assignRole('Admin');
        User::create([
            'email' => 'yamil@gmail.com',
            'password' => bcrypt('laravel12'),
        ])->assignRole('Customer');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Seller;
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
        // Usuario admin
        User::create([
            'email' => 'fabri@gmail.com',
            'password' => bcrypt('laravel12'),
        ])->assignRole('Admin');
        
        // Usuario y cliente para Yamil
        $yamil = User::create([
            'email' => 'yamil@gmail.com',
            'password' => bcrypt('laravel12'),
        ])->assignRole('Customer');
        Customer::create([
            'dni' => 38512719,
            'name' => 'Yamil',
            'lastName' => 'Cruz',
            'birthDate' => '1998-02-21',
            'address' => 'Calle falsa 123',
            'email' => 'yamil@gmail.com',
            'user_id' => $yamil->id,
        ]);
        // Usuario y vendedor para Lucca
        $lucca = User::create([
            'email' => 'lucca@gmail.com',
            'password' => bcrypt('laravel12'),
        ])->assignRole('Seller');
        Seller::create([
            'dni' => 38711933,
            'name' => 'Lucca',
            'lastName' => 'Mansilla',
            'user_id' => $lucca->id,
        ]);
    }
}

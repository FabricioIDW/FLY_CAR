<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::create([
            'description' => 'Admin',
        ]);
        UserType::create([
            'description' => 'Cliente',
        ]);
        UserType::create([
            'description' => 'Vendedor',
        ]);
    }
}

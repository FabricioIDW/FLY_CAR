<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id = $this->faker->unique()->numberBetween(1, 25);
        return [
            'dni' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'name' => $this->faker->name(15),
            'lastName' => $this->faker->name(15),
            'birthDate' => $this->faker->date(),
            'address' => $this->faker->address(),
            'email' => User::find($id)->email,
            'user_id' => $id,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'discount' => $this->faker->randomFloat(5, 1, 50),
            'startDate' => $this->faker->date(),
            'endDate' => $this->faker->date(),
        ];
    }
}

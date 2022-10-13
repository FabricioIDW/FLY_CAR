<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Offer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AccessoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(20),
            'stock' => $this->faker->numberBetween(1, 50),
            'description' => $this->faker->text(100),
            'image' => $this->faker->imageUrl(),
            'offer_id' => Offer::all()->random()->id,
        ];
    }
}

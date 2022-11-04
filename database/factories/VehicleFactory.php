<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\VehicleModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $model = VehicleModel::all()->random();
        $imagePath = '/vehicles/'. $model->brand->name . ' ' . $model->name . '.jpg';
        return [
            'chassis' => $this->faker->unique()->numberBetween(11111111111111111, 99999999999999999),
            'price' => $this->faker->randomFloat(2, 500000, 14500500),
            'description' => $this->faker->text(100),
            'year' => $this->faker->numberBetween(2014, 2022),
            'image' => $imagePath,
            'offer_id' => Offer::all()->random()->id,
            'vehicle_model_id' => $model->id,
        ];
    }
}

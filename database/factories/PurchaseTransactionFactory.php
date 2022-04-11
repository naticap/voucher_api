<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "total_spent" => $this->faker->numberBetween(101, 1000),
            "total_saving" => $this->faker->numberBetween(1, 100)
        ];
    }
}

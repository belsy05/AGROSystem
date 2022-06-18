<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rango>
 */
class RangoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'FacturaInicio' => $this->faker->numerify('0000000000000001'),
            'FacturaFin' => $this->faker->numerify('1234567890123459'),
            'FechaLimite' => $this->faker->dateTimeBetween($startDate = '+7 months', $endDate = '+7 months')->format("Y-m-d")
        ];
    }
}

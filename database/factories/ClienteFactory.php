<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'IdentidadDelCliente' =>substr(str_repeat(0, 2).
                    $this->faker->numberBetween($min = 1, $max = 18), - 2).substr(str_repeat(0, 2).
                    $this-> faker -> numberBetween($min = 1, $max = 28), - 2).
                    $this-> faker -> numberBetween($min =1957, $max = 2004).
                    $this->faker->unique()-> numerify('#####'),
            'NombresDelCliente' => $this->faker->firstName($gender = null).' '.$this->faker->firstName($gender = null),
            'ApellidosDelCliente' => $this->faker -> lastname().' '. $this->faker->lastname(),
            'Telefono' => $this->faker->randomElement([3,8,9]).$this->faker->unique()->numerify('#######'),
            'LugarDeProcedencia' => $this->faker->address()
        ];
    }
}

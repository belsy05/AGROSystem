<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personal>
 */
class PersonalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cargo_id'  => $this->faker->numberBetween(1,5),
            'IdentidadDelEmpleado' =>substr(str_repeat(0, 2).
                    $this->faker->numberBetween($min = 1, $max = 18), - 2).substr(str_repeat(0, 2).
                    $this-> faker -> numberBetween($min = 1, $max = 28), - 2).
                $this-> faker -> numberBetween($min =1957, $max = 2004).
                $this->faker->unique()-> numerify('#####'),
            'NombresDelEmpleado' => $this->faker->firstName($gender = null).' '.$this->faker->firstName($gender = null),
            'ApellidosDelEmpleado' => $this->faker -> lastname().' '. $this->faker->lastname(),
            'CorreoElectrónico' => $this->faker->unique()->freeEmail(),
            'Teléfono' => $this->faker->randomElement([3,8,9]).$this->faker->unique()->numerify('#######'),
            'FechaDeNacimiento' => $this->faker->date($format = 'Y-m-d', $max = '-18 years'),
            'FechaDeIngreso'  => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'Ciudad' => $this->faker->city(),
            'Dirección' => $this->faker->address(),
            'EmpleadoActivo' => $this->faker->randomElement(['Activo','Inactivo'])
        ];
    }
}

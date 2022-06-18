<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedor>
 */
class ProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
        'EmpresaProveedora' => $this->faker->firstName($gender = null).' '.$this->faker->randomElement(['S de RL','SA']),
        'DirecciónDeLaEmpresa' => $this->faker->address(),
        'CorreoElectrónicoDeLaEmpresa' => $this->faker->unique()->freeEmail(),
        'TeléfonoDeLaEmpresa' => $this->faker->unique()->numerify('2763####'),
        'NombresDelEncargado'  => $this->faker->firstName($gender = null).' '.$this->faker->firstName($gender = null),
        'ApellidosDelEncargado' => $this->faker -> lastname().' '. $this->faker->lastname(),
        'TeléfonoDelEncargado' => $this->faker->randomElement([3,8,9]).$this->faker->unique()->numerify('#######')
        ];
    }
}

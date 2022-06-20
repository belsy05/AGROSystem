<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cargo>
 */
class CargoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'NombreDelCargo' => $this->faker->randomElement($array = array ('Gerente','Cajero','Vigilancia','Aseo',
                'Técnico en Informática','Técnico en Maquinaria Agrícola','Sanidad Animal')),
            'DescripciónDelCargo' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'Sueldo'  => $this->faker->numerify('#####.##'),
        ];
    }
}

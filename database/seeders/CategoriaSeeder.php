<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create(
            [
                'NombreDeLaCategoría'=>'Insumo Agrícola',
                'DescripciónDeLaCategoría'=>'Sección de productos orientados a proteger al cultivo de las plagas y enfermedades',
                'vencimiento'=>0,
                'elaboracion'=>0
            ]
        );

        Categoria::create(
            [
                'NombreDeLaCategoría'=>'Medicina para Animales',
                'DescripciónDeLaCategoría'=>'Sección de productos orientados a prevenir y cuidar de la salud de los animales',
                'vencimiento'=>0,
                'elaboracion'=>0
            ]
        );

        Categoria::create(
            [
                'NombreDeLaCategoría'=>'Fertilizante',
                'DescripciónDeLaCategoría'=>'Sección de productos orientados a fortalecer y garantizar el correcto desarrollo de los cultivos',
                'vencimiento'=>1,
                'elaboracion'=>1
            ]
        );

        Categoria::create(
            [
                'NombreDeLaCategoría'=>'Herramienta',
                'DescripciónDeLaCategoría'=>'Sección de los productos necesarios para poder realizar la siembra, manejo y cosecha de los cultivos',
                'vencimiento'=>1,
                'elaboracion'=>1
            ]
        );

        Categoria::create(
            [
                'NombreDeLaCategoría'=>'Alimentos',
                'DescripciónDeLaCategoría'=>'Sección de productos orientada a la alimentación de los diferentes animales',
                'vencimiento'=>0,
                'elaboracion'=>0
            ]
        );

        Categoria::create(
            [
                'NombreDeLaCategoría'=>'Repuestos',
                'DescripciónDeLaCategoría'=>'Sección de productos orientados a servir de sustitutos',
                'vencimiento'=>1,
                'elaboracion'=>1
            ]
        );
    }
}

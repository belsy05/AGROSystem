<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Presentacion;

class PresentacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Presentacion::create(
            [
                'informacion'=>'Octavo',
                'categoria_id'=>1,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'Litro',
                'categoria_id'=>1,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'Cuarto',
                'categoria_id'=>1,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'Bolsa',
                'categoria_id'=>1,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'10ml',
                'categoria_id'=>2,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'20ml',
                'categoria_id'=>2,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'30ml',
                'categoria_id'=>2,
            ]
        );
        Presentacion::create(
            [
                'informacion'=>'50ml',
                'categoria_id'=>2,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'100ml',
                'categoria_id'=>2,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'250ml',
                'categoria_id'=>2,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'Litro',
                'categoria_id'=>2,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'Quintal',
                'categoria_id'=>3,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'Grande',
                'categoria_id'=>4,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'Pequeña',
                'categoria_id'=>4,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'Quintal',
                'categoria_id'=>5,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'Medio quintal',
                'categoria_id'=>5,
            ]
        );

        Presentacion::create(
            [
                'informacion'=>'Unidad',
                'categoria_id'=>6,
            ]
        );
    }
}

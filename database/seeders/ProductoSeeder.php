<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create(
            [
                'categoria_id'=>1,
                'NombreDelProducto'=>'Glifosato',
                'DescripciónDelProducto'=>'Herbicida para el control de la maleza en áreas industriales,
                 céspedes y jardines',
                'Impuesto'=>0.15,
            ]
        );

        Producto::create(
            [
                'categoria_id'=>1,
                'NombreDelProducto'=>'Diflufenican',
                'DescripciónDelProducto'=>'Herbicida de aplicación en postemergencia temprana y/o preemergente
                 para el control de malezas de hoja ancha y algunas gramíneas anuales',
                'Impuesto'=>0.15,
            ]
        );
        Producto::create(
            [
                'categoria_id'=>1,
                'NombreDelProducto'=>'Triasulfuron',
                'DescripciónDelProducto'=>'Herbicida de aplicación post-emergente a la maleza y a los cultivos
                 de trigo y cebada',
                'Impuesto'=>0,
            ]
        );
        Producto::create(
            [
                'categoria_id'=>2,
                'NombreDelProducto'=>'Canapet',
                'DescripciónDelProducto'=>'Vitaminas y Minerales especiales para perros de 6 meses en adelante',
                'Impuesto'=>0,
            ]
        );
        Producto::create(
            [
                'categoria_id'=>2,
                'NombreDelProducto'=>'Comfortis Antipulgas',
                'DescripciónDelProducto'=>'Tabletas masticables antipulgas para perros y gatos de 14 semanas de edad, elaboradas a partir de spinosad,
                 un insecticida de origen natural.',
                'Impuesto'=>0.15,
            ]
        );
        Producto::create(
            [
                'categoria_id'=>3,
                'NombreDelProducto'=>'Urea',
                'DescripciónDelProducto'=>'Fertilizante inorgánico granulado, que se aplica directo al suelo',
                'Impuesto'=>0.15,
            ]
        );
        Producto::create(
            [
                'categoria_id'=>3,
                'NombreDelProducto'=>'Sulfato amónico',
                'DescripciónDelProducto'=>'Fertilizante de aplicación directa, utilizado en cultivos extensivos como intensivos',
                'Impuesto'=>0,
            ]
        );
        Producto::create(
            [
                'categoria_id'=>4,
                'NombreDelProducto'=>'Machete',
                'DescripciónDelProducto'=>'Herramienta especial para segar la hierba, cortar la caña de azúcar, podar plantas y
                 abrirse paso en zonas boscosas.',
                'Impuesto'=>0,
            ]
        );
        Producto::create(
            [
                'categoria_id'=>4,
                'NombreDelProducto'=>'Pala',
                'DescripciónDelProducto'=>'Herramienta especial para cavar la tierra, excavar hoyos de plantación o trasladar el sustrato',
                'Impuesto'=>0.15,
            ]
        );
        Producto::create(
            [
                'categoria_id'=>5,
                'NombreDelProducto'=>'Dog Chow',
                'DescripciónDelProducto'=>'Concentrado enriquecido con multivitaminas, prebióticos y fibras naturales,
                 especial para perros adultos de razas medianas y grandes',
                'Impuesto'=>0.15,
            ]
        );
        Producto::create(
            [
                'categoria_id'=>5,
                'NombreDelProducto'=>'Whiskas',
                'DescripciónDelProducto'=>'Concentrado completo y balanceado perfecto para la alimentación de gatos adultos de todas las razas',
                'Impuesto'=>0,
            ]
        );
        Producto::create(
            [
                'categoria_id'=>5,
                'NombreDelProducto'=>'VITAENGORDE',
                'DescripciónDelProducto'=>'Concentrado de engorde para pollos en la primera etapa',
                'Impuesto'=>0,
            ]
        );
        Producto::create(
            [
                'categoria_id'=>6,
                'NombreDelProducto'=>'Boquillas',
                'DescripciónDelProducto'=>'Producto especial que se coloca en las bombas antes de realizar una aplicación',
                'Impuesto'=>0.15,
            ]
        );
    }
}

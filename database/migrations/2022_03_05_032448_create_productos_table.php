<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->string('CódigoDelProducto')->unique();
            $table->string('NombreDelProducto');
            $table->text('DescripciónDelProducto');
            $table->string('PresentaciónDelProducto');
            $table->boolean('Impuesto');
            $table->date('FechaDeElaboración');
            $table->date('FechaDeVencimiento');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};

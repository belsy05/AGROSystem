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
        Schema::create('pedidos_clientes_temporals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('IdVenta')->nullable();
            $table->unsignedBigInteger('IdProducto');
            $table->foreign('IdProducto')->references('id')->on('productos');
            $table->unsignedBigInteger('IdPresentacion');
            $table->foreign('IdPresentacion')->references('id')->on('presentacions');
            $table->integer('Cantidad');
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
        Schema::dropIfExists('pedidos_clientes_temporals');
    }
};

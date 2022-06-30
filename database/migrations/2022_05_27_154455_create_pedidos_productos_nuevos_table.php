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
        Schema::create('pedidos_productos_nuevos', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id');
            $table->float('TotalAnticipo');
            $table->string('estado')->default('Sin reclamar');
            $table->date('FechaDelPedido');
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
        Schema::dropIfExists('pedidos_productos_nuevos');
    }
};

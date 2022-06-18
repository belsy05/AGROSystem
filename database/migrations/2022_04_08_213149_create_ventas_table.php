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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('NumFactura',16);
            $table->unsignedBigInteger('personal_id');
            $table->foreign('personal_id')->references('id')->on('personals');
            $table->integer('cliente_id')->nullable();
            // $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->date('FechaVenta')->format('%d/%m/%Y');
            $table->float('TotalVenta');
            $table->float('TotalImpuesto');
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
        Schema::dropIfExists('ventas');
    }
};

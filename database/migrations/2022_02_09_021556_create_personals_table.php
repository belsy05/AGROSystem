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
        Schema::create('personals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cargo_id');
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->string('IdentidadPersonal')->unique();
            $table->string('NombrePersonal');
            $table->string('ApellidoPersonal');
            $table->string('CorreoElectronico')->unique();
            $table->string('Telefono');
            $table->date('FechaNacimiento');
            $table->date('FechaIngreso');
            $table->string('Ciudad');
            $table->string('Direccion');
            $table->boolean('EmpleadoActivo')->default(true);
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
        Schema::dropIfExists('personals');
    }
};

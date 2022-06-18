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
            $table->string('IdentidadDelEmpleado', 15)->unique();
            $table->string('NombresDelEmpleado');
            $table->string('ApellidosDelEmpleado');
            $table->string('CorreoElectrónico')->unique();
            $table->string('Teléfono');
            $table->date('FechaDeNacimiento');
            $table->date('FechaDeIngreso');
            $table->string('Ciudad');
            $table->string('Dirección');
            $table->string('EmpleadoActivo')->default('Activo');
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

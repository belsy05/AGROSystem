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
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('EmpresaProveedora');
            $table->string('DirecciónDeLaEmpresa');
            $table->string('CorreoElectrónicoDeLaEmpresa')->unique()->nullable();
            $table->string('TeléfonoDeLaEmpresa');
            $table->string('NombresDelEncargado');
            $table->string('ApellidosDelEncargado');
            $table->string('TeléfonoDelEncargado');
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
        Schema::dropIfExists('proveedors');
    }
};
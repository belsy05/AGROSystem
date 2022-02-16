@extends('Plantillas.plantilla')

@section('titulo', 'Registro de cargos')

@section('contenido')

<h1> Registro de Cargo </h1>
<br><br>

<!-- PARA LOS ERRORES -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="">
    @csrf 

    <div class="form-group">
        <label for="NombreCargo"> Nombre </label>
        <input type="text" class="form-control" name="NombreCargo" id="NombreCargo" placeholder="Nombre del cargo">
    </div>

    <div class="form-group">
        <label for="DescripcionCargo"> Descripción </label>
        <textarea class="form-control" name="DescripcionCargo" id="DescripcionCargo" cols="30" rows="10" placeholder="Breve descripción de la función del puesto"></textarea>
    </div>

    <div class="form-group">
        <label for="Sueldo"> Sueldo </label>
        <input type="number" class="form-control" name="Sueldo" id="Sueldo" placeholder="00.00">
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Guardar">
    <input type="reset" class="btn btn-danger" value="Limpiar"> 
    <a class="btn btn-info" href="{{route('cargo.index')}}">Cerrar</a>
    
</form>

@endsection

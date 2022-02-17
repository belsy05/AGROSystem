@extends('Plantillas.plantilla')

@section('titulo', 'Editar Cargos')

@section('contenido')

<h1> Editar Cargos </h1>
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
    @method('put')
    @csrf <!-- PARA PODER ENVIAR EL FORMULARIO -->

    <div class="form-group">
        <label for="NombreCargo"> Nombre </label>
        <input type="text" class="form-control" name="NombreCargo" id="NombreCargo" placeholder="Nombre del cargo"
        value="{{$cargo->NombreCargo}}">
    </div>

    <div class="form-group">
        <label for="DescripcionCargo"> Descripción </label>
        <textarea class="form-control" name="DescripcionCargo" id="DescripcionCargo" cols="30" rows="10" placeholder="Breve descripción de la función del puesto">{{$cargo->DescripcionCargo}}
        </textarea>
    </div>

    <div class="form-group">
        <label for="Sueldo"> Sueldo </label>
        <input type="number" class="form-control" name="Sueldo" id="Sueldo" placeholder="00.00" value="{{$cargo->Sueldo}}">
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar" onclick="return confirm('¿Está seguro que desea actualizar los datos del cargo?')">
    <input type="reset" class="btn btn-danger" value="Restaurar"> 
    <a class="btn btn-info" href="{{route('cargo.index')}}">Cerrar</a>
</form> 
@endsection
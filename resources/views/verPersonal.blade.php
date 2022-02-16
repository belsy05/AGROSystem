@extends('plantillas.plantilla')
@section('titulo', 'Alumno')
@section('contenido')

<h1> Detalles de {{$personal->NombrePersonal}} {{$personal->ApellidoPersonal}}
</h1>
<br>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Campos</th>
            <th scope="col">Valor</th>
        </tr>  
    </thead>
    <tbody>
        <tr>
            <th scope="row">Cargo Id</th>
            <td scope="col">{{ $personal->cargo_id }} </td>
        </tr>
        <tr>
            <th scope="row"> Identidad </th>
            <td scope="col">{{ $personal->IdentidadPersonal}} </td>
        </tr>
        <tr>
            <th scope="row">Nombres</th>
            <td scope="col">{{ $personal->NombrePersonal }} </td>
        </tr>
        <tr>
            <th scope="row">Apellidos</th>
            <td scope="col">{{ $personal->ApellidoPersonal }} </td>
        </tr>
        <tr>
            <th scope="row">Correo Electrónico</th>
            <td scope="col">{{ $personal->CorreoElectronico}} </td>
        </tr>
        <tr>
            <th scope="row">Teléfono</th>
            <td scope="col">{{ $personal->Telefono }} </td>
        </tr>
        <tr>
            <th scope="row">Fecha De Nacimiento</th>
            <td scope="col">{{ $personal->FechaNacimiento}} </td>
        </tr>
        <tr>
            <th scope="row">Fecha De Ingreso</th>
            <td scope="col">{{ $personal->FechaIngreso}} </td>
        </tr>
        <tr>
            <th scope="row">Ciudad</th>
            <td scope="col">{{ $personal->Ciudad}} </td>
        </tr>
        <tr>
            <th scope="row">Dirección</th>
            <td scope="col">{{ $personal->Direccion}} </td>
        </tr>
    </tbody>
</table>

<a class="btn btn-primary" href="{{route('personal.index')}}"> Regresar </a>
@endsection
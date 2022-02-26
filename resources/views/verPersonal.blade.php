@extends('plantillas.plantilla')
@section('titulo', 'Personal')
@section('contenido')

<h1> Detalles de {{$personal->NombresDelEmpleado}} {{$personal->ApellidosDelEmpleado}}
</h1>
<br>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Campos</th>
            <th scope="col">Información del empleado</th>
        </tr>  
    </thead>
    <tbody>
        <tr>
            <th scope="row"> Identidad </th>
            <td scope="col">{{ $personal->IdentidadDelEmpleado}} </td>
        </tr>
        <tr>
            <th scope="row">Nombres</th>
            <td scope="col">{{ $personal->NombresDelEmpleado }} </td>
        </tr>
        <tr>
            <th scope="row">Apellidos</th>
            <td scope="col">{{ $personal->ApellidosDelEmpleado }} </td>
        </tr>
        <tr>
            <th scope="row">Correo Electrónico</th>
            <td scope="col">{{ $personal->CorreoElectrónico}} </td>
        </tr>
        <tr>
            <th scope="row">Teléfono</th>
            <td scope="col">{{ $personal->Teléfono }} </td>
        </tr>
        <tr>
            <th scope="row">Fecha De Nacimiento</th>
            <td scope="col">{{ $personal->FechaDeNacimiento}} </td>
        </tr>
        <tr>
            <th scope="row">Fecha De Ingreso</th>
            <td scope="col">{{ $personal->FechaDeIngreso}} </td>
        </tr>
        <tr>
            <th scope="row">Ciudad</th>
            <td scope="col">{{ $personal->Ciudad}} </td>
        </tr>
        <tr>
            <th scope="row">Dirección</th>
            <td scope="col">{{ $personal->Dirección}} </td>
        </tr>
    </tbody>
</table>

<a class="btn btn-primary" href="{{route('personal.index')}}"> Regresar </a>
@endsection
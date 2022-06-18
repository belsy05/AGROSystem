@extends('plantillas.plantilla')
@section('titulo', 'Servicio')
@section('contenido')

<h1> Detalles del servicio para {{$servicio->NombresDelCliente}} {{$servicio->ApellidosDelCliente}}
</h1>
<br><br>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Campos</th>
            <th scope="col">Información del empleado</th>
        </tr>  
    </thead>
    <tbody>
        <tr>
            <th scope="row"> Técnico </th>
            <td scope="col">{{ $cargo->NombreDelCargo}} </td>
        </tr>
        <tr>
            <th scope="row">Nombres</th>
            <td scope="col">{{ $servicio->personals->NombresDelEmpleado }} {{ $servicio->personals->ApellidosDelEmpleado }} </td>
        </tr>
        <tr>
            <th scope="row">Teléfono del técnico</th>
            <td scope="col">{{ $servicio->personals->Teléfono }} </td>
        </tr>
        <tr>
            <th scope="row">Cliente</th>
            <td scope="col">{{ $servicio->clientes->NombresDelCliente }} {{ $servicio->clientes->ApellidosDelCliente }} </td>
        </tr>       
        <tr>
            <th scope="row">Teléfono del cliente</th>
            <td scope="col">{{ $servicio->TeléfonoCliente }} </td>
        </tr>
        <tr>
            <th scope="row">Fecha del servicio </th>
            <td scope="col">{{\Carbon\Carbon::parse($servicio->FechaDeRealizacion)->locale("es")->isoFormat("DD MMMM, YYYY")}} </td>
        </tr>
        <tr>
            <th scope="row">Dirección</th>
            <td scope="col">{{ $servicio->Dirección}} </td>
        </tr>
        <tr>
            <th scope="row">Dirección</th>
            <td scope="col">{{ $servicio->Dirección}} </td>
        </tr>
    </tbody>
</table>

<a class="btn btn-primary" href="{{route('servicio.index')}}"> Regresar </a>
@endsection
@extends('plantillas.plantilla')
@section('titulo', 'Clientes')
@section('contenido')

<h1> Detalles de {{$cliente->NombresDelCliente}} {{$cliente->ApellidosDelCliente}}
</h1>
<br>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Campos</th>
            <th scope="col">Información del Cliente</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row"> Identidad </th>
            <td scope="col">{{$cliente->IdentidadDelCliente}} </td>
        </tr>
        <tr>
            <th scope="row">Teléfono</th>
            <td scope="col">{{ $cliente->Telefono }} </td>
        </tr>
        <tr>
            <th scope="row">Lugar de procedencia</th>
            <td scope="col">{{ $cliente->LugarDeProcedencia }} </td>
        </tr>
    </tbody>
</table>

<a class="btn btn-primary"  href="{{route('cliente.index')}}"> Regresar </a>
@endsection

@extends('plantillas.plantilla')
@section('titulo', 'Gasto')
@section('contenido')

<h1> Detalles de {{$gasto->nombre}}
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
            <th scope="row"> Nombre </th>
            <td scope="col">{{ $gasto->nombre}} </td>
        </tr>
        <tr>
            <th scope="row"> Descripcion </th>
            <td scope="col">{{ $gasto->descripcion}} </td>
        </tr>
        <tr>
            <th scope="row">Tipo de gasto</th>
            <td scope="col">{{ $gasto->tipo }} </td>
        </tr>
        <tr>
            <th scope="row">Fecha</th>
            <td scope="col">{{\Carbon\Carbon::parse($gasto->fecha)->locale("es")->isoFormat("DD MMMM, YYYY")}}</td>
        </tr>
        <tr>
            <th scope="row">Total del gasto</th>
            <td scope="col">{{ $gasto->total}} </td>
        </tr>
        <tr>
            <th scope="row">Responsable</th>
            <td scope="col">{{ $gasto->responsable }} </td>
        </tr>
    </tbody>
</table>

<a class="btn btn-primary" href="{{route('gasto.index')}}"> Regresar </a>
@endsection
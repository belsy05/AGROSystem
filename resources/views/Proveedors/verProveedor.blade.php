@extends('plantillas.plantilla')
@section('titulo', 'Proveedores')
@section('contenido')

<h1> Detalles de la empresa {{$proveedor->EmpresaProveedora}}
</h1>
<br><br>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Campos</th>
            <th scope="col">Información de la empresa</th>
        </tr>  
    </thead>
    <tbody>
        <tr>
            <th scope="row">Empresa proveedora</th>
            <td scope="col">{{ $proveedor->EmpresaProveedora}} </td>
        </tr>
        <tr>
            <th scope="row">Dirección</th>
            <td scope="col">{{ $proveedor->DirecciónDeLaEmpresa}} </td>
        </tr>

        <tr>
            <th scope="row">Correo electrónico</th>
            <td scope="col">{{ $proveedor->CorreoElectrónicoDeLaEmpresa}} </td>
        </tr>

        <tr>
            <th scope="row">Teléfono de la empresa</th>
            <td scope="col">{{ $proveedor->TeléfonoDeLaEmpresa }} </td>
        </tr>
    </tbody>   
</table>
<br>
<h1> Detalles del encargad@ {{$proveedor->NombresDelEncargado}} {{ $proveedor->ApellidosDelEncargado}}
</h1>
<br>

<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Campos</th>
            <th scope="col">Información del encargad@</th>
        </tr>  
    </thead>
    <tbody>

        <tr>
            <th scope="row">Nombres del encargado</th>
            <td scope="col">{{ $proveedor->NombresDelEncargado}} </td>
        </tr>

        <tr>
            <th scope="row">Apellidos del encargado</th>
            <td scope="col">{{ $proveedor->ApellidosDelEncargado}} </td>
        </tr>

        <tr>
            <th scope="row">Teléfono del encargado</th>
            <td scope="col">{{ $proveedor->TeléfonoDelEncargado }} </td>
        </tr>
        
    </tbody>
</table>
<br>

<a class="btn btn-primary" href="{{route('proveedor.index')}}"> Regresar </a>
@endsection
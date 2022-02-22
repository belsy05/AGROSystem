@extends('plantillas.plantilla')
@section('titulo', 'Proveedores')
@section('contenido')

<h1> Detalles de la {{$proveedor->EmpresaProveedora}}
</h1>
<br>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Campos</th>
            <th scope="col">Información de la empresa</th>
        </tr>  
    </thead>
    <tbody>
        <tr>
            <th scope="row">Empresa Proveedora</th>
            <td scope="col">{{ $proveedor->EmpresaProveedora}} </td>
        </tr>
        <tr>
            <th scope="row">Dirección</th>
            <td scope="col">{{ $proveedor->DirecciónDeLaEmpresa}} </td>
        </tr>

        <tr>
            <th scope="row">Correo Electrónico</th>
            <td scope="col">{{ $proveedor->CorreoElectrónicoDeLaEmpresa}} </td>
        </tr>

        <tr>
            <th scope="row">Teléfono de la Empresa</th>
            <td scope="col">{{ $proveedor->TeléfonoDeLaEmpresa }} </td>
        </tr>

        <tr>
            <th scope="row">Nombres del Encargado</th>
            <td scope="col">{{ $proveedor->NombresDelEncargado}} </td>
        </tr>

        <tr>
            <th scope="row">Apellidos del Encargado</th>
            <td scope="col">{{ $proveedor->ApellidosDelEncargado}} </td>
        </tr>

        <tr>
            <th scope="row">Teléfono del Encargado</th>
            <td scope="col">{{ $proveedor->TeléfonoDelEncargado }} </td>
        </tr>
        
    </tbody>
</table>

<a class="btn btn-primary" href="{{route('proveedor.index')}}"> Regresar </a>
@endsection
@extends('plantillas.plantilla')
@section('titulo', 'Producto')
@section('contenido')

<h1> Detalles de: {{$producto->NombreDelProducto}}
</h1>
<br>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Campos</th>
            <th scope="col">Información del producto</th>
        </tr>  
    </thead>
    <tbody>
        <tr>
            <th scope="row"> Categoría del producto </th>
            <td scope="col">{{ $categorias->NombreDeLaCategoría}} </td>
        </tr>
        <tr>
            <th scope="row">Código</th>
            <td scope="col">{{ $producto->CódigoDelProducto }} </td>
        </tr>
        <tr>
            <th scope="row">Nombre</th>
            <td scope="col">{{ $producto->NombreDelProducto }} </td>
        </tr>
        <tr>
            <th scope="row">CDescripción</th>
            <td scope="col">{{ $producto->DescripciónDelProducto}} </td>
        </tr>
        <tr>
            <th scope="row">Presentación</th>
            <td scope="col">{{ $producto->PresentaciónDelProducto }} </td>
        </tr>
        <tr>
            <th scope="row">Impuesto</th>
            <td scope="col">{{ $producto->Impuesto}} </td>
        </tr>
        <tr>
            <th scope="row">Fecha De elaboración</th>
            <td scope="col">{{ $producto->FechaDeElaboración}} </td>
        </tr>
        <tr>
            <th scope="row">Fecha de vencimiento</th>
            <td scope="col">{{ $producto->FechaDeVencimiento}} </td>
        </tr>
    </tbody>
</table>

<a class="btn btn-primary" href="{{route('producto.index')}}"> Regresar </a>
@endsection
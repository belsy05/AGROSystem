@extends('plantillas.plantilla')
@section('titulo', 'Compra')
@section('contenido')

<h1> Detalles de la Compra
</h1>
<br>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Información de la compra</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row"> Número de Factura </th>
            <td scope="col">{{ $compra->NumFactura}} </td>
        </tr>
        <tr>
            <th scope="row"> Proveedor </th>
            <td scope="col">{{ $compra->proveedors->EmpresaProveedora }}</td>
        </tr>
        <tr>
            <th scope="row">Fecha de compra</th>
            <td scope="col">{{\Carbon\Carbon::parse($compra->FechaCompra)->locale("es")->isoFormat("DD MMMM, YYYY")}} </td>
        </tr>

    </tbody>
</table>

<table class="table table-bordered border-dark mt-3" >
    <thead class="table table-striped table-hover">
        <tr class="success">
            <th scope="col">N°</th>
            <th scope="col">Producto</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio Unitario</th>
            <th scope="col">Total Compra</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalC = 0;
            $totalP = 0;
        @endphp
    @forelse ($detalles as $i => $de)
        <tr class="active">
            <th scope="row">{{ ($i+1) }}</th>
            <td scope="col">{{ $de->producto->NombreDelProducto .', '.$de->producto->DescripciónDelProducto}}</td>
            <td scope="col">{{ $de->Cantidad }}</td>
            <td scope="col">{{ $de->Precio_compra }}</td>
            <td scope="col">{{ $de->Cantidad*$de->Precio_compra}}</td>
        </tr>
        @php
            $totalC += $de->Cantidad ;
            $totalP += ($de->Cantidad*$de->Precio_compra);
        @endphp
    @empty
        <tr>
            <td colspan="4"> No hay detalles agregados </td>
        </tr>
    @endforelse

        <tr >
            <th scope="row"></th>
            <th scope="col">Total</th>
            <th scope="col">{{ $totalC }}</th>
            <td scope="col"></td>
            <th scope="col">{{ $totalP }}</th>
        </tr>
    </tbody>
</table>

<a class="btn btn-primary" href="{{route('compras.index')}}"> Regresar </a>
@endsection

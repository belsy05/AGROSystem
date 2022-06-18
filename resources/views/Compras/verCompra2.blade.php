@extends('plantillas.plantilla')
@section('titulo', 'Compra')
@section('contenido')

<h1> Detalles de la Compra
</h1>
<br><br>
<table class="table">
    <thead class="table-secondary">
        <tr>
            <th scope="col">Información de la compra</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row"> Número de factura </th>
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
        <tr>
            <th scope="row">Tipo de pago</th>
            <td scope="col">
                @if ($compra->PagoCompra)
                    Al crédito
                @else
                    Al contado
                @endif    
            </td>
        </tr>
        <tr>
            <th scope="row">Fecha de pago</th>
            <td scope="col">
                @if ($compra->FechaPago != null)
                    {{\Carbon\Carbon::parse($compra->FechaPago)->locale("es")->isoFormat("DD MMMM, YYYY")}} 
                @else
                    --
                @endif
            </td>
        </tr>

    </tbody>
</table>

<table class="table table-bordered border-dark mt-3" >
    <thead class="table table-striped table-hover">
        <tr class="success">
            <th scope="col">N°</th>
            <th scope="col">Producto</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio unitario</th>
            <th scope="col">Total compra</th>
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

    <tr>
        <th scope="row"></th>
        <th scope="col">Subtotal</th>
        <th scope="col">{{ $totalC }}</th>
        <td scope="col"></td>
        <th scope="col">{{ $totalP }}</th>
    </tr>
    <tr>
        <th scope="row"></th>
        <th scope="row" >Impuesto</th>
        <th scope="row"></th>
        <th scope="row"></th>
        <th scope="row">{{ $compra->TotalImpuesto }} </th>
    </tr>
    <tr>
        <th scope="row"></th>
        <th scope="row" >Total</th>
        <th scope="row"></th>
        <th scope="row"></th>
        <th scope="row" >{{ $compra->TotalImpuesto +  $totalP}} </th>
    </tr>
    </tbody>
</table>

<a class="btn btn-primary" href="{{route('compra.index')}}"> Regresar </a>
@endsection

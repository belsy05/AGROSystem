@extends('Plantillas.plantilla')

@section('titulo', 'Detalles')
@section('contenido')
@if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif
    <br>

    <h1 class=""> Precios De Venta Para El Producto: {{$nombre}}</h1>
    <br>
    <br>

    <table class="table table-bordered border-dark mt-3" >
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Presentación</th>
                <th scope="col">Precio de venta</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($precios as $i => $precio)
            <tr class="active">
                <th scope="row">{{ ($i+1) }}</th>
                <td scope="col">{{ $precio->presentacion->informacion}}</td>
                <td scope="col">{{ $precio->Precio }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4"> No hay productos por vencer </td>
            </tr>
        @endforelse

        </tbody>
    </table>

    <br>
    <br>
    <h1 class=""> Proximas Fechas De Vencimiento</h1>
    <br>
    <br>

    <table class="table table-bordered border-dark mt-3" >
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Presentación</th>
                <th scope="col">Fecha de vencimiento</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($vencimientos as $i => $vencimiento)
            <tr class="active">
                <th scope="row">{{ ($i+1) }}</th>
                <td scope="col">{{ $vencimiento->presentacion->informacion}}</td>
                <td scope="col">{{ $vencimiento->fecha_vencimiento }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4"> No hay compras </td>
            </tr>
        @endforelse

        </tbody>
    </table>

    <a href="{{route('inventario.index')}}" class="btn btn-primary">Regresar</a>

@endsection
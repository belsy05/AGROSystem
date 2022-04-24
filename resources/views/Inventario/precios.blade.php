@extends('Plantillas.plantilla')
@section('titulo', 'Precios')
@section('contenido')
@if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif
    <br>

    <h1 class=""> Precios Del Producto: {{$nombre}}</h1>
    <br>
    <br>

    <table class="table table-bordered border-dark mt-3" >
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Fecha de la compra</th>
                <th scope="col">Presentación</th>
                <th scope="col">Precio de compra</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($precios as $i => $precio)
            <tr class="active">
                <th scope="row">{{ ($i+1) }}</th>
                <td scope="col">{{\Carbon\Carbon::parse($precio->FechaCompra)->locale("es")->isoFormat("DD MMMM, YYYY")}}</td>
                <td scope="col">{{ $precio->presentacion->informacion}}</td>
                <td scope="col">{{ $precio->Precio_compra }}</td>
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